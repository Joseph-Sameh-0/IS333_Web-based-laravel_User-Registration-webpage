<?php

use App\Http\Controllers\WhatsappController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
//    return view('welcome');
    return view('index');
});

Route::post('/check-whatsapp', [WhatsappController::class, 'check']);