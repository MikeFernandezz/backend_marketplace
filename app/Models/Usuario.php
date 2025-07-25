<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';
    public $timestamps = false;
    protected $fillable = ['nombre', 'apellidos', 'correo', 'contrasena', 'rol', 'creado_en'];

    public function ventas() {
        return $this->hasMany(Venta::class, 'id_usuario', 'id_usuario');
    }
}
