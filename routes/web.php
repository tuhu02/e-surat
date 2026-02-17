<?php

use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\Login;
use App\Http\Controllers\Auth\Logout;
use App\Http\Controllers\Auth\Register;
use App\Http\Controllers\Mahasiswa\PengajuanController;
use App\Http\Controllers\Mahasiswa\PengajuanTtdController;
use App\Http\Controllers\Admin\PengajuanController as AdminPengajuanController;
use App\Http\Controllers\Admin\SuratController;
use App\Http\Controllers\Dosen\DosenPengajuanController;
use Illuminate\Support\Facades\Route;

// Home
Route::get('/', function () {
    return view('home');
});

// Autentikasi
Route::view('/register', 'auth.register')->name('register');
Route::post('/register', Register::class)->name('register.submit');

Route::view('/login', 'auth.login')->name('login');
Route::post('/login', Login::class)->name('login.submit');

Route::post('/logout', Logout::class)
    ->middleware('auth')
    ->name('logout');


// Mahasiswa
Route::middleware(['auth'])
    ->prefix('mahasiswa')
    ->group(function () {
        Route::get('/dashboard', function(){
            return view('mahasiswa.dashboard');
        })->name('mahasiswa.dashboard');

        Route::get('/meminta-surat', [PengajuanController::class, 'index'])->middleware('can:create.pengajuan')->name('mahasiswa.meminta-surat');
        Route::post('/meminta-surat', [PengajuanController::class, 'store'])->middleware('can:create.pengajuan')->name('mahasiswa.meminta-surat.store');
        Route::get('/histori-pengajuan', [PengajuanController::class, 'histori'])->middleware('can:create.pengajuan')->name('mahasiswa.histori-pengajuan');

        // Route Pengajuan TTD
        Route::get('/pengajuan-ttd', [PengajuanTtdController::class, 'index'])->middleware('can:read.pengajuan.ttd')->name('mahasiswa.pengajuan.ttd.index');
        Route::post('/pengajuan-ttd', [PengajuanTtdController::class, 'store'])->middleware('can:create.pengajuan.ttd')->name('mahasiswa.pengajuan.ttd.store');
});


// Dosen
Route::middleware(['auth'])->prefix('dosen')->group(function () {
    Route::get('/dashboard', function () {
        return view('dosen.dashboard');
    })->name('dosen.dashboard');

    Route::get('/dosen/pengajuan', [DosenPengajuanController::class, 'index'])->name('dosen.pengajuan.index');
});


// Admin
Route::middleware(['auth'])
    ->prefix('admin')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');

        Route::get('users', [UserController::class, 'index'])->middleware('can:read.user')->name('admin.users.index');

        Route::get('create/', [UserController::class, 'create'])->middleware('can:create.user')->name('admin.create.users');

        Route::post('/users', [UserController::class, 'store'])->middleware('can:create.user')->name('admin.create.users.submit');

        Route::get('/users/{id}/edit', [UserController::class, 'edit'])->middleware('can:update.user')->name('admin.users.edit');

        Route::put('/users/{id}', [UserController::class, 'update'])->middleware('can:update.user')->name('admin.users.update');

        Route::delete('/users/{id}', [UserController::class, 'destroy'])->middleware('can:delete.user')->name('admin.users.destroy');

        // Route Role
        Route::get('roles', [RoleController::class, 'index'])->middleware('can:read.role')->name('admin.roles.index');

        Route::get('roles/create/',[RoleController::class, 'create'])->middleware('can:create.role')->name('admin.create.roles');

        Route::post('/roles', [RoleController::class, 'store'])->middleware('can:create.role')->name('admin.create.roles.submit');

        Route::get('/roles/{id}/edit', [RoleController::class, 'edit'])->middleware('can:update.role')->name('admin.roles.edit');
        
        Route::put('/roles/{id}', [RoleController::class, 'update'])->middleware('can:update.role')->name('admin.roles.update');

    
        Route::delete('/roles/{id}', [RoleController::class, 'destroy'])->middleware('can:delete.role')->name('admin.roles.destroy');

        // Route Pengajuan
        Route::get('/pengajuan', [AdminPengajuanController::class, 'index'])
            ->middleware('can:read.pengajuan')
            ->name('admin.pengajuan.index');
        
        Route::get('/pengajuan/{id}/create', [AdminPengajuanController::class, 'create'])
            ->middleware('can:read.pengajuan')
            ->name('admin.pengajuan.create');
        
        Route::patch('/pengajuan/{id}/store-upload', [AdminPengajuanController::class, 'storeUpload'])
            ->name('admin.pengajuan.store-upload');
        
        Route::post('/pengajuan/{id}/store-upload', [AdminPengajuanController::class, 'storeUpload'])
            ->middleware('can:update.pengajuan')
            ->name('admin.pengajuan.store-upload');

        Route::patch('/pengajuan/{id}/decline', [AdminPengajuanController::class, 'decline'])
            ->middleware('can:read.pengajuan')
            ->name('admin.pengajuan.decline');

    }
);

