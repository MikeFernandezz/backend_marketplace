<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Producto;

class ProductoTest extends TestCase
{
    use RefreshDatabase;

    public function test_crear_producto() {
        $response = $this->postJson('/api/productos', [
            'nombre' => 'Plantilla Web',
            'descripcion' => 'Plantilla moderna HTML/CSS',
            'precio' => 10.50,
            'archivo' => 'plantilla.zip'
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('productos', ['nombre' => 'Plantilla Web']);
    }
}
