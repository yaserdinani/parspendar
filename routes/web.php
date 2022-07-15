<?php

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
Route::get('/auth',[App\Http\Controllers\panel\AuthController::class,'index'])->name('auth.index');
Route::post('/auth/login',[App\Http\Controllers\panel\AuthController::class,'login'])->name('auth.login');

Route::group(["middleware"=>"auth"],function(){
    Route::get('/',[App\Http\Controllers\panel\DashboardController::class,'index'])->name('dashboard');
    Route::get('/users',[App\Http\Controllers\panel\UserController::class,'index'])->name('users.index');
    Route::get('/auth/logout',[App\Http\Controllers\panel\AuthController::class,'logout'])->name('auth.logout');
});
