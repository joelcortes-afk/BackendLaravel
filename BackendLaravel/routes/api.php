<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BackendController;

Route::get('/test', function () {
    return "El backend funciona correctamente.";
});

Route::get('/backend', [BackendController::class, 'get']);