<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $fillable = ['nombre', 'descripcion', 'precio', 'archivo', 'id_categoria', 'image_path'];

    public function categoria() {
        return $this->belongsTo(Categoria::class, 'id_categoria', 'id_categoria');
    }
}
