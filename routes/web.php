<?php

use App\Http\Controllers\Management\PermissionController;
use App\Http\Controllers\Management\RoleController;
use App\Http\Controllers\Management\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');




Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    // user route
    Route::resource('users', UserController::class);

    Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::post('/profile', [UserController::class, 'postProfile'])->name('user.postProfile');

    Route::get('/password/change', [UserController::class, 'getPassword'])->name('userGetPassword');
    Route::post('/password/change', [UserController::class, 'postPassword'])->name('userPostPassword');
});


// permission and roles
Route::group(['middleware' => ['auth', 'role_or_permission:admin|create-role|create-permission']], function () {

    Route::resource('permissions', PermissionController::class);
    Route::resource('roles', RoleController::class);
});
