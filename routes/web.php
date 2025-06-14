<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;
use App\Models\Producto;

Route::prefix('admin')->group(function () {
    Route::resource('productos', ProductoController::class)->names([
        'index' => 'admin.productos.index',
        'create' => 'admin.productos.create',
        'store' => 'admin.productos.store',
        'show' => 'admin.productos.show',
        'edit' => 'admin.productos.edit',
        'update' => 'admin.productos.update',
        'destroy' => 'admin.productos.destroy',
    ]);
    Route::resource('categorias', CategoriaController::class)->names([
        'index' => 'admin.categorias.index',
        'create' => 'admin.categorias.create',
        'store' => 'admin.categorias.store',
        'show' => 'admin.categorias.show',
        'edit' => 'admin.categorias.edit',
        'update' => 'admin.categorias.update',
        'destroy' => 'admin.categorias.destroy',
    ]);
});

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