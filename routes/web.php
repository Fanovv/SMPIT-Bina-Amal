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

        //Murid
        Route::get('/student', [App\Http\Controllers\Users\StudentController::class, 'showKelas'])->name('student.showKelas');
        Route::get('/student/manage/{id_kelas}', [App\Http\Controllers\Users\StudentController::class, 'manageStudent'])->name('student.manageStudent');
        Route::get('/student/manage/{id_kelas}/edit/{id_murid}', [App\Http\Controllers\Users\StudentController::class, 'editStudent'])->name('student.editStudent');
        Route::get('/student/addStudent', [App\Http\Controllers\Users\StudentController::class, 'showAddStudent'])->name('student.showAddStudent');
        Route::get('/student/addStudent/import', [App\Http\Controllers\Users\StudentController::class, 'showImport'])->name('student.showImport');
        Route::post('/student/checkKelas', [App\Http\Controllers\Users\StudentController::class, 'checkKelas'])->name('student.checkKelas');
        Route::put('/student/manage/{id_murid}/update', [App\Http\Controllers\Users\StudentController::class, 'updateStudent'])->name('student.updateStudent');
        Route::post('/student/manage/delete/{id_murid}', [App\Http\Controllers\Users\StudentController::class, 'destroyStudent'])->name('student.destroyStudent');
        Route::post('/student/addStudent/import', [App\Http\Controllers\Users\StudentController::class, 'import_excel'])->name('student.importExcel');
        Route::post('/student/addStudent/check', [App\Http\Controllers\Users\StudentController::class, 'checkNIS'])->name('student.checkNIS');
        Route::resource('/student', App\Http\Controllers\Users\StudentController::class)->except(['index', 'destroy']);

        //Absen
        Route::get('/absen', [App\Http\Controllers\Users\AttendanceController::class, 'showKelas'])->name('sholat.showKelas');
        Route::get('/absen/{id_kelas}', [App\Http\Controllers\Users\AttendanceController::class, 'absenSholat'])->name('sholat.absenSholat');
        Route::post('/absen/update', [App\Http\Controllers\Users\AttendanceController::class, 'updateSholat'])->name('sholat.updateSholat');
    });

    Route::group(['middleware' => ['auth', 'user-access:wali'], 'prefix' => 'wali'], function () {
        Route::get('/Wali', [App\Http\Controllers\Users\WaliController::class, 'index'])->name('wali.dashboard');
    });

    Route::group(['middleware' => ['auth', 'user-access:tu'], 'prefix' => 'tatausaha'], function () {
        Route::get('/', [App\Http\Controllers\Users\TataUsahaController::class, 'index'])->name('tu.dashboard');
    });
});
