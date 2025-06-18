<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $primaryKey = 'id_venta';
    public $timestamps = false; // Deshabilitado porque usamos fecha_venta personalizada
    protected $fillable = ['id_usuario', 'total', 'fecha_venta'];

    protected $casts = [
        'total' => 'decimal:2',
        'fecha_venta' => 'datetime'
    ];

    // Asegurar que fecha_venta se trate como datetime
    protected $dates = [
        'fecha_venta'
    ];

    public function usuario() {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    public function ventaProductos()
    {
        return $this->hasMany(VentaProducto::class, 'id_venta', 'id_venta');
    }

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'venta_productos', 'id_venta', 'id')
                    ->withPivot('precio_unitario', 'cantidad', 'created_at', 'updated_at')
                    ->withTimestamps();
    }

    // Calcular el total automáticamente basado en los productos
    public function calcularTotal()
    {
        $total = 0;
        foreach ($this->ventaProductos as $ventaProducto) {
            $total += $ventaProducto->precio_unitario * $ventaProducto->cantidad;
        }
        return $total;
    }
}
