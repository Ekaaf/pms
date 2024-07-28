<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenusController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\RoomCategoriesController;
use App\Http\Controllers\RoomsController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ReportController;

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
	Route::get('/room-category/view/{id}',[RoomCategoriesController::class, 'roomCategoryView'])->name('Pms.RoomCategoryView');


	// Rent of Room Category
	Route::get('/room-category-rent/add',[RoomCategoriesController::class, 'roomCategoryRentAdd'])->name('Pms.RoomCategoryRentAdd.View');
	Route::post('/room-category-rent/add',[RoomCategoriesController::class, 'roomCategoryRentSave'])->name('Pms.RoomCategoryRentAdd');
	Route::get('/room-category-rent/edit/{id}',[RoomCategoriesController::class, 'roomCategoryRentEdit'])->name('Pms.RoomCategoryRentEdit.View');
	Route::post('/room-category-rent/edit/{id}',[RoomCategoriesController::class, 'roomCategoryRentUpdate'])->name('Pms.RoomCategoryRentEdit');
	Route::post('/room-category-rent/delete/{id}',[RoomCategoriesController::class, 'roomCategoryRentDelete'])->name('Pms.RoomCategoryRentDelete');
	Route::get('/room-category-rent',[RoomCategoriesController::class, 'roomCategoryRentList'])->name('Pms.RoomCategoryRentList.View');
	Route::post('/room-category-rent',[RoomCategoriesController::class, 'getAllroomCategoriesRent'])->name('Pms.RoomCategoryRentList');
	// Route::get('/room-category/view/{id}',[RoomCategoriesController::class, 'roomCategoryView'])->name('Pms.RoomCategoryView');



	// Room
	Route::get('/rooms/add',[RoomsController::class, 'roomAdd'])->name('Pms.RoomAdd.View');
	Route::post('/rooms/add',[RoomsController::class, 'roomAddSave'])->name('Pms.RoomAdd');
	Route::get('/rooms',[RoomsController::class, 'roomsList'])->name('Pms.RoomList.View');
	Route::post('/rooms',[RoomsController::class, 'getAllRoomS'])->name('Pms.RoomList');


	// Reservation
	Route::get('/reservation',[ReservationController::class, 'reservation'])->name('Pms.Reservation.View');
	Route::post('/search-room-category',[ReservationController::class, 'searchRoomCategory'])->name('Pms.SearchRoomCategory');
	Route::post('/book-room-temp',[ReservationController::class, 'bookRoomTemp'])->name('Pms.BookRoomTemp');
	Route::get('/billing-info',[ReservationController::class, 'billingInfo'])->name('Pms.BillingInfo');
	Route::post('/confirm-booking',[ReservationController::class, 'confirmBooking'])->name('Pms.ConfirmBooking');
	Route::post('/get-user-info',[ReservationController::class, 'getUserInfo'])->name('Pms.GetUserInfo');

	// check in 
	Route::get('/check-in',[ReservationController::class, 'checkInList'])->name('Pms.CheckInList.View');
	Route::post('/check-in',[ReservationController::class, 'getAllCheckInList'])->name('Pms.CheckInList');
	Route::post('/check-in-change-people',[ReservationController::class, 'changeNoOfPeople'])->name('Pms.ChangeNoOfPeople');
	Route::get('/check-in-complete/{id}',[ReservationController::class, 'checkInView'])->name('Pms.CheckIn.View');
	Route::post('/check-in-complete/{id}',[ReservationController::class, 'checkInComplete'])->name('Pms.CheckIn');


	// check out 
	Route::get('/check-out',[ReservationController::class, 'checkOutList'])->name('Pms.CheckOutList.View');
	Route::post('/check-out',[ReservationController::class, 'getAllCheckOutList'])->name('Pms.CheckOutList');
	Route::get('/check-out-complete/{id}',[ReservationController::class, 'checkOutView'])->name('Pms.CheckOut.View');
	Route::post('/check-out-complete/{id}',[ReservationController::class, 'checkOutComplete'])->name('Pms.CheckOut');


	// stay view
	Route::get('/stay-view',[ReservationController::class, 'stayView'])->name('Pms.StayViewList.View');
	Route::post('/stay-view',[ReservationController::class, 'getAllStayView'])->name('Pms.StayViewList');

	// room view
	Route::get('/room-view',[ReservationController::class, 'roomView'])->name('Pms.RoomViewList.View');
	Route::post('/room-view',[ReservationController::class, 'getAllRoomView'])->name('Pms.RoomViewList');


	Route::group(['prefix' => 'report'], function () {
		Route::get('/room-wise-report',[ReportController::class, 'roomWiseReportView'])->name('Pms.RoomWiseReport.View');
		Route::post('/room-wise-report',[ReportController::class, 'roomWiseReportList'])->name('Pms.RoomWiseReport');
	});
});