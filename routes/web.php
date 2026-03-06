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

    Route::resource('nurses', NurseController::class);
    Route::resource('temporary-registrations', TemporaryRegistrationController::class);
    Route::resource('permanent-registrations', PermanentRegistrationController::class);
    Route::resource('additional-qualifications', AdditionalQualificationController::class);
    Route::resource('foreign-certificates', ForeignCertificateController::class);
    Route::get('/certificates/{id}/print', [CertificateController::class , 'generate'])->name('certificates.print');
});
