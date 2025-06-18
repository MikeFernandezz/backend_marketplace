<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Venta;
use App\Models\VentaProducto;
use App\Models\Usuario;
use App\Models\Producto;

class VentaSeeder extends Seeder
{
    public function run()
    {
        // Verificar que existan usuarios y productos
        $usuario = Usuario::first();
        $productos = Producto::take(3)->get();

        if (!$usuario || $productos->count() < 2) {
            $this->command->warn('No hay suficientes usuarios o productos para crear ventas de ejemplo.');
            return;
        }

        // Crear una venta de ejemplo
        $venta = Venta::create([
            'id_usuario' => $usuario->id_usuario,
            'total' => 0, // Se calculará después
            'fecha_venta' => now(),
        ]);

        $total = 0;

        // Agregar productos a la venta
        foreach ($productos->take(2) as $index => $producto) {
            $cantidad = $index + 1; // 1, 2, etc.
            
            VentaProducto::create([
                'id_venta' => $venta->id_venta,
                'id' => $producto->id,
                'precio_unitario' => $producto->precio,
                'cantidad' => $cantidad,
            ]);

            $total += $producto->precio * $cantidad;
        }

        // Actualizar el total
        $venta->update(['total' => $total]);

        $this->command->info('Venta de ejemplo creada con productos.');
    }
}
