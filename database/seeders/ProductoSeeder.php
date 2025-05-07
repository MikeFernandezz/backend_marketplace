<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Producto;

class ProductoSeeder extends Seeder
{
    public function run() {
        Producto::create([
            'nombre' => 'Curso de Laravel',
            'descripcion' => 'Curso completo de desarrollo con Laravel.',
            'precio' => 49.99,
            'archivo' => 'curso-laravel.zip'
        ]);
    }
}
