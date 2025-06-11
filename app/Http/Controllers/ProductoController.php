<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index() {
        return Producto::with('categoria')->get();
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric',
            'archivo' => 'nullable|string',
            'id_categoria' => 'required|exists:categorias,id_categoria',
        ]);
        $producto = Producto::create($validated);
        return response()->json($producto, 201);
    }

    public function show($id) {
        $producto = Producto::with('categoria')->findOrFail($id);
        return response()->json($producto);
    }

    public function showProductos() {
        $productos = Producto::with('categoria')->get();
        return view('productos', compact('productos'));
    }

    public function update(Request $request, $id) {
        $producto = Producto::findOrFail($id);
        $validated = $request->validate([
            'nombre' => 'sometimes|required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'sometimes|required|numeric',
            'archivo' => 'nullable|string',
            'id_categoria' => 'sometimes|required|exists:categorias,id_categoria',
        ]);
        $producto->update($validated);
        return response()->json($producto);
    }

    public function destroy($id) {
        $producto = Producto::findOrFail($id);
        $producto->delete();
        return response()->json(['message' => 'Producto eliminado correctamente']);
    }
}
