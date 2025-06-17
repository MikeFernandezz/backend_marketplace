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
<<<<<<< HEAD
               \App\Models\Usuario::create([
            'nombre' => 'Samuel',
            'apellidos' => 'Flores',
            'correo' => 'ramondino@gmail.com',
            'contrasena' => '2003',
=======
        \App\Models\Usuario::create([
            'nombre' => 'Manuel',
            'apellidos' => 'Villanueva',
            'correo' => 'cbum@gmail.com',
            'contrasena' => 'password',
>>>>>>> 8485fc2293fa5403cc978fef74746f18f7748a75
            'rol' => 'admin',
        ]);
    }
}
