<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {   
        if (Auth::check()){
            return $next($request);
            // if (Auth::user()->role_id == 1){
            //     return $next($request);
            // }
            // else if (Auth::user()->role_id == Role::where('name','Candidate')->pluck('id')->first()){
            //     return redirect()->intended('logout');
            // }
            // else{
            //     $value = $request->session()->get('menuAccess');
            //     $currentPath = Route::getCurrentRoute()->uri();
            //     // dd($value);
            //     if(in_array($currentPath, $value)){
            //         return $next($request);
            //     }
            //     else{
            //         return redirect()->intended('error/permission-error');
            //     }
            // }
        }
        else{
            return redirect()->intended('login');
        }
        
    }
}
