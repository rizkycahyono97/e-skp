<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\PerformanceAgreementController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkCascadingController;
use Illuminate\Support\Facades\Route;

// login
Route::get('login', [LoginController::class, 'showLoginForm'])->middleware('guest')->name('login');
Route::post('login', [LoginController::class, 'login'])->middleware('guest');
Route::post('logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    Route::middleware('role:Super Admin')->group(function () {
        Route::resource('/users', UserController::class);
    });

    Route::middleware('role:Super Admin|Rektor|Dekan')->group(function () {
        Route::resource('/performance-agreements', PerformanceAgreementController::class);
    });

    Route::middleware('role:Super Admin|Rektor|Dekan')->group(function () {
        Route::get('/work-cascading/create/{indicator}', [WorkCascadingController::class, 'create'])
        ->name('work-cascading.create');

        Route::post('/work-cascading', [WorkCascadingController::class, 'store'])
            ->name('work-cascadings.store');

    });
    
    Route::resource('/roles', RoleController::class);
    Route::resource('/positions', PositionController::class);
});
