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

    Route::group(['middleware' => ['auth', 'user-access:admin'], 'prefix' => 'admin'], function () {
        Route::get('/', [App\Http\Controllers\Users\AdminController::class, 'index'])->name('admin.dashboard');
        Route::get('/manage', [App\Http\Controllers\Users\AdminController::class, 'manage'])->name('admin.manageUser');
        Route::get('/manage/addUser', [App\Http\Controllers\Users\AdminController::class, 'addUser'])->name('admin.addUser');
        // Route::get('/admin/manage/{id}/edit', [App\Http\Controllers\Users\AdminController::class, 'editUser'])->name('admin.editUser');
        // Route::post('/admin/manageUser/{id}', [App\Http\Controllers\Users\AdminController::class, 'updateUser'])->name('admin.updateUser');
        Route::post('/manage/delete/{id}', [App\Http\Controllers\Users\AdminController::class, 'destroyUser'])->name('admin.destroyUser');
        Route::resource('/manage/user', App\Http\Controllers\Users\AdminController::class)->except(['index', 'destroy']);


        //Kelas
        Route::get('/class', [App\Http\Controllers\Users\KelasController::class, 'manage'])->name('classes.manageClass');
        Route::get('/class/addClass', [App\Http\Controllers\Users\KelasController::class, 'showAddClass'])->name('classes.showAddClasses');
        Route::get('/class/addClass/import', [App\Http\Controllers\Users\KelasController::class, 'showImport'])->name('classes.showImport');
        Route::post('/class/addClass', [App\Http\Controllers\Users\KelasController::class, 'AddClasses'])->name('classes.AddClasses');
        Route::post('/class/delete/{id}', [App\Http\Controllers\Users\KelasController::class, 'destroyKelas'])->name('classes.destroyKelas');
        Route::post('/class/addClass/import', [App\Http\Controllers\Users\KelasController::class, 'import_excel'])->name('classes.importExcel');
        Route::resource('/class', App\Http\Controllers\Users\KelasController::class)->except(['index', 'destroy', 'create']);
    });

    Route::group(['middleware' => ['auth', 'user-access:wali']], function () {
        Route::get('/Wali', [App\Http\Controllers\Users\WaliController::class, 'index'])->name('wali.dashboard');
    });
});
