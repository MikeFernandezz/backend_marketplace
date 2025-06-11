<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;

Route::get('/productos', [ProductoController::class, 'showProductos']);
Route::post('/productos', [ProductoController::class, 'store'])->name('productos.store');
Route::put('/productos/{id}', [ProductoController::class, 'update'])->name('productos.update');
Route::delete('/productos/{id}', [ProductoController::class, 'destroy'])->name('productos.destroy');

Route::resource('categorias', CategoriaController::class)->except(['create', 'edit']);

Route::get('/', function () {
    return view('welcome');
});

Route::get('/bootstrap-test', function () { return view('bootstrap_test'); });
