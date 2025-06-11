<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriaSeeder extends Seeder
{
    public function run()
    {
        $categorias = [
            ['nombre_categoria' => 'Programación Web', 'descripcion' => null],
            ['nombre_categoria' => 'Desarrollo de Software', 'descripcion' => null],
            ['nombre_categoria' => 'Ciberseguridad', 'descripcion' => null],
            ['nombre_categoria' => 'Inteligencia Artificial', 'descripcion' => null],
            ['nombre_categoria' => 'Bases de Datos', 'descripcion' => null],
            ['nombre_categoria' => 'Desarrollo Móvil', 'descripcion' => null],
            ['nombre_categoria' => 'Ofimática y Productividad', 'descripcion' => null],
        ];
        DB::table('categorias')->insert($categorias);
    }
}
