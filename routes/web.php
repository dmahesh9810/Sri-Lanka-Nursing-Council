<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\NurseController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('nurses', NurseController::class);
