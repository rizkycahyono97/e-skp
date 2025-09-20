<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\PerformanceAgreementController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkCascadingController;
use App\Models\PerformanceAgreement;
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
        Route::get('/performance-agreements/persetujuan', [PerformanceAgreementController::class, 'persetujuanList'])
            ->name('performance-agreements.persetujuan.index');

        Route::get('/performance-agreements/persetujuan/{performance_agreement}', [PerformanceAgreementController::class, 'approvalShow'])
            ->name('performance-agreements.persetujuan.show');

        Route::post('/performance-agreements/{performance_agreement}/submit', [PerformanceAgreementController::class, 'submit'])
            ->name('performance-agreements.persetujuan.submit');
            
        Route::post('/performance-agreements/{performance_agreement}/approve', [PerformanceAgreementController::class, 'approve'])
            ->name('performance-agreements.persetujuan.approve');
            
        Route::post('/performance-agreements/{performance_agreement}/revert', [PerformanceAgreementController::class, 'revert'])
        ->name('performance-agreements.persetujuan.revert');

        Route::resource('/performance-agreements', PerformanceAgreementController::class);

    });

    // work-cascading
    Route::middleware('role:Super Admin|Rektor|Dekan')->group(function () {
        Route::get('/work-cascading/pa-create/{indicator}', [WorkCascadingController::class, 'paCreate'])
        ->name('work-cascading.pa-create');

        Route::post('/work-cascading', [WorkCascadingController::class, 'paStore'])
            ->name('work-cascadings.pa-store');

    });
    
    Route::resource('/roles', RoleController::class);
    Route::resource('/positions', PositionController::class);
});
