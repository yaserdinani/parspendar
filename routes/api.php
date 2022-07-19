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
    // user routes
    Route::group(["middleware"=>"admin"],function(){
        Route::get('/users',[App\Http\Controllers\api\UserController::class,'index']);
        Route::get('/users/{user}',[App\Http\Controllers\api\UserController::class,'show']);
        Route::post('/users/create',[App\Http\Controllers\api\UserController::class,'store']);
        Route::put('/users/{user}/update',[App\Http\Controllers\api\UserController::class,'update']);
        Route::delete('/users/{user}/delete',[App\Http\Controllers\api\UserController::class,'destroy']);
        // task route
        Route::delete('/tasks/{user}/delete',[App\Http\Controllers\api\TaskController::class,'destroy']);
    });
    // task routes
    Route::get('/tasks',[App\Http\Controllers\api\TaskController::class,'index']);
    Route::get('/tasks/{id}',[App\Http\Controllers\api\TaskController::class,'show']);
    Route::post('/tasks/create',[App\Http\Controllers\api\TaskController::class,'store']);
    Route::put('/tasks/{id}/update',[App\Http\Controllers\api\TaskController::class,'update']);
    Route::post('/task/filter',[App\Http\Controllers\api\TaskController::class,'filter']);
});