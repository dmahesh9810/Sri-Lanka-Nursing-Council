<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NurseController;
use App\Http\Controllers\TemporaryRegistrationController;
use App\Http\Controllers\PermanentRegistrationController;
use App\Http\Controllers\AdditionalQualificationController;
use App\Http\Controllers\ForeignCertificateController;
use App\Http\Controllers\CertificateController;

use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/login', [AuthController::class , 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class , 'login']);
Route::post('/logout', [AuthController::class , 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class , 'index'])->name('dashboard');
    Route::get('/search', [\App\Http\Controllers\SearchController::class, 'search'])->name('global.search');

    // Reports: accessible by all roles (1–6); module-level filtering is enforced in ReportController
    Route::middleware('role:1,2,3,4,5,6')->group(function () {
        Route::get('/reports', [\App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');
        Route::post('/reports/generate', [\App\Http\Controllers\ReportController::class, 'generate'])->name('reports.generate');
    });

    // Admin has access to all, plus specific roles per module
    Route::middleware('role:1,3,4,5,6')->group(function () {
        Route::resource('nurses', NurseController::class);
    });

    Route::middleware('role:1,2,3')->group(function () {
        Route::resource('temporary-registrations', TemporaryRegistrationController::class);
    });

    Route::middleware('role:1,3,4,5,6')->group(function () {
        Route::resource('permanent-registrations', PermanentRegistrationController::class);
    });

    Route::middleware('role:1,4')->group(function () {
        Route::get('permanent-certificates', [\App\Http\Controllers\PermanentCertificateController::class, 'index'])->name('permanent-certificates.index');
        Route::post('permanent-certificates/{id}/status', [\App\Http\Controllers\PermanentCertificateController::class, 'updateStatus'])->name('permanent-certificates.status');
        Route::get('permanent-certificates/{id}/print', [\App\Http\Controllers\PermanentCertificateController::class, 'printPdf'])->name('permanent-certificates.print');
    });

    Route::middleware('role:1,5')->group(function () {
        Route::resource('additional-qualifications', AdditionalQualificationController::class);
    });

    Route::middleware('role:1,6')->group(function () {
        Route::resource('foreign-certificates', ForeignCertificateController::class);
        Route::get('/certificates/{id}/print', [CertificateController::class , 'generate'])->name('certificates.print');
    });
});
