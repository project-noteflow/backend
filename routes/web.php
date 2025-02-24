<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SpaceController;
use Illuminate\Support\Facades\Route;


Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
});


Route::middleware(['jwt'])->group(function () {

    Route::middleware(['role:1'])->group(function () {
        Route::controller(UserController::class)->group(function () {
            Route::prefix('users')->group(function () {
                Route::get('/', 'getAll');
            });

            Route::prefix('user')->group(function () {
                Route::post('/create', 'create');
            });
        });

        Route::prefix('rol')->group(function () {
            Route::get('/', [RoleController::class, 'getAll']);
        });
    });

    Route::middleware(['role:2'])->group(function () {
        Route::controller(SpaceController::class)->group(function () {
            Route::prefix('space')->group(function () {
                Route::post('/create', 'create');
                Route::post('/update', 'update');
            });

            Route::prefix('spaces')->group(function () {
                Route::get('/', 'getSpacesByToken');
            });
        });
    });

    Route::middleware(['role:1,2'])->group(function () {
        Route::controller(UserController::class)->group(function () {
            Route::prefix('user')->group(function () {
                Route::get('/', 'getByToken');
                Route::post('/update', 'updateByToken');
            });
        });
    });
});
