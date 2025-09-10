<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::post('/upscale_image', [App\Http\Controllers\upscaleController::class, 'upscaleImage']);
Route::post('/upscale_image', [App\Http\Controllers\UpscaleController::class, 'upscale']);
Route::get('/success_upscale_image', [App\Http\Controllers\UpscaleController::class, 'success'])->name('success');

