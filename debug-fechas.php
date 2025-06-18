<?php

use App\Models\Venta;
use Carbon\Carbon;

// Script de debug para verificar el manejo de fechas en las ventas
echo "=== DEBUG FECHAS VENTAS ===\n";

// Obtener una venta de ejemplo
$venta = Venta::first();

if ($venta) {
    echo "ID Venta: " . $venta->id_venta . "\n";
    echo "Fecha original: " . $venta->fecha_venta . "\n";
    echo "Tipo de dato: " . gettype($venta->fecha_venta) . "\n";
    echo "Es instancia de Carbon: " . ($venta->fecha_venta instanceof Carbon ? 'SÍ' : 'NO') . "\n";
    
    // Intentar diferentes métodos de formateo
    try {
        echo "Format method: " . $venta->fecha_venta->format('d/m/Y H:i') . "\n";
    } catch (Exception $e) {
        echo "Error con format(): " . $e->getMessage() . "\n";
    }
    
    try {
        echo "Carbon parse: " . Carbon::parse($venta->fecha_venta)->format('d/m/Y H:i') . "\n";
    } catch (Exception $e) {
        echo "Error con Carbon::parse(): " . $e->getMessage() . "\n";
    }
    
    try {
        echo "date() function: " . date('d/m/Y H:i', strtotime($venta->fecha_venta)) . "\n";
    } catch (Exception $e) {
        echo "Error con date(): " . $e->getMessage() . "\n";
    }
    
} else {
    echo "No hay ventas en la base de datos\n";
}

echo "=== FIN DEBUG ===\n";
?>
