<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VentaProducto extends Model
{
    protected $table = 'venta_productos';
    protected $primaryKey = 'id_venta_producto';
    
    protected $fillable = [
        'id_venta',
        'id',
        'precio_unitario',
        'cantidad'
    ];

    protected $casts = [
        'precio_unitario' => 'decimal:2',
        'cantidad' => 'integer'
    ];

    public function venta()
    {
        return $this->belongsTo(Venta::class, 'id_venta', 'id_venta');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id', 'id');
    }

    // Calcular subtotal del producto en la venta
    public function getSubtotalAttribute()
    {
        return $this->precio_unitario * $this->cantidad;
    }
}
