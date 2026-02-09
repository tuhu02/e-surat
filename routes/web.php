<?php

use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\Login;
use App\Http\Controllers\Auth\Logout;
use App\Http\Controllers\Auth\Register;
use App\Http\Controllers\Mahasiswa\PengajuanController;
use App\Http\Controllers\Admin\SuratController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});


Route::middleware(['auth', 'role:mahasiswa'])
    ->prefix('mahasiswa')
    ->group(function () {
        Route::get('/dashboard', function(){
            return view('mahasiswa.dashboard');
        });

        Route::post('/meminta-surat', [PengajuanController::class, 'store'])->name('mahasiswa.meminta-surat.store');
        Route::get('/meminta-surat', [PengajuanController::class, 'index'])->name('mahasiswa.meminta-surat');
});

Route::middleware(['auth', 'role:dosen'])->prefix('dosen')->group(function () {
    Route::get('/dashboard', function () {
        return view('dosen.dashboard');
    });
});

Route::middleware(['auth', 'role:admin|superAdmin'])
    ->prefix('admin')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        });

        Route::middleware('role:superAdmin')->group(function () {
            // Route user
            Route::get('users', [UserController::class, 'index'])
                ->name('admin.users.index');

            Route::get('create/', function () {
                return view('admin.users.create');
            })->name('admin.create.users');

            Route::post('/users', [UserController::class, 'store'])->name('admin.create.users.submit');

            Route::get('/users/{id}/edit', [UserController::class, 'edit'])
                ->name('admin.users.edit');

            Route::put('/users/{id}', [UserController::class, 'update'])
                ->name('admin.users.update');

            Route::delete('/users/{id}', [UserController::class, 'destroy'])
                ->name('admin.users.destroy');

            // Route Role
            Route::get('roles', [RoleController::class, 'index'])
                ->name('admin.roles.index');

            Route::get('roles/create/', function () {
                return view('admin.roles.create');
            })->name('admin.create.roles');

            Route::post('/roles', [RoleController::class, 'store'])->name('admin.create.roles.submit');

            Route::get('/roles/{id}/edit', [RoleController::class, 'edit'])
                ->name('admin.roles.edit');

            Route::delete('/roles/{id}', [RoleController::class, 'destroy'])
                ->name('admin.roles.destroy');

            // Route Surat

            Route::get('/surat', [SuratController::class, 'index'])->name('admin.surat.index');

            Route::get('/surat/{id}/store', [SuratController::class, 'store'])->name('admin.surat.store');
        });
    }
);

Route::view('/register', 'auth.register')->name('register');
Route::post('/register', Register::class)->name('register.submit');

Route::view('/login', 'auth.login')->name('login');
Route::post('/login', Login::class)->name('login.submit');

Route::post('/logout', Logout::class)
    ->middleware('auth')
    ->name('logout');
