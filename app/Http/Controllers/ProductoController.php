<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index() {
        $productos = Producto::with('categoria')->get();
        return view('productos.index', compact('productos'));
    }

    public function create() {
        return view('productos.create');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric',
            'archivo' => 'nullable|string',
            'id_categoria' => 'required|exists:categorias,id_categoria',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('img/productos'), $imageName);
            $validated['image_path'] = $imageName;
        }

        $producto = Producto::create($validated);
        return redirect()->route('admin.productos.index')->with('success', 'Producto creado correctamente');
    }

    public function show($id) {
        $producto = Producto::with('categoria')->findOrFail($id);
        return view('productos.show', compact('producto'));
    }

    public function edit($id) {
        $producto = Producto::findOrFail($id);
        return view('productos.edit', compact('producto'));
    }

    public function update(Request $request, $id) {
        $producto = Producto::findOrFail($id);
        $validated = $request->validate([
            'nombre' => 'sometimes|required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'sometimes|required|numeric',
            'archivo' => 'nullable|string',
            'id_categoria' => 'sometimes|required|exists:categorias,id_categoria',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('img/productos'), $imageName);
            $validated['image_path'] = $imageName;
        }

        $producto->update($validated);
        return redirect()->route('admin.productos.show', $producto->id)->with('success', 'Producto actualizado correctamente');
    }

    public function destroy($id) {
        $producto = Producto::findOrFail($id);
        $producto->delete();
        return redirect()->route('admin.productos.index')->with('success', 'Producto eliminado correctamente');
    }
}
