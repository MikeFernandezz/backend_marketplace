<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;


Route::get('/productos', [ProductoController::class, 'showProductos']);

Route::get('/', function () {
    return view('welcome');
});



