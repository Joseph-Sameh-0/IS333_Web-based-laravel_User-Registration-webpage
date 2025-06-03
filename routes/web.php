<?php

use App\Http\Controllers\UniversityStudentsController;
use App\Http\Controllers\WhatsappController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
//    return view('welcome');
    return view('users.register');
});

Route::resource('users', UniversityStudentsController::class);

Route::post('/check-whatsapp', [WhatsappController::class, 'check']);
