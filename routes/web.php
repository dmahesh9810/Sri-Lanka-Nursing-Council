<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\NurseController;
use App\Http\Controllers\TemporaryRegistrationController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('nurses', NurseController::class);
Route::resource('temporary-registrations', TemporaryRegistrationController::class);
