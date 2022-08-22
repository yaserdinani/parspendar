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
    Route::get('/auth/logout',[App\Http\Controllers\panel\AuthController::class,'logout'])->name('auth.logout');
    Route::resource('tasks',App\Http\Controllers\panel\TaskController::class);
    Route::post('/task/filter',[App\Http\Controllers\panel\TaskController::class,"filter"])->name('tasks.filter');
    Route::resource('users',App\Http\Controllers\panel\UserController::class);
    Route::post('/user/filter',[App\Http\Controllers\panel\UserController::class,"filter"])->name('users.filter');
    // livewire Routes
    Route::get('/livewire/tasks',App\Http\Livewire\Task\Index::class)->name('livewire.tasks.index');
    Route::get('/livewire/users',App\Http\Livewire\User\Index::class)->name('livewire.users.index');
    Route::get('/livewire/statuses',App\Http\Livewire\Taskstatus\Index::class)->name('livewire.status.index');
    Route::get('/livewire/roles',App\Http\Livewire\Role\Index::class)->name('livewire.roles.index');
    Route::get('/livewire/permissions',App\Http\Livewire\Permission\Index::class)->name('livewire.permissions.index');
    Route::get('/livewire/calender',App\Http\Livewire\Calender\Index::class)->name('livewire.calenders.index');
    Route::get('/livewire/notifications',App\Http\Livewire\Notification\Index::class)->name('livewire.notifications.index');
    Route::get('/livewire/comments/{task}',App\Http\Livewire\Comment\Index::class)->name('livewire.comments.index');
});

