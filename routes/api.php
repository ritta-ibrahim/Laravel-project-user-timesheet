<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Timesheets\TimesheetsController;
// use App\Http\Controllers\Users\UsersController;
use App\Http\Controllers\Projects\ProjectsController;
use App\Http\Controllers\Attributes\AttributesController;

Route::middleware('guest')
    ->group(function () {
        Route::post('/register', [AuthController::class, 'register'])
            ->name('auth.register');
        Route::post('/login', [AuthController::class, 'login'])
            ->name('auth.login');
    });


Route::middleware('auth:api')
    ->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])
            ->name('auth.logout');
    });

Route::prefix('attributes')
    ->middleware('auth:api')
    ->group(function () {
        Route::get('/{attribute}', [AttributesController::class, 'getAttribute']);
        Route::put('/{attribute}', [AttributesController::class, 'updateAttribute']);
        Route::delete('/{attribute}', [AttributesController::class, 'deleteAttribute']);
        Route::post('/create', [AttributesController::class, 'createAttribute']);
        Route::get('/', [AttributesController::class, 'getAttributes']);
    });
Route::prefix('projects')
    ->middleware('auth:api')
    ->group(function () {
        Route::get('/{project}', [ProjectsController::class, 'getProject']);
        Route::put('/{project}', [ProjectsController::class, 'updateProject']);
        Route::delete('/{project}', [ProjectsController::class, 'deleteProject']);
        Route::post('/create', [ProjectsController::class, 'createProject']);
        Route::get('/', [ProjectsController::class, 'getProjects']);
    });
Route::prefix('timesheets')
    ->middleware('auth:api')
    ->group(function () {
        Route::get('/{timesheet}', [TimesheetsController::class, 'getTimesheet']);
        Route::put('/{timesheet}', [TimesheetsController::class, 'updateTimesheet']);
        Route::delete('/{timesheet}', [TimesheetsController::class, 'deleteTimesheet']);
        Route::post('/create', [TimesheetsController::class, 'createTimesheet']);
        Route::get('/', [TimesheetsController::class, 'getTimesheets']);
    });

