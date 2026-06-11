<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\JenisSuratController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\StatistikController;
use App\Http\Controllers\Api\SuratController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    // Autentikasi (public)
    Route::post('/login', [AuthController::class, 'login']);

    // Protected routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'me']);

        // Jenis Surat
        Route::get('/jenis-surat', [JenisSuratController::class, 'index']);

        // Surat / Pengajuan
        Route::get('/surat', [SuratController::class, 'index']);
        Route::post('/surat/ajukan', [SuratController::class, 'ajukan'])
            ->middleware('can:create.pengajuan');
        Route::get('/surat/{id}', [SuratController::class, 'show']);
        Route::patch('/surat/{id}/status', [SuratController::class, 'updateStatus']);
        Route::delete('/surat/{id}', [SuratController::class, 'destroy'])
            ->middleware('role:admin|super-admin');

        // Statistik
        Route::get('/statistik', [StatistikController::class, 'index'])
            ->middleware('role:admin|super-admin');

        // Manajemen User (Super Admin)
        Route::middleware('can:read.user')->group(function () {
            Route::get('/users', [UserController::class, 'index']);
            Route::get('/users/{id}', [UserController::class, 'show']);
        });
        Route::post('/users', [UserController::class, 'store'])
            ->middleware('can:create.user');
        Route::put('/users/{id}', [UserController::class, 'update'])
            ->middleware('can:update.user');
        Route::delete('/users/{id}', [UserController::class, 'destroy'])
            ->middleware('can:delete.user');

        // Manajemen Role & Permission (Super Admin)
        Route::middleware('can:read.role')->group(function () {
            Route::get('/roles', [RoleController::class, 'index']);
            Route::get('/roles/{id}', [RoleController::class, 'show']);
            Route::get('/permissions', [RoleController::class, 'permissions']);
        });
        Route::post('/roles', [RoleController::class, 'store'])
            ->middleware('can:create.role');
        Route::put('/roles/{id}', [RoleController::class, 'update'])
            ->middleware('can:update.role');
        Route::delete('/roles/{id}', [RoleController::class, 'destroy'])
            ->middleware('can:delete.role');
    });
});
