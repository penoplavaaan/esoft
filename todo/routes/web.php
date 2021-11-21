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



Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/home/add', [App\Http\Controllers\HomeController::class, 'add'])->name('add');

Route::get('/add', [App\Http\Controllers\AddTaskController::class, 'create'])->name('addtask');

Route::get('/change_status', [App\Http\Controllers\AddTaskController::class, 'changeStatus'])->name('changeStatus');

Route::get('/cancel_task', [App\Http\Controllers\AddTaskController::class, 'cancelTask'])->name('cancelTask');

Route::get('/change_task', [App\Http\Controllers\AddTaskController::class, 'changeTask'])->name('cahangeTask');
