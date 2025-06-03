<?php

use App\Http\Controllers\UniversityUsersController;
use App\Http\Controllers\WhatsappController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
//    return view('welcome');
    return view('users.register');
});

Route::resource('users', UniversityUsersController::class);

Route::post('/check-whatsapp', [WhatsappController::class, 'check']);
