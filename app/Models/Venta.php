<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $primaryKey = 'id_venta';
    public $timestamps = false;
    protected $fillable = ['id_usuario', 'total', 'fecha_venta'];

    public function usuario() {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }
}
