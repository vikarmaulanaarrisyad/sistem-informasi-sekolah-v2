<?php

use App\Http\Controllers\{
    DashboardController,
    InstansiController,
    KelasController,
    KurikulumController,
    PermissionController,
    RoleController,
    RombelController,
    RuanganController,
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
        Route::resource('permission', PermissionController::class)->except('edit','create');

        // Role
        Route::get('/role/data', [RoleController::class, 'data'])->name('admin.role.data');
        Route::resource('/role', RoleController::class)->except('edit','create');

        // User
        Route::get('/users/data', [UserController::class, 'data'])->name('admin.user.data');
        Route::resource('/users', UserController::class)->except('edit','create');

        // Profil Sekolah
        Route::resource('/instansi', InstansiController::class)->except('edit','create','destroy','store');

        // Tahun Ajaran
        Route::get('/tahun-ajaran/data', [TahunajaranController::class, 'data'])->name('admin.tahun_ajaran.data');
        Route::resource('/tahun-ajaran', TahunajaranController::class)->except('edit','create');
        Route::put('/tahun-ajaran/{id}/update_status', [TahunajaranController::class, 'updateStatus'])->name('admin.tahun_ajaran.update_status');

        // Kurikulum
        Route::get('/kurikulum/data', [KurikulumController::class, 'data'])->name('admin.kurikulum.data');
        Route::resource('/kurikulum', KurikulumController::class)->except('edit','create');

        // Ruangan
        Route::get('/sarana-prasarana/ruangan/data', [RuanganController::class, 'data'])->name('admin.ruangan.data');
        Route::resource('/sarana-prasarana/ruangan', RuanganController::class)->except('create','edit');
        Route::get('/sarana-prasarana/ruangan/ruangan-detail/{id}',[RuanganController::class, 'detail'])->name('admin.ruangan.detail');

        // Kelas
        Route::get('/sarana-prasarana/kelas/data', [KelasController::class, 'data'])->name('admin.kelas.data');
        Route::resource('/sarana-prasarana/kelas', KelasController::class)->except('create','edit');

        // Rombel
        Route::get('/rombel/data', [RombelController::class, 'data'])->name('admin.rombel.data');
        Route::resource('/rombel', RombelController::class);
        Route::get('/rombel/rombel-detail/{id}', [RombelController::class, 'detail'])->name('admin.rombel.detail');
    });
});
