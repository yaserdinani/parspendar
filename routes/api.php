<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login',[App\Http\Controllers\api\AuthController::class,'login']);

Route::group(["middleware"=>"jwt.verify"],function(){
    Route::post('/logout',[App\Http\Controllers\api\AuthController::class,'logout']);
    Route::get('/users',[App\Http\Controllers\api\UserController::class,'index']);
    Route::get('/users/{id}',[App\Http\Controllers\api\UserController::class,'show']);
    Route::post('/users/create',[App\Http\Controllers\api\UserController::class,'store']);
    Route::put('/users/{id}/update',[App\Http\Controllers\api\UserController::class,'update']);
    Route::delete('/users/{id}/delete',[App\Http\Controllers\api\UserController::class,'destroy']);
});