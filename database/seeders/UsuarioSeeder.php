<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
           \App\Models\Usuario::create([
            'nombre' => 'Samuel',
            'apellidos' => 'Flores',
            'correo' => 'ramondino@gmail.com',
            'contrasena' => '2003',
            'rol' => 'cliente',
        ]);
    }
}
