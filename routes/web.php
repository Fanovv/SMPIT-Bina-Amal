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
        Route::get('/profile', [App\Http\Controllers\Users\AdminController::class, 'getProfile'])->name('admin.profile');
        Route::get('/manage', [App\Http\Controllers\Users\AdminController::class, 'manage'])->name('admin.manageUser');
        Route::get('/manage/addUser', [App\Http\Controllers\Users\AdminController::class, 'addUser'])->name('admin.addUser');
        // Route::get('/admin/manage/{id}/edit', [App\Http\Controllers\Users\AdminController::class, 'editUser'])->name('admin.editUser');
        // Route::post('/admin/manageUser/{id}', [App\Http\Controllers\Users\AdminController::class, 'updateUser'])->name('admin.updateUser');
        Route::post('/manage/delete/{id}', [App\Http\Controllers\Users\AdminController::class, 'destroyUser'])->name('admin.destroyUser');
        Route::put('/profile/{id}', [App\Http\Controllers\Users\AdminController::class, 'updateProfile'])->name('admin.updateProfile');
        Route::resource('/manage/user', App\Http\Controllers\Users\AdminController::class)->except(['index', 'destroy']);

        //Kelas
        Route::get('/class', [App\Http\Controllers\Users\KelasController::class, 'manage'])->name('classes.manageClass');
        Route::get('/class/addClass', [App\Http\Controllers\Users\KelasController::class, 'showAddClass'])->name('classes.showAddClasses');
        Route::get('/class/addClass/import', [App\Http\Controllers\Users\KelasController::class, 'showImport'])->name('classes.showImport');
        Route::get('/class/{id}/edit', [App\Http\Controllers\Users\KelasController::class, 'edit'])->name('classes.editClasses');
        Route::post('/class/addClass', [App\Http\Controllers\Users\KelasController::class, 'AddClasses'])->name('classes.AddClasses');
        Route::post('/class/delete/{id}', [App\Http\Controllers\Users\KelasController::class, 'destroyKelas'])->name('classes.destroyKelas');
        Route::post('/class/addClass/import', [App\Http\Controllers\Users\KelasController::class, 'import_excel'])->name('classes.importExcel');
        Route::put('/class/{id}', [App\Http\Controllers\Users\KelasController::class, 'update'])->name('classes.updateClasses');
        // Route::resource('/class', App\Http\Controllers\Users\KelasController::class)->except(['index', 'destroy', 'create', 'edit']);

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
        Route::post('/student', [App\Http\Controllers\Users\StudentController::class, 'store'])->name('student.AddStudent');


        //Absen
        Route::get('/absen', [App\Http\Controllers\Users\AttendanceController::class, 'showKelas'])->name('sholat.showKelas');
        Route::get('/absen/{id_kelas}', [App\Http\Controllers\Users\AttendanceController::class, 'absenSholat'])->name('sholat.absenSholat');
        Route::post('/absen/get_data', [App\Http\Controllers\Users\AttendanceController::class, 'ajaxAbsenSholat'])->name('sholat.ajaxAbsenSholat');
        Route::post('/absen/update', [App\Http\Controllers\Users\AttendanceController::class, 'updateSholat'])->name('sholat.updateSholat');

        //Keterangan
        Route::get('/keterangan', [App\Http\Controllers\Users\AttendanceController::class, 'descSholat'])->name('desc.descSholat');
        Route::post('/get-murid', [App\Http\Controllers\Users\AttendanceController::class, 'getMurid'])->name('desc.getMurid');
        Route::put('/keterangan/update', [App\Http\Controllers\Users\AttendanceController::class, 'updateDesc'])->name('desc.updateDesc');

        //export file
        Route::get('/export-student/{id}', [App\Http\Controllers\Users\StudentController::class, 'exportStudent'])->name('sholat.exportStudent');
        Route::get('/export-data', [App\Http\Controllers\Users\AttendanceController::class, 'exportData'])->name('sholat.exportData');
        Route::post('/export-data/{tahun}', [App\Http\Controllers\Users\AttendanceController::class, 'exportAllData'])->name('sholat.exportAllData');
    });

    Route::group(['middleware' => ['auth', 'user-access:tu'], 'prefix' => 'tatausaha'], function () {
        Route::get('/', [App\Http\Controllers\Users\TataUsahaController::class, 'index'])->name('tu.dashboard');
        Route::get('/profile', [App\Http\Controllers\Users\AdminController::class, 'getProfile'])->name('tu.profile');
        Route::put('/profile/{id}', [App\Http\Controllers\Users\AdminController::class, 'updateProfile'])->name('tu.updateProfile');

        //Kelas
        Route::get('/class', [App\Http\Controllers\Users\KelasController::class, 'manage'])->name('tu.classes.manageClass');
        Route::get('/class/addClass', [App\Http\Controllers\Users\KelasController::class, 'showAddClass'])->name('tu.classes.showAddClasses');
        Route::get('/class/addClass/import', [App\Http\Controllers\Users\KelasController::class, 'showImport'])->name('tu.classes.showImport');
        Route::get('/class/{id}/edit', [App\Http\Controllers\Users\KelasController::class, 'edit'])->name('tu.classes.editClasses');
        Route::post('/class/delete/{id}', [App\Http\Controllers\Users\KelasController::class, 'destroyKelas'])->name('tu.classes.destroyKelas');
        Route::post('/class/addClass', [App\Http\Controllers\Users\KelasController::class, 'AddClasses'])->name('tu.classes.AddClasses');
        Route::post('/class/addClass/import', [App\Http\Controllers\Users\KelasController::class, 'import_excel'])->name('tu.classes.importExcel');
        Route::put('/class/{id}', [App\Http\Controllers\Users\KelasController::class, 'update'])->name('tu.classes.updateClasses');

        //Murid
        Route::get('/student', [App\Http\Controllers\Users\StudentController::class, 'showKelas'])->name('tu.student.showKelas');
        Route::get('/student/manage/{id_kelas}', [App\Http\Controllers\Users\StudentController::class, 'manageStudent'])->name('tu.student.manageStudent');
        Route::get('/student/addStudent', [App\Http\Controllers\Users\StudentController::class, 'showAddStudent'])->name('tu.student.showAddStudent');
        Route::get('/student/manage/{id_kelas}/edit/{id_murid}', [App\Http\Controllers\Users\StudentController::class, 'editStudent'])->name('tu.student.editStudent');
        Route::get('/student/addStudent/import', [App\Http\Controllers\Users\StudentController::class, 'showImport'])->name('tu.student.showImport');
        Route::post('/student/manage/delete/{id_murid}', [App\Http\Controllers\Users\StudentController::class, 'destroyStudent'])->name('tu.student.destroyStudent');
        Route::post('/student/checkKelas', [App\Http\Controllers\Users\StudentController::class, 'checkKelas'])->name('tu.student.checkKelas');
        Route::post('/student', [App\Http\Controllers\Users\StudentController::class, 'store'])->name('tu.student.AddStudent');
        Route::post('/student/addStudent/check', [App\Http\Controllers\Users\StudentController::class, 'checkNIS'])->name('tu.student.checkNIS');
        Route::put('/student/manage/{id_murid}/update', [App\Http\Controllers\Users\StudentController::class, 'updateStudent'])->name('tu.student.updateStudent');
        Route::post('/student/addStudent/import', [App\Http\Controllers\Users\StudentController::class, 'import_excel'])->name('tu.student.importExcel');

        //export file
        Route::get('/export-data', [App\Http\Controllers\Users\AttendanceController::class, 'exportData'])->name('tu.sholat.exportData');
        Route::get('/export-student/{id}', [App\Http\Controllers\Users\StudentController::class, 'exportStudent'])->name('tu.sholat.exportStudent');
        Route::post('/export-data/{tahun}', [App\Http\Controllers\Users\AttendanceController::class, 'exportAllData'])->name('tu.sholat.exportAllData');

        //Absen
        Route::get('/absen', [App\Http\Controllers\Users\AttendanceController::class, 'showKelas'])->name('tu.sholat.showKelas');
        Route::get('/absen/{id_kelas}', [App\Http\Controllers\Users\AttendanceController::class, 'absenSholat'])->name('tu.sholat.absenSholat');
        Route::post('/absen/get_data', [App\Http\Controllers\Users\AttendanceController::class, 'ajaxAbsenSholat'])->name('tu.sholat.ajaxAbsenSholat');
        Route::post('/absen/update', [App\Http\Controllers\Users\AttendanceController::class, 'updateSholat'])->name('tu.sholat.updateSholat');

        //Keterangan
        Route::get('/keterangan', [App\Http\Controllers\Users\AttendanceController::class, 'descSholat'])->name('tu.descSholat');
        Route::post('/get-murid', [App\Http\Controllers\Users\AttendanceController::class, 'getMurid'])->name('tu.getMurid');
        Route::put('/keterangan/update', [App\Http\Controllers\Users\AttendanceController::class, 'updateDesc'])->name('tu.updateDesc');
    });

    Route::group(['middleware' => ['auth', 'user-access:wali'], 'prefix' => 'wali'], function () {
        Route::get('/', [App\Http\Controllers\Users\WaliController::class, 'index'])->name('wali.dashboard');
        Route::get('/profile', [App\Http\Controllers\Users\AdminController::class, 'getProfile'])->name('wali.profile');
        Route::put('/profile/{id}', [App\Http\Controllers\Users\AdminController::class, 'updateProfile'])->name('wali.updateProfile');

        //Absen
        Route::get('/absen', [App\Http\Controllers\Users\AttendanceController::class, 'showKelas'])->name('wali.sholat.showKelas');
        Route::get('/absen/{id_kelas}', [App\Http\Controllers\Users\AttendanceController::class, 'absenSholat'])->name('wali.sholat.absenSholat');
        Route::post('/absen/get_data', [App\Http\Controllers\Users\AttendanceController::class, 'ajaxAbsenSholat'])->name('wali.sholat.ajaxAbsenSholat');
        Route::post('/absen/update', [App\Http\Controllers\Users\AttendanceController::class, 'updateSholat'])->name('wali.sholat.updateSholat');

        //Keterangan
        Route::get('/keterangan', [App\Http\Controllers\Users\AttendanceController::class, 'descSholat'])->name('wali.descSholat');
        Route::post('/get-murid', [App\Http\Controllers\Users\AttendanceController::class, 'getMurid'])->name('wali.getMurid');
        Route::put('/keterangan/update', [App\Http\Controllers\Users\AttendanceController::class, 'updateDesc'])->name('wali.updateDesc');
    });
});
