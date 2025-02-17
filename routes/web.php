<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SpaceController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['jwt'])->group(function () {

    Route::middleware(['role:1'])->group(function () {
        Route::prefix('users')->group(function () {
            Route::get('/', [UserController::class, 'getAll']);
        });
        
        Route::prefix('user')->group(function () {
            Route::post('/create', [UserController::class, 'create']);
        });

        Route::prefix('rol')->group(function () {
            Route::get('/', [RoleController::class, 'getAll']);
        });
    });

    Route::middleware(['role:2'])->group(function () {      
        Route::prefix('space')->group(function () {
            Route::post('/create', [SpaceController::class, 'create']);
        });
    });

    Route::middleware(['role:1,2'])->group(function () {
        Route::prefix('user')->group(function () {
            Route::get('/', [UserController::class, 'getByToken']);
            Route::post('/update', [UserController::class, 'updateByToken']);
        });
    });
});
