<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::apiResource('profiles', ProfileController::class);

Route::get('test', function () {
    return 'working?';
});
