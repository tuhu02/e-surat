<?php

use App\Http\Controllers\Auth\Login;
use App\Http\Controllers\Auth\Logout;
use App\Http\Controllers\Auth\Register;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/dosen/dashboard', function () {
    return view('dosen.dashboard');
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
            Route::get('/users', function () {
                return view('admin.users');
            });

            Route::get('/role', function () {
                return view('admin.role');
            });
        });
    }
);

Route::get('/mahasiswa/dashboard', function () {
    return view('mahasiswa.dashboard');
});

Route::view('/register', 'auth.register')->name('register');
Route::post('/register', Register::class)->name('register.submit');

Route::view('/login', 'auth.login')->name('login');
Route::post('/login', Login::class)->name('login.submit');

Route::post('/logout', Logout::class)
    ->middleware('auth')
    ->name('logout');
