<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Venta;
use App\Models\VentaProducto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CarritoController extends Controller
{
    public function agregarProducto(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'integer|min:1'
        ]);

        $producto = Producto::findOrFail($request->producto_id);
        $cantidad = $request->cantidad ?? 1;        // Obtener carrito de la sesión
        $carrito = Session::get('carrito', []);

        // Si el producto ya existe en el carrito, no permitir duplicados para cursos digitales
        if (isset($carrito[$producto->id])) {
            return response()->json([
                'success' => false,
                'message' => 'Este curso ya está en tu carrito',
                'carrito_count' => array_sum(array_column($carrito, 'cantidad'))
            ]);
        } else {            // Agregar nuevo producto al carrito
            $carrito[$producto->id] = [
                'id' => $producto->id,
                'nombre' => $producto->nombre,
                'precio' => $producto->precio,
                'imagen' => $producto->image_path,
                'cantidad' => 1 // Siempre cantidad 1 para cursos digitales
            ];
        }

        Session::put('carrito', $carrito);

        return response()->json([
            'success' => true,
            'message' => 'Producto agregado al carrito',
            'carrito_count' => array_sum(array_column($carrito, 'cantidad'))
        ]);
    }

    public function obtenerCarrito()
    {
        $carrito = Session::get('carrito', []);
        $total = 0;
        $cantidad_total = 0;

        foreach ($carrito as &$item) {
            $item['subtotal'] = $item['precio'] * $item['cantidad'];
            $total += $item['subtotal'];
            $cantidad_total += $item['cantidad'];
            
            // Debug: verificar que la imagen esté presente
            \Log::info('Item en carrito:', [
                'id' => $item['id'],
                'nombre' => $item['nombre'],
                'imagen' => $item['imagen'] ?? 'NO_IMAGE'
            ]);
        }

        return response()->json([
            'carrito' => array_values($carrito),
            'total' => $total,
            'cantidad_total' => $cantidad_total
        ]);
    }    

    public function eliminarProducto($producto_id)
    {
        $carrito = Session::get('carrito', []);
        unset($carrito[$producto_id]);
        Session::put('carrito', $carrito);

        return $this->obtenerCarrito();
    }

    public function vaciarCarrito()
    {
        Session::forget('carrito');
        return response()->json(['success' => true, 'message' => 'Carrito vaciado']);
    }

    public function mostrarCheckout()
    {
        if (!session('usuario_auth')) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para continuar con la compra');
        }

        $carrito = Session::get('carrito', []);

        if (empty($carrito)) {
            return redirect('/')->with('error', 'El carrito está vacío');
        }

        $total = 0;
        foreach ($carrito as &$item) {
            $item['subtotal'] = $item['precio'] * $item['cantidad'];
            $total += $item['subtotal'];
        }

        return view('checkout', compact('carrito', 'total'));
    }

    public function procesarCompra(Request $request)
    {
        if (!session('usuario_auth')) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para continuar con la compra');
        }

        $carrito = Session::get('carrito', []);

        if (empty($carrito)) {
            return redirect('/')->with('error', 'El carrito está vacío');
        }        $request->validate([
            'metodo_pago' => 'required|in:tarjeta,paypal,transferencia'
        ]);

        DB::beginTransaction();

        try {
            // Crear la venta
            $venta = Venta::create([
                'id_usuario' => session('usuario_auth'),
                'total' => 0,
                'fecha_venta' => now(),
            ]);

            $total = 0;

            // Agregar productos a la venta
            foreach ($carrito as $item) {
                $producto = Producto::findOrFail($item['id']);

                VentaProducto::create([
                    'id_venta' => $venta->id_venta,
                    'id' => $producto->id,
                    'precio_unitario' => $producto->precio,
                    'cantidad' => $item['cantidad'],
                ]);

                $total += $producto->precio * $item['cantidad'];
            }

            // Actualizar el total de la venta
            $venta->update(['total' => $total]);

            // Vaciar el carrito
            Session::forget('carrito');

            DB::commit();

            return redirect()->route('compra.detalle', $venta->id_venta)->with('success', 'Compra realizada exitosamente');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error al procesar la compra: ' . $e->getMessage());
        }
    }

    public function mostrarDetalleCompra($venta_id)
    {
        if (!session('usuario_auth')) {
            return redirect()->route('login')->with('error', 'No tienes permisos para ver esta compra');
        }

        $venta = Venta::with(['usuario', 'ventaProductos.producto.categoria'])
                     ->where('id_usuario', session('usuario_auth'))
                     ->findOrFail($venta_id);

        return view('detalle-compra', compact('venta'));
    }

    public function misCompras()
    {
        if (!session('usuario_auth')) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para ver tus compras');
        }

        $ventas = Venta::with(['ventaProductos.producto.categoria'])
                      ->where('id_usuario', session('usuario_auth'))
                      ->orderBy('fecha_venta', 'desc')
                      ->paginate(10);

        // Debug temporal - verificar tipos de fecha
        foreach ($ventas as $venta) {
            \Log::info('Venta ID: ' . $venta->id_venta . ', Fecha tipo: ' . gettype($venta->fecha_venta) . ', Valor: ' . $venta->fecha_venta);
        }

        return view('mis-compras', compact('ventas'));
    }
}
