<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $fillable = ['nombre', 'descripcion', 'precio', 'archivo', 'id_categoria', 'image_path'];

    protected $casts = [
        'precio' => 'decimal:2'
    ];

    public function categoria() {
        return $this->belongsTo(Categoria::class, 'id_categoria', 'id_categoria');
    }

    public function ventaProductos()
    {
        return $this->hasMany(VentaProducto::class, 'id', 'id');
    }

    public function ventas()
    {
        return $this->belongsToMany(Venta::class, 'venta_productos', 'id', 'id_venta')
                    ->withPivot('precio_unitario', 'cantidad', 'created_at', 'updated_at')
                    ->withTimestamps();
    }
}
