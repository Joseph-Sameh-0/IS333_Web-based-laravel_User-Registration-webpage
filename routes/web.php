<?php

use App\Http\Controllers\UniversityUsersController;
use App\Http\Controllers\WhatsappController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
//    return view('welcome');
    return view('users.register');
});

Route::resource('users', UniversityUsersController::class);

Route::post('/users/store', [UniversityUsersController::class, 'store'])->name('users.store');
Route::post('/users/update/{user_id}', [UniversityUsersController::class, 'update'])->name('users.update');
Route::post('/check-whatsapp', [WhatsappController::class, 'check']);
