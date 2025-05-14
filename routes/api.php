<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;


Route::prefix('productos')->group(function () {
    Route::get('/', [ProductoController::class, 'index']);
    Route::post('/', [ProductoController::class, 'store']);
});
