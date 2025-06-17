<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsuarioAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Usuario::create([
            'nombre' => 'Manuel',
            'apellidos' => 'Villanueva',
            'correo' => 'cbum@gmail.com',
            'contrasena' => 'password',
            'rol' => 'admin',
        ]);
    }
}
