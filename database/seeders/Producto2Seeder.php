<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Producto;

class Producto2Seeder extends Seeder
{
    public function run() {
        Producto::create([
            'nombre' => 'Fotos de Pies',
            'descripcion' => 'Fotos de pies de alta calidad.',
            'precio' => 9.99,
            'archivo' => 'fotos-pies.jpg'
        ]);
    }
}
