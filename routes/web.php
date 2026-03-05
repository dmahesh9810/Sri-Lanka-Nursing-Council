<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\NurseController;
use App\Http\Controllers\TemporaryRegistrationController;
use App\Http\Controllers\PermanentRegistrationController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('nurses', NurseController::class);
Route::resource('temporary-registrations', TemporaryRegistrationController::class);
Route::resource('permanent-registrations', PermanentRegistrationController::class);
