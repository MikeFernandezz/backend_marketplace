<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\VentaProducto;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    public function index()
    {
        return response()->json(
            Venta::with(['usuario', 'ventaProductos.producto.categoria'])->get()
        );
    }

    public function show($id)
    {
        return response()->json(
            Venta::with(['usuario', 'ventaProductos.producto.categoria'])
                 ->findOrFail($id)
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_usuario' => 'required|exists:usuarios,id_usuario',
            'productos' => 'required|array|min:1',
            'productos.*.id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        
        try {
            // Crear la venta
            $venta = Venta::create([
                'id_usuario' => $request->id_usuario,
                'total' => 0, // Se calculará después
                'fecha_venta' => now(),
            ]);

            $total = 0;

            // Agregar productos a la venta
            foreach ($request->productos as $productoData) {
                $producto = Producto::findOrFail($productoData['id']);
                
                $ventaProducto = VentaProducto::create([
                    'id_venta' => $venta->id_venta,
                    'id' => $producto->id,
                    'precio_unitario' => $producto->precio,
                    'cantidad' => $productoData['cantidad'],
                ]);

                $total += $producto->precio * $productoData['cantidad'];
            }

            // Actualizar el total de la venta
            $venta->update(['total' => $total]);

            DB::commit();

            // Retornar la venta con sus productos
            $venta->load(['usuario', 'ventaProductos.producto.categoria']);
            
            return response()->json($venta, 201);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Error al crear la venta: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'productos' => 'sometimes|array|min:1',
            'productos.*.id' => 'required_with:productos|exists:productos,id',
            'productos.*.cantidad' => 'required_with:productos|integer|min:1',
        ]);

        DB::beginTransaction();
        
        try {
            $venta = Venta::findOrFail($id);

            // Si se proporcionan productos, actualizar la venta
            if ($request->has('productos')) {
                // Eliminar productos existentes
                VentaProducto::where('id_venta', $venta->id_venta)->delete();

                $total = 0;

                // Agregar nuevos productos
                foreach ($request->productos as $productoData) {
                    $producto = Producto::findOrFail($productoData['id']);
                    
                    VentaProducto::create([
                        'id_venta' => $venta->id_venta,
                        'id' => $producto->id,
                        'precio_unitario' => $producto->precio,
                        'cantidad' => $productoData['cantidad'],
                    ]);

                    $total += $producto->precio * $productoData['cantidad'];
                }

                $venta->update(['total' => $total]);
            }

            // Actualizar otros campos si se proporcionan
            $venta->update($request->except(['productos']));

            DB::commit();

            $venta->load(['usuario', 'ventaProductos.producto.categoria']);
            
            return response()->json($venta);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Error al actualizar la venta: ' . $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        
        try {
            $venta = Venta::findOrFail($id);
            
            // Los productos se eliminarán automáticamente por la clave foránea en cascada
            $venta->delete();
            
            DB::commit();
            
            return response()->json(null, 204);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Error al eliminar la venta: ' . $e->getMessage()], 500);
        }
    }

    // Método adicional para obtener productos de una venta específica
    public function getProductos($id)
    {
        $venta = Venta::findOrFail($id);
        
        return response()->json(
            $venta->ventaProductos()->with('producto.categoria')->get()
        );
    }

    // Método adicional para agregar un producto a una venta existente
    public function addProducto(Request $request, $id)
    {
        $request->validate([
            'id_producto' => 'required|exists:productos,id',
            'cantidad' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        
        try {
            $venta = Venta::findOrFail($id);
            $producto = Producto::findOrFail($request->id_producto);

            // Verificar si el producto ya existe en la venta
            $ventaProductoExistente = VentaProducto::where('id_venta', $venta->id_venta)
                                                   ->where('id', $producto->id)
                                                   ->first();

            if ($ventaProductoExistente) {
                return response()->json(['error' => 'El producto ya existe en esta venta'], 400);
            }

            // Agregar el producto
            $ventaProducto = VentaProducto::create([
                'id_venta' => $venta->id_venta,
                'id' => $producto->id,
                'precio_unitario' => $producto->precio,
                'cantidad' => $request->cantidad,
            ]);

            // Actualizar el total de la venta
            $nuevoTotal = $venta->total + ($producto->precio * $request->cantidad);
            $venta->update(['total' => $nuevoTotal]);

            DB::commit();

            return response()->json($ventaProducto->load('producto.categoria'), 201);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Error al agregar producto: ' . $e->getMessage()], 500);
        }
    }

    // Método adicional para remover un producto de una venta
    public function removeProducto($ventaId, $productoId)
    {
        DB::beginTransaction();
        
        try {
            $venta = Venta::findOrFail($ventaId);
            $ventaProducto = VentaProducto::where('id_venta', $venta->id_venta)
                                          ->where('id', $productoId)
                                          ->firstOrFail();

            $subtotal = $ventaProducto->precio_unitario * $ventaProducto->cantidad;
            
            // Eliminar el producto de la venta
            $ventaProducto->delete();

            // Actualizar el total de la venta
            $nuevoTotal = $venta->total - $subtotal;
            $venta->update(['total' => $nuevoTotal]);

            DB::commit();

            return response()->json(null, 204);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Error al remover producto: ' . $e->getMessage()], 500);
        }
    }    // Métodos para el panel de administrador
    public function adminIndex(Request $request)
    {
        $query = Venta::with(['usuario', 'ventaProductos.producto.categoria']);
        
        // Filtrar por fechas
        if ($request->filled('fecha_desde')) {
            $query->whereDate('fecha_venta', '>=', $request->fecha_desde);
        }
        
        if ($request->filled('fecha_hasta')) {
            $query->whereDate('fecha_venta', '<=', $request->fecha_hasta);
        }
        
        // Filtrar por usuario
        if ($request->filled('usuario')) {
            $query->whereHas('usuario', function ($q) use ($request) {
                $q->where('nombre', 'LIKE', '%' . $request->usuario . '%')
                  ->orWhere('correo', 'LIKE', '%' . $request->usuario . '%');
            });
        }
        
        $ventas = $query->orderBy('fecha_venta', 'desc')->get();
        
        return view('ventas.index', compact('ventas'));
    }

    public function adminShow($id)
    {
        $venta = Venta::with(['usuario', 'ventaProductos.producto.categoria'])
                     ->findOrFail($id);
        
        return view('ventas.show', compact('venta'));
    }

    public function exportCsv(Request $request)
    {
        $query = Venta::with(['usuario', 'ventaProductos.producto.categoria']);
        
        // Aplicar los mismos filtros que en adminIndex
        if ($request->filled('fecha_desde')) {
            $query->whereDate('fecha_venta', '>=', $request->fecha_desde);
        }
        
        if ($request->filled('fecha_hasta')) {
            $query->whereDate('fecha_venta', '<=', $request->fecha_hasta);
        }
        
        if ($request->filled('usuario')) {
            $query->whereHas('usuario', function ($q) use ($request) {
                $q->where('nombre', 'LIKE', '%' . $request->usuario . '%')
                  ->orWhere('correo', 'LIKE', '%' . $request->usuario . '%');
            });
        }
        
        $ventas = $query->orderBy('fecha_venta', 'desc')->get();
        
        $filename = 'ventas_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $callback = function() use ($ventas) {
            $file = fopen('php://output', 'w');
            
            // Agregar BOM para UTF-8
            fwrite($file, "\xEF\xBB\xBF");
            
            // Encabezados
            fputcsv($file, [
                'ID Venta',
                'Usuario',
                'Email Usuario',
                'Fecha Venta',
                'Total',
                'Cantidad Productos',
                'Productos',
                'Categorías'
            ]);
            
            foreach ($ventas as $venta) {
                $productos = $venta->ventaProductos->pluck('producto.nombre')->filter()->implode(', ');
                $categorias = $venta->ventaProductos->pluck('producto.categoria.nombre_categoria')->filter()->unique()->implode(', ');
                  fputcsv($file, [
                    $venta->id_venta,
                    $venta->usuario ? $venta->usuario->nombre . ' ' . $venta->usuario->apellidos : 'N/A',
                    $venta->usuario->correo ?? 'N/A',
                    $venta->fecha_venta ? $venta->fecha_venta->format('Y-m-d H:i:s') : 'N/A',
                    $venta->total,
                    $venta->ventaProductos->count(),
                    $productos,
                    $categorias
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}
