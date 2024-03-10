<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserAddRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Support\Facades\Auth;
use App\SSP;
use Hash;

class UsersController extends Controller
{
    
    public function userList(Request $request){
        return view('users.user_list');
    }

    public function getAllUsers(Request $request){
        $table = 
            "(SELECT users.id as id, users.email, users.mobile, roles.name as role FROM users inner join roles on users.role_id = roles.id) testtable";

        $primaryKey = 'id';
        $columns = array(

            array( 'db' => 'id', 'dt' => 'id' ),

            array( 'db' => 'email', 'dt' => 'email' ),

            array( 'db' => 'mobile', 'dt' => 'mobile' ),

            array( 'db' => 'role', 'dt' => 'role' )
        );

        $database = config('database.connections.pgsql');

        $sql_details = array(
            'user' => $database['username'],
            'pass' => $database['password'],
            'db'   => $database['database'],
            'host' => $database['host']
        );
        // dd($sql_details);
        $result =  SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns);

        $start=$_REQUEST['start']+1;

        $idx=0;

        foreach($result['data'] as &$res){

            $res[0]=(string)$start;

            $start++;

            $idx++;

        }
        echo json_encode($result);

    }

    public function userAdd(Request $request){
        $roles = Role::all();
        return view('users.user_add')->with('roles', $roles);
    }

    public function userSave(UserAddRequest $request){
        // if($request->username != $request->emp_id){
        //     return redirect()->back()->with('error', "Username and Employee ID must be same")->withInput();
        // }
        $user = new User();
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->password = \Hash::make($request->password);
        $user->role_id = $request->role_id;
        $success = $user->save();
        
        if($success){
            return redirect('admin/users')->with('success', "Successfully Saved");
        }
        else{
            return redirect()->back()->with('error', "Couldn't save!")->withInput();
        }
    }

    public function userEdit(Request $request, $id){
        $user = User::where('id',$id)->first();
        $roles = Role::all();
        return view('users.user_edit')->with('roles', $roles)->with('user', $user);
    }

    public function userUpdate(UserUpdateRequest $request, $id){
        $user = User::find($id);
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->role_id = $request->role_id;
        $success = $user->save();

        
        if($success){
            return redirect('admin/users')->with('success', "Successfully Updated");
        }
        else{
            return redirect()->back()->with('error', "Couldn't Update!")->withInput();
        }
    }

    public function userDelete(Request $request, $id){
        $success = User::where('id', $request->id)->delete();
        return $success;
    }

    public function changePassword(Request $request, $id=""){
        return view('users.change_password')->with('id', $id);
    }

    public function updatePassword(ChangePasswordRequest $request, $id=''){
        $type = "admin";
        $notMatch = 0;
        if($id == ""){
            $id = Auth::user()->id;
            $type = 'self';
        }
        $user = User::where('id', '=', $id)->first();
        if($type == 'admin'){
            $user->password = \Hash::make($request->password);;
            $success = $user->save();
        }
        else{
            if(Hash::check($request->input('old_password'), $user->getAuthPassword())){
                $user->password = \Hash::make($request->password);
                $success = $user->save();
            }
            else{
                $notMatch = 1;
            }
        }

        if($notMatch == 1){
            return redirect()->back()->with('error', "Old password does not match")->withInput();
        }
        else{
            if($success){
                if(Auth::user()->role == 'administrator'){
                    return redirect('admin/users')->with('success', "Successfully updated password");
                }
                else{
                    return redirect()->back()->with('success', "Successfully updated password");
                }
            }
            else{
                return redirect()->back()->with('error', "Couldn't update!")->withInput();
            }
        }
        
        
        
    }

}
