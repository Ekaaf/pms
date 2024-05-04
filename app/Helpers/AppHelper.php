<?php // Code within app\Helpers\Helper.php

// namespace App\Helpers;
use App\Service\MenuService;

function formErrorMessage($errors)
{   
    $message = "";
    $i = 0;
    foreach ($errors->all() as $error){
        if($i>0){
            $message .="<br>";
        }
        $message .= $error;
        $i++;
    }
    $message = '<div class="alert alert-danger alert-dismissible bg-danger text-white alert-label-icon fade show" role="alert">
                    <i class="ri-error-warning-line label-icon"></i>'.$message.
                    '<button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
    return $message;
}

function inputErrorMessage($input){
    $errorMessage =[
        'email' => 'Please enter a valid email address',
        'password' => 'Please enter password',
    ];
    return $errorMessage[$input];
}

function checkButtonAccess($path){
// dd($menuAccess);
    if(Auth::user()->role_id == 1){
        return 1;
    }
    else{
        $menuAccess = Session::get('menuAccess');
        if(in_array($path, $menuAccess)){
            return 1;
        }
        else{
            return 0;
        }
    }
    
}


function createMenu(){
    $currentRoute = \Route::getCurrentRoute()->uri();
    $basePath = url('/');
    $menuService = new MenuService();

    // $menuTree = $menuService->menuTreebyAccess();
    $menuTree = Session::get('menuTree');
    if(is_null($menuTree)){
        $menuTree = $menuService->menuTreebyAccess();
        Session::put('menuTree', $menuTree);
    }
    
    $menuString = "";
    $breadcrumb = "";
    $currentMenu = "";
    $currentPage = "";
    $currentIcon = "";
    $subpage = "";
    // dd($menuTree);
    foreach ($menuTree as $menu) {
        $active = "";
        if(array_key_exists("child",$menu)){
            $sub = "treeview";
            $subString = "";
            foreach ($menu['child'] as $child) {
                $active = "";
                $method_paths = explode(",", $child['method_paths']);
                $method_name = explode(",", $child['method_name']);
                // if(in_array($currentRoute, $method_paths)){
                $position = array_search($currentRoute, $method_paths);
                if($position !==false){
                    $currentMenu = $child;
                    $active = 'active';
                    $sub = "show";
                    $subpage = $method_name[$position];
                }
                
                if (strpos($child['path'], 'http://') !== false) {
                    $link = $child['path'];
                }
                else{
                    $link = $basePath.'/'.$child['path'];
                }
                $subString .= '<li class="nav-item">
                                <a class="nav-link '.$active.'" href="'.$link.'">
                                    '.$child['icon'].' '.$child['title'].'
                                </a>
                            </li>';
                
            }
            $parentMenu = '<li class="nav-item">
                        <a class="nav-link menu-link collapsed '.$active.'" href="#'.$menu['parent']['title'].'" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="'.$menu['parent']['title'].'">
                            '.$menu['parent']['icon'].'</i>
                            <span> '.$menu['parent']['title'].'</span>
                        </a><div class="menu-dropdown collapse '.$sub.'" id="'.$menu['parent']['title'].'">
                        <ul class="nav nav-sm flex-column">';

            $menuString .= $parentMenu.$subString."</ul></div><li>";
        }
        else{
            // if($currentRoute == $menu['parent']['path']){
            $method_paths = explode(",", $menu['parent']['method_paths']);
            $method_name = explode(",", $menu['parent']['method_name']);
            $position = array_search($currentRoute, $method_paths);
            if($position !==false){
                $active = ' active';
                $currentMenu = $menu['parent'];
                $subpage = $method_name[$position];
            }
            $menuString .= '<li class="nav-item"><a class="nav-link menu-link '.$active.'" href="'.$basePath.'/'.$menu['parent']['path'].'">'.$menu['parent']['icon'].'</i></i><span> '.$menu['parent']["title"].'</span></a></li>';
        }
    }
    $menuString .= '<li class="nav-item"><a class="nav-link menu-link" href="'.$basePath.'/logout">Logout</a></li>';
    // dd($currentMenu);
    $data['menuString'] = $menuString;
    if(is_array($currentMenu)){
        if(null !== $currentMenu['parent_id']){
            $breadcrumb .= '<li><a href="#"><i class="fa fa-dashboard"></i>'.$menuTree[$currentMenu['parent_id']]['parent']['icon'].' '.$menuTree[$currentMenu['parent_id']]['parent']['title'].'</a></li>';
            $breadcrumb .= '<li class="active">'.$currentMenu['icon'].' '.$currentMenu['title'].'</li>';
        }
        else{
            $breadcrumb .= '<li class="active">'.$currentMenu['icon'].' '.$currentMenu['title'].'</li>';
        }
        $currentPage = $currentMenu['title'];
        $currentIcon = $currentMenu['icon'];
        $menuAccess = Session::get('menuAccess');
        // dd($currentMenu);
        if($currentMenu['path'] != $currentRoute){
            $subpage = ' >  '.$subpage;
        }
        else{
            $subpage = "";
        }
    }

    // dd($breadcrumb);

    $data['breadcrumb'] = $breadcrumb;
    $data['currentPage'] = $currentPage;
    $data['currentIcon'] = $currentIcon;
    $data['subpage'] = $subpage;
    // $data['menuTree'] = $menuTree;
    return $data;
}

function allowedRoutesForAll(){
    $routes = [];
    array_push($routes, 'admin/stop-acting-as-user');
    return $routes;
}

function numberOfBeds($value = ""){
    $arr =[
        '1' => '1 bed',
        '2' => '2 bed'
    ];
    if($value !=''){
        return $arr[$value];
    }
    else{
        return $arr;
    }
}

function randomPassword($length) {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < $length; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}