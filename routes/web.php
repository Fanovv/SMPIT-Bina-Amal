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



Route::group(['middleware' => 'revalidate'], function () {
    Route::get('/', [App\Http\Controllers\LoginController::class, 'showLoginForm'])->name('loginform');
    Route::post('/login', [App\Http\Controllers\LoginController::class, 'login'])->name('login');
    Route::get('/logout', [App\Http\Controllers\LoginController::class, 'logout'])->name('logout');

    Route::group(['middleware' => ['auth', 'user-access:admin']], function () {
        Route::get('/admin', [App\Http\Controllers\Users\AdminController::class, 'index'])->name('admin.dashboard');
    });

    Route::group(['middleware' => ['auth', 'user-access:wali']], function () {
        Route::get('/Wali', [App\Http\Controllers\Users\WaliController::class, 'index'])->name('wali.dashboard');
    });
});
