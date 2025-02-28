<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::apiResource('profiles', ProfileController::class);

Route::get('test', function () {
    return 'working?';
});

Route::get('/profiles', [ProfileController::class, 'getActiveProfiles']);
Route::post('/login', [LoginController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::delete('/profiles/{profile}', [ProfileController::class, 'destroy']);
});
