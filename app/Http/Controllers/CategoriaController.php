<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::all();
        return view('categorias.index', compact('categorias'));
    }

    public function show($id)
    {
        $categoria = Categoria::findOrFail($id);
        return view('categorias.show', compact('categoria'));
    }

    public function create()
    {
        return view('categorias.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre_categoria' => 'required|string|max:255',
        ]);
        $categoria = Categoria::create($validated);
        return redirect()->route('admin.categorias.index')->with('success', 'Categoría creada correctamente');
    }

    public function edit($id)
    {
        $categoria = Categoria::findOrFail($id);
        return view('categorias.edit', compact('categoria'));
    }

    public function update(Request $request, $id)
    {
        $categoria = Categoria::findOrFail($id);
        $validated = $request->validate([
            'nombre_categoria' => 'required|string|max:255',
        ]);
        $categoria->update($validated);
        return redirect()->route('admin.categorias.show', $categoria->id_categoria)->with('success', 'Categoría actualizada correctamente');
    }

    public function destroy($id)
    {
        Categoria::destroy($id);
        return redirect()->route('admin.categorias.index')->with('success', 'Categoría eliminada correctamente');
    }
}
