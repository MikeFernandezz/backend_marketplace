<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use Illuminate\Http\Request;

class VentaController extends Controller
{
    public function index()
    {
        return response()->json(Venta::with('usuario')->get());
    }

    public function show($id)
    {
        return response()->json(Venta::with('usuario')->findOrFail($id));
    }

    public function store(Request $request)
    {
        $venta = Venta::create($request->all());
        return response()->json($venta, 201);
    }

    public function update(Request $request, $id)
    {
        $venta = Venta::findOrFail($id);
        $venta->update($request->all());
        return response()->json($venta);
    }

    public function destroy($id)
    {
        Venta::destroy($id);
        return response()->json(null, 204);
    }
}
