<?php

use Illuminate\Support\Facades\Route;
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



Route::group(['middleware' => 'revalidate'], function () {
    Route::get('/', [App\Http\Controllers\LoginController::class, 'showLoginForm'])->name('loginform');
    Route::post('/login', [App\Http\Controllers\LoginController::class, 'login'])->name('login');
    Route::get('/logout', [App\Http\Controllers\LoginController::class, 'logout'])->name('logout');

    Route::group(['middleware' => ['auth', 'user-access:admin']], function () {
        Route::get('/admin', [App\Http\Controllers\Users\AdminController::class, 'index'])->name('admin.dashboard');
    });

    Route::group(['middleware' => ['auth', 'user-access:bk']], function () {
        Route::get('/BK', [App\Http\Controllers\Users\BKController::class, 'index'])->name('bk.dashboard');
    });

    Route::group(['middleware' => ['auth', 'user-access:tu']], function () {
        Route::get('/TU', [App\Http\Controllers\Users\TUController::class, 'index'])->name('tu.dashboard');
    });

    Route::group(['middleware' => ['auth', 'user-access:wali']], function () {
        Route::get('/Wali', [App\Http\Controllers\Users\WaliController::class, 'index'])->name('wali.dashboard');
    });

    Route::group(['middleware' => ['auth', 'user-access:guru']], function () {
        Route::get('/Guru', [App\Http\Controllers\Users\GuruController::class, 'index'])->name('guru.dashboard');
    });
});

Route::resource("users", UserController::class);
