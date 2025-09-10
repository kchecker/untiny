<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::post('/upscale_image', [App\Http\Controllers\UpscaleJPGController::class, 'upscale']);
Route::get('/success_upscale_image', [App\Http\Controllers\UpscaleJPGController::class, 'success'])->name('success');