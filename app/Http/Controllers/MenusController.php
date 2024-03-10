<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service\MenuService;
use App\Models\Menu;
use App\Http\Requests\MenuPostRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\MenuMethod;
use DB;
use App\Models\UserAccess;
// use App\Models\User;
// use App\Models\Role;
// use App\Models\Approver;
// use App\Models\Menu;
// use App\Models\MenuMethod;
// use App\Models\UserAccess;
// use App\Models\CandidateReqApproval;
// use App\Models\AdmissionHistory;
// use App\Models\Candidate;
// use App\Models\AdmissionInfoTemp;
// use App\Service\MenuService;
// use Illuminate\Http\Request;
// use App\Http\Controllers\Controller;
// use App\Http\Requests\MenuPostRequest;
// use DB;
// use App\SSP;
// use Illuminate\Support\Facades\Auth;

class MenusController extends Controller
{
    public function __construct(){
        $this->menuService = new MenuService();
    }
    public function menusList(Request $request){
        $menuTree = $this->menuService->menuTree();
        // dd($menuTree);
        return view('settings.menu_list')->with('menuTree', $menuTree);
    }

    public function menuAdd(Request $request){
        $paths = $this->menuService->getAllRoutes();
        $menus = Menu::where('parent_id', NULL)->get();
        return view('settings.menu_add')->with('menus', $menus)->with('paths', $paths);
    }

    public function menuSave(MenuPostRequest $request){

        $menu = new Menu();
        $menu->title = $request->title;
        $menu->icon = $request->icon;
        $menu->parent_id = $request->parent_id;
        if($request->menu_path){
            $menu->path = $request->menu_path;
        }
        $menu->active = 1;
        $menu->created_by = Auth::user()->id;
        if($request->default){
            $menu->default = $request->default;
        }
        $success = $menu->save();
        $menuMethod = [];
        $i = 0;
        $method_name = $request->method_name;
        $path = $request->path;

        if(null !== $method_name[0]){
            foreach ($path as $p){
                $menuMethod[$i]['menu_id'] = $menu->id;
                $menuMethod[$i]['method_name'] = $method_name[$i];
                $menuMethod[$i]['path'] = $path[$i];
                if($request->default){
                    $menuMethod[$i]['default'] = $request->default;
                }
                if($request->menu_path == $path[$i]){
                    $menuMethod[$i]['type'] = 1;
                }
                else{
                    $menuMethod[$i]['type'] = 0;
                }
                $i++;
            }
        }
        else{
            $menuMethod[$i]['menu_id'] = $menu->id;
            $menuMethod[$i]['method_name'] = "";
            $menuMethod[$i]['path'] = "";
            if($request->default){
                $menuMethod[$i]['default'] = $request->default;
            }
            $menuMethod[$i]['type'] = 1;
        }
        
        MenuMethod::insert($menuMethod);

        if($success){
            return redirect('admin/menus/menu-add')->with('success', "Successfully Saved");
        }
        else{
            return redirect('admin/menus/menu-add')->with('error', "Couldn't save!")->withInput();
        }
    }

    public function deleteMenu(Request $request){
        $success = Menu::where('id', $request->id)->delete();
        return $success;
    }

    public function menuEdit(Request $request, $id){
        $menuCurrent = DB::table('menus')
                        ->select('menus.*','menu_methods.id as menu_methods_id','menu_methods.method_name', 'menu_methods.path as menu_path')
                        ->leftjoin('menu_methods','menus.id','=','menu_methods.menu_id')
                        ->where('menus.id', $id)
                        ->get()->toArray();
        $paths = $this->menuService->getAllRoutes();
        $menus = Menu::where('parent_id', NULL)->get();
        return view('settings.menu_edit')->with('menuCurrent', $menuCurrent)->with('menus', $menus)->with('paths', $paths);
    }

    public function menuUpdate(MenuPostRequest $request, $id){
        DB::beginTransaction();

        try {
            $menu = Menu::find($id);
            $menu->title = $request->title;
            $menu->icon = $request->icon;
            $menu->parent_id = $request->parent_id;
            if($request->menu_path){
                $menu->path = $request->menu_path;
            }
            
            if($request->default){
                $menu->default = $request->default;
            }
            else{
                $menu->default = 0;
            }
            $menu->active = 1;
            $success = $menu->save();
            
            $menu_methods_id = $request->menu_methods_id;
            $method_name = $request->method_name;
            $path = $request->path;
            $i = 0;
            
            $methodIDS = MenuMethod::where('menu_id', $id)->pluck('id')->toArray();
            foreach ($methodIDS as $id) {
                if(in_array($id, $menu_methods_id)){
                    $menuMethod = MenuMethod::find($id);
                    $menuMethod->method_name = $method_name[$i];
                    $menuMethod->path = $path[$i];

                    if($request->default){
                        $menuMethod->default = $request->default;
                    }
                    else{
                        $menuMethod->default = 0;
                    }
                    if($request->menu_path == $path[$i]){
                        $menuMethod->type = 1;
                    }
                    else{
                        $menuMethod->type = 0;
                    }
                    $menuMethod->save();
                    $i++;
                }
                else{
                    MenuMethod::where('id', $id)->delete();
                }
                    
            }

            $j = 0;
            foreach ($menu_methods_id as $id) {
                if(is_null($id)){
                    $menuMethod = new MenuMethod();
                    $menuMethod->menu_id = $menu->id;
                    $menuMethod->method_name = $method_name[$j];
                    $menuMethod->path = $path[$i];
                    if($request->default){
                        $menuMethod->default = $request->default;
                    }
                    else{
                        $menuMethod->default = 0;
                    }
                    if($request->menu_path == $path[$j]){
                        $menuMethod->type = 1;
                    }
                    else{
                        $menuMethod->type = 0;
                    }
                    $menuMethod->save();
                }
                $j++;
            }

            DB::commit();

            return redirect('admin/menus')->with('success', "Updated Successfully");

        } catch (\Exception $e) {
            DB::rollback();
            return redirect('admin/menus')->with('error', "Couldn't update!")->withInput();
        }
    }


    
    public function userAccess(Request $request, $id){
        $userAccess = $this->menuService->getUserAccessTree();
        $menuAccess = UserAccess::where('role_id',$id)->pluck('menu_method_id')->toArray();
        $roleName = Auth::user()->role_id;
        return view('settings.user_access')->with('userAccess', $userAccess)->with('menuAccess', $menuAccess)->with('roleName', $roleName);
    }

    public function userAccessSave(Request $request, $id){
        $created_at = date('Y-m-d H:i:s');
        $data = [];
        $i = 0;
        if(!is_null($request->input('menu_id'))){
            $menus = array_unique($request->input('menu_id'));
            foreach($menus as $menu){
                if(!is_null($menu)){
                    $data[$i]['menu_method_id'] = $menu;
                    $data[$i]['role_id'] = $id;
                    $data[$i]['created_at'] = $created_at;
                    $i++;
                }
            }
        }
        UserAccess::where('role_id', $id)->delete();
        UserAccess::insert($data);
        
        return redirect('admin/roles')->with('success', "Permissions Updated Successfully");
    }
}
