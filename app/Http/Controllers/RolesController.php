<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RolesController extends Controller
{
    
    public function rolesList(Request $request){
        $roles = Role::all();
        return view('settings.role_list', compact('roles'));
    }


    public function deleteRole(Request $request){
        $success = Role::where('id', $request->id)->delete();
        return $success;
    }


    public function saveRole(Request $request){
        
        $validator = \Validator::make($request->all(), [
                'name' => 'required|unique:roles'
            ],
            [
                'name.required' => 'Please Enter Role',
                'name.unique' => 'Role already exists'
            ]
        );
        if ($validator->fails()) {
            return redirect('admin/roles')->withErrors($validator)->withInput();
        }
        $role = new Role();
        $role->name = $request->name;
        $role->created_by = Auth::user()->id;
        $success = $role->save();
        return redirect('admin/roles')->with('success', "Role Saved Successfully");
    }

    public function EditRole(Request $request, $id){
        $role = Role::find($id);
        return response()->json($role);
    }

    public function updateRole(Request $request, $id){
        
        $validator = \Validator::make($request->all(), [
                'name' => 'required|unique:roles,name,'.$id
            ],
            [
                'name.required' => 'Please Enter Role',
                'name.unique' => 'Role already exists'
            ]
        );
        if ($validator->fails()) {
            return redirect('admin/roles')->withErrors($validator)->withInput();
        }

        $success = Role::where('id', $id)->update(['name' => $request->input('name')]);

        return redirect('admin/roles')->with('success', "Role Updated Successfully ");
    }

    public function userList(Request $request){
        $roles = Role::all();
        return view('settings.user_list');
    }
}
