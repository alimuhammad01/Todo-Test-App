<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;

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

//user protected routes
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [UserController::class, 'index'])->name('user_dashboard')->middleware(['auth', 'user']);
Route::get('/task', [UserController::class, 'add'])->middleware(['auth', 'user']);
Route::post('/task', [UserController::class, 'create'])->middleware(['auth', 'user']);
Route::post('/task/{task}', [UserController::class, 'delete'])->middleware(['auth', 'user']);
Route::post('/update_task_status', [UserController::class, 'updateStatus'])->middleware(['auth', 'user']);


// admin protected routes
Route::get('/admin', [AdminController::class, 'index'])->name('admin_dashboard')->middleware(['auth', 'admin']);
Route::post('/admin/update_task_status', [AdminController::class, 'updateStatus'])->middleware(['auth', 'admin']);
Route::post('admin/task/{task}', [AdminController::class, 'delete'])->middleware(['auth', 'admin']);

