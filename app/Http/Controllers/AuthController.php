<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;

// use Illuminate\Support\Facades\Redirect;
// use Illuminate\Support\Facades\Mail;
// use Session;

class AuthController extends Controller
{
    public function login(){
        // if(Auth::user()){
        //     return redirect()->intended('admin/dashboard');
        // }
        return view('auth.login');
    }


    public function forgetPassword(){
        return view('auth.forget_password');
    }

    public function signup(){
        return view('auth.signup');
    }


    public function postlogin(Request $request): RedirectResponse
    {   
        $email = $request->input('email');
        $password = $request->input('password');

        $messages = [
            'email' => inputErrorMessage('email'),
            'password' => inputErrorMessage('password'),
        ];
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ],$messages);
 
        if ($validator->fails()) {
            return redirect('login')
                        ->withErrors($validator)
                        ->withInput();
        }

        // $menuAccess = [];
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            // $menuAccess = $this->setMenuAccess(Auth::user()->role_id);
            // $request->session()->put('menuAccess', $menuAccess);
            return redirect()->intended('admin/dashboard');
        }
        else{
            $request->session()->flash('error', "Username or password do not match");
            return redirect('login');
        }

        
    }

    public function logout(){
        \Session::flush();
        Auth::logout();
        return redirect()->intended('login');
    }

    public function passwordReset(Request $request){
        return view('student.auth.email');
    }

    public function sendPassword(Request $request){
        $to_email = $request->email;
        $user = User::where('email', '=', $to_email)->orderBy('id', 'desc')->first();
        if(is_null($user)){
            return redirect()->back()->with("error", "We can't find a user with that e-mail address.")->withInput();
        }
        else{
            $data['name'] = $user->name;
            $data['password'] = $user->password;
            Mail::mailer('reset-pass')->send('student.auth.email_password', $data, function($message) use ($to_email) {
                $message->to($to_email)
                        ->subject('Forget Password');
                $message->from('no-reply1@northsouth.edu','NSU IT');
            });
            return redirect()->back()->with("success", "Password is sent to your email address.");
        }
    }

    public function actAsUser(Request $request, $id){
        if(Auth::user()->role_id == '1'){
            Session::forget('menuTree');
            Session()->put('prevUser', Auth::user());
            Auth::logout();

            $user = User::where('id', $id)->first();
            Auth::login($user);
            $menuAccess = $this->setMenuAccess(Auth::user()->role_id);
            $request->session()->put('menuAccess', $menuAccess);
            return redirect()->intended('admin/dashboard');
        }
        else{
            return redirect()->back()->with("error", "You are not permitted for this action");
        }
    }


    public function stopActingAsUser(Request $request){
        $prevUser = Session::get('prevUser');
        if(is_null($prevUser)){
            return redirect()->back()->with("error", "You are not permitted for this action");
        }
        else{
            if($prevUser->role_id == 1){
                Session::forget('menuTree');
                Session::forget('prevUser');
                Auth::logout();
                $user = User::where('id', $prevUser->id)->first();
                Auth::login($user);
                $menuAccess = $this->setMenuAccess(Auth::user()->role_id);
                $request->session()->put('menuAccess', $menuAccess);
                return redirect()->intended('admin/dashboard');
            }
            else{
                return redirect()->back()->with("error", "You are not permitted for this action");
            }
        }
    }

    public function setMenuAccess($roleName){
        // $roleID = Role::where('name', $roleName)->pluck('id')->first();
        $roleID = Auth::user()->role_id;
        $menuAccess = [];
        $menuAccessData = DB::table('menu_methods')
                            ->select('menu_methods.method_name','menu_methods.path')
                            ->leftjoin('user_access','menu_methods.id','=','user_access.menu_method_id')
                            ->leftjoin('menus','menus.id','=','menu_methods.menu_id')
                            ->where(['user_access.role_id' => $roleID])
                            ->where('menus.active', 1)
                            ->orWhere(function ($query) {
                                $query->where('menus.default', 1)
                                      ->orWhere('menu_methods.default', 1);
                            })
                            ->get()->toArray();
        foreach ($menuAccessData as $data) {
            $menuAccess[] = $data->path;
        }
        $menuAccess = array_merge($menuAccess,allowedRoutesForAll());
        return $menuAccess;
    }

    public function loginWithGmail($value=''){
        $client = new \Google_Client();
        $client->setClientId("609011195836-mr9ee75t6u60pqjnl6v3o5vu0oc61djn.apps.googleusercontent.com");
        $client->setClientSecret("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");
        $client->setAccessToken("ya29.a0ARrdaM_rcNnZQUx8mma5Znk9YNyeFIRCW53MH1Jvgcdwa2s4DR5_Ik2zBBW5YXR9CqG5qmQhCkhfeTIwiCqx7n9-Xyctgd0EL1k99hqn5uESz8AqqGhlK0HYhfLBAUuy74GaR0EQU0qb_YMt_8fR8DKiTN3N");
        $client->addScope("email");
        $client->addScope("profile");

        $google_oauth = new \Google_Service_Oauth2($client);
        $google_account_info = $google_oauth->userinfo->get();
    }
}