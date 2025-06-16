<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsuarioAdminSeed extends Seeder
{
        public function run(): void
    {
        \App\Models\Usuario::create([
            'nombre' => 'Miguel',
            'apellidos' => 'Fernandez',
            'correo' => 'root@root.com',
            'contrasena' => 'admin',
            'rol' => 'admin',
        ]);
    }
}
