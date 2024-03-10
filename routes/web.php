<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenusController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\RoomCategoriesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// auth routes
Route::get('/login',[AuthController::class, 'login'])->name('Pms.Login');
Route::post('/post-login',[AuthController::class, 'postLogin'])->name('Pms.PostLogin');
Route::get('/signup',[AuthController::class, 'signup'])->name('Pms.Signup');
Route::get('/forget-password',[AuthController::class, 'forgetPassword'])->name('Pms.ForgetPassword');
Route::get('/logout',[AuthController::class, 'logout'])->name('Pms.Logout');
// end auth routes

Route::group(['prefix' => 'admin', 'middleware' => ['admin']], function () {
	Route::get('/dashboard',[DashboardController::class, 'dashboard'])->name('Pms.Dashboard');

	// menus
	Route::get('/menus',[MenusController::class, 'menusList'])->name('Pms.MenuList');
	Route::get('/menus/menu-add',[MenusController::class, 'menuAdd'])->name('Pms.MenuAdd.View');
	Route::post('/menus/menu-add',[MenusController::class, 'menuSave'])->name('Pms.MenuAdd');
	Route::post('/menus/delete-menu',[MenusController::class, 'deleteMenu'])->name('Pms.MenuDelete');
	Route::get('/menus/menu-edit/{id}',[MenusController::class, 'menuEdit'])->name('Pms.MenuEdit.View');
	Route::post('/menus/menu-edit/{id}',[MenusController::class, 'menuUpdate'])->name('Pms.MenuEdit');

	// roles
	Route::get('/roles',[RolesController::class, 'rolesList'])->name('Pms.RolesList');
	Route::post('/roles/save-role',[RolesController::class, 'saveRole'])->name('Pms.AddRole');
	Route::post('/roles/edit-role/{id}',[RolesController::class, 'editRole'])->name('Pms.EditRole.View');
	Route::post('/roles/edit-role/{id}',[RolesController::class, 'updateRole'])->name('Pms.EditRole');
	Route::post('/roles/delete-role',[RolesController::class, 'deleteRole'])->name('Pms.DeleteRole');

	// UAC
	Route::get('/users/change-password',[UsersController::class, 'changePassword'])->name('Pms.ChangePassword.View');
	Route::post('/users/change-password',[UsersController::class, 'updatePassword'])->name('Pms.ChangePassword');
	Route::get('/user-access/{id}',[MenusController::class, 'userAccess'])->name('Pms.UserAccess.View');
	Route::post('/user-access/{id}',[MenusController::class, 'userAccessSave'])->name('Pms.UserAccess');

	// change password
	Route::get('/users/change-password/{id}',[UsersController::class, 'changePassword'])->name('Pms.ChangeUserPassword.View');
	Route::post('/users/change-password/{id}',[UsersController::class, 'updatePassword'])->name('Pms.ChangeUserPassword');

	// Users
	Route::get('/users/add',[UsersController::class, 'userAdd'])->name('Pms.UserAdd.View');
	Route::post('/users/add',[UsersController::class, 'userSave'])->name('Pms.UserAdd');
	Route::get('/users/edit/{id}',[UsersController::class, 'userEdit'])->name('Pms.UserEdit.View');
	Route::post('/users/edit/{id}',[UsersController::class, 'userUpdate'])->name('Pms.UserEdit');
	Route::post('/users/delete/{id}',[UsersController::class, 'userDelete'])->name('Pms.UserDelete');
	Route::get('/users',[UsersController::class, 'userList'])->name('Pms.UserList.View');
	Route::post('/users',[UsersController::class, 'getAllUsers'])->name('Pms.UserList');



	// Room Category
	Route::get('/room-category/add',[RoomCategoriesController::class, 'roomCategoryAdd'])->name('Pms.RoomCategoryAdd.View');
	Route::post('/room-category/add',[RoomCategoriesController::class, 'roomCategorySave'])->name('Pms.RoomCategoryAdd');
	Route::get('/room-category/edit/{id}',[RoomCategoriesController::class, 'roomCategoryEdit'])->name('Pms.RoomCategoryEdit.View');
	Route::post('/room-category/edit/{id}',[RoomCategoriesController::class, 'roomCategoryUpdate'])->name('Pms.RoomCategoryEdit');
	Route::post('/room-category/delete/{id}',[RoomCategoriesController::class, 'roomCategoryDelete'])->name('Pms.RoomCategoryDelete');
	Route::get('/room-category',[RoomCategoriesController::class, 'roomCategoryList'])->name('Pms.RoomCategoryList.View');
	Route::post('/room-category',[RoomCategoriesController::class, 'getAllroomCategories'])->name('Pms.RoomCategoryList');
});