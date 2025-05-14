<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index() {
        return Producto::all();
    }

    public function store(Request $request) {
        $producto = Producto::create($request->all());
        return response()->json($producto, 201);
    }

    public function showProductos() {
        $productos = Producto::all();
        return view('productos', compact('productos'));
    }
}
