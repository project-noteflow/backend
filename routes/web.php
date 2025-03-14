<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SpaceController;
use App\Http\Controllers\NoteController;
use Illuminate\Support\Facades\Route;


Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
});

Route::middleware(['jwt'])->group(function () {

    Route::middleware(['role:1,2'])->group(function () {
        Route::controller(AdminController::class)->group(function () {
            Route::prefix('users')->group(function () {
                Route::get('/', 'getAll');
            });

            Route::prefix('user')->group(function () {
                Route::post('/create', 'create');
                Route::put('/deactivate/{id}', 'deactivateUser');
                Route::put('/activate/{id}', 'activateUser');
            });
        });

        Route::prefix('rol')->group(function () {
            Route::get('/', [RoleController::class, 'getAll']);
        });
    });

    Route::middleware(['role:3'])->group(function () {
        Route::controller(SpaceController::class)->group(function () {
            Route::prefix('space')->group(function () {
                Route::post('/create', 'create');
                Route::post('/update', 'update');
            });

            Route::prefix('spaces')->group(function () {
                Route::get('/', 'getSpacesByToken');
            });
        });

        Route::controller(NoteController::class)->group(function () {
            Route::get('/notes/{id_espacio}', 'getAllNotes');
            Route::post('/create', 'createNote');
            Route::put('/update/{id_note}', 'updateNote');
        });
    });

    Route::middleware(['role:1,2,3'])->group(function () {
        Route::controller(UserController::class)->group(function () {
            Route::prefix('user')->group(function () {
                Route::get('/', 'getByToken');
                Route::post('/update', 'updateByToken');
                Route::put('/deactivate', 'deactiveOwnAccount');
            });
        });
    });
});
