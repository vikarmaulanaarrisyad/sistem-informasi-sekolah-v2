<?php

use App\Http\Controllers\{
    DashboardController,
    InstansiController,
    PermissionController,
    RoleController,
    TahunajaranController,
    UserController,
};
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

Route::get('/', function () {
    return view('welcome');
});

Route::group([
    'middleware' => ['auth','role:admin|guru|siswa|kepala sekolah']
], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


    Route::group([
        'middleware' => 'role:admin',
        'prefix' => 'admin'
    ], function () {
        // Permission
        Route::get('/permission/data', [PermissionController::class, 'data'])->name('admin.permission.data');
        Route::resource('permission', PermissionController::class);

        // Role
        Route::get('/role/data', [RoleController::class, 'data'])->name('admin.role.data');
        Route::resource('/role', RoleController::class);

        // User
        Route::get('/users/data', [UserController::class, 'data'])->name('admin.user.data');
        Route::resource('/users', UserController::class);

        // Profil Sekolah
        Route::resource('/instansi', InstansiController::class);

        // Tahun Ajaran
        Route::get('/tahun-ajaran/data', [TahunajaranController::class, 'data'])->name('admin.tahun_ajaran.data');
        Route::resource('/tahun-ajaran', TahunajaranController::class);
        Route::put('/tahun-ajaran/{id}/update_status', [TahunajaranController::class, 'updateStatus'])->name('admin.tahun_ajaran.update_status');
        
    });
});