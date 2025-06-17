<?php

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Request;
use App\Models\Producto;
use App\Models\Categoria;

// Vista de productos por categoría
Route::get('/categoria/{id_categoria}', function ($id_categoria) {
    $categoria = Categoria::findOrFail($id_categoria);
    $productos = Producto::with('categoria')
        ->where('id_categoria', $id_categoria)
        ->paginate(12); 
    return view('productos_categoria', compact('categoria', 'productos'));
});
