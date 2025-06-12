<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;
use App\Models\Producto;

Route::get('/productos', [ProductoController::class, 'showProductos']);
Route::post('/productos', [ProductoController::class, 'store'])->name('productos.store');
Route::put('/productos/{id}', [ProductoController::class, 'update'])->name('productos.update');
Route::delete('/productos/{id}', [ProductoController::class, 'destroy'])->name('productos.destroy');

Route::resource('categorias', CategoriaController::class)->except(['create', 'edit']);

Route::get('/', function () {
    $productos = Producto::with('categoria')->get();
    return view('inicio', compact('productos'));
});

Route::get('/bootstrap-test', function () { return view('bootstrap_test'); });

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/register', function () {
    return view('register');
})->name('register');

Route::get('/admin', function () {
    return view('admin');
})->name('admin.panel');