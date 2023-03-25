<?php

use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function() {
    Route::post('/login', [\Modules\Auth\Http\Controllers\AuthController::class, 'login']);
});
