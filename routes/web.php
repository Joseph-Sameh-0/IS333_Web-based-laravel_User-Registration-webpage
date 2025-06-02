<?php

use App\Http\Controllers\UniversityController;
use App\Http\Controllers\WhatsappController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
//    return view('welcome');
    return view('register');
});

Route::resource('users', UniversityController::class);

Route::post('/check-whatsapp', [WhatsappController::class, 'check']);
