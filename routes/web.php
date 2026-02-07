<?php

use App\Http\Controllers\Auth\Login;
use App\Http\Controllers\Auth\Logout;
use App\Http\Controllers\Auth\Register;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;

Route::get('/', function () {
    return view('home');
});

Route::get('/mahasiswa/dashboard', function () {
    return view('mahasiswa.dashboard');
});


Route::middleware(['auth', 'role:dosen'])->prefix('dosen')->group(function(){
    Route::get('/dashboard', function(){
        return view('dosen.dashboard');
    });
});

Route::middleware(['auth', 'role:admin|superAdmin'])
    ->prefix('admin')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        });

        Route::get('/surat', function () {
            return view('admin.surat');
        });

        Route::middleware('role:superAdmin')->group(function () {
            Route::get('users', [UserController::class, 'index'])
                ->name('admin.users.index');

            Route::get('create/', function(){
                return view('admin.users.create');
            })->name('admin.create.users');

            Route::post('/users', [UserController::class, 'store'])->name('admin.create.users.submit');

            Route::get('/users/{id}/edit', [UserController::class, 'edit'])
                ->name('admin.users.edit');

            Route::put('/users/{id}', [UserController::class, 'update'])
                ->name('admin.users.update');

            Route::delete('/users/{id}', [UserController::class, 'destroy'])
                ->name('admin.users.destroy');

            Route::get('/role', function () {
                return view('admin.role');
            });
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
