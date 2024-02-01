<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;

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
Route::get('/login',[AuthController::class, 'login'])->name('Pms.login');
Route::post('/post-login',[AuthController::class, 'postLogin'])->name('Pms.post-login');
Route::get('/signup',[AuthController::class, 'signup'])->name('Pms.signup');
Route::get('/forget-password',[AuthController::class, 'forgetPassword'])->name('Pms.forget-password');
Route::get('/logout',[AuthController::class, 'logout'])->name('Pms.logout');
// end auth routes

Route::group(['prefix' => 'admin', 'middleware' => ['admin']], function () {
	Route::get('/dashboard',[DashboardController::class, 'dashboard'])->name('Pms.dashboard');
});