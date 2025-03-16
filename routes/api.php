<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;


Route::middleware('api')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
});
