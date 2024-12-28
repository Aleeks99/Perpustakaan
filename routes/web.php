<?php

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\TransactionController;

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

Route::get('/user-profile/{id}', [App\Http\Controllers\MemberController::class, 'showProfile']);

Route::resource('/books', App\Http\Controllers\BookController::class);

Route::resource('/items', App\Http\Controllers\ItemsController::class);

Route::middleware('role:admin')->resource('/category', App\Http\Controllers\CategoryController::class);

// Route::resource('/collection', App\Http\Controllers\BookController::class, [
//     'except' => ['destroy']
// ]);
// Route::delete('/collection/{book}', [App\Http\Controllers\BookController::class, 'destroy']);

Route::resource('/profile', App\Http\Controllers\UserController::class);

Route::resource('/member', App\Http\Controllers\MemberController::class);

Route::middleware('role:admin')->resource('/classroom', App\Http\Controllers\ClassroomController::class);

Route::middleware('role:admin')->resource('/staff', App\Http\Controllers\StaffController::class);

Route::resource('/transaction', App\Http\Controllers\TransactionController::class);

Route::get('/log', [App\Http\Controllers\TransactionController::class, 'showLog']);

Route::get('/refresh', [App\Http\Controllers\TransactionController::class, 'refresh']);

Route::get('/return', [App\Http\Controllers\TransactionController::class, 'borrowedlist']);

Route::middleware('role:admin')->get('/setting', [App\Http\Controllers\SettingController::class, 'index'])->name('setting');

Route::middleware('role:admin')->put('/setting/update/{id}', [App\Http\Controllers\SettingController::class, 'update']);

Route::post('/return/{id}', [App\Http\Controllers\TransactionController::class, 'return']);

Route::post('/extend/{id}', [App\Http\Controllers\TransactionController::class, 'extend']);

Route::get('/search/{id}', [App\Http\Controllers\UserController::class, 'getname']);

Route::resource('/waiting', App\Http\Controllers\WaitingController::class);