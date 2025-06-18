<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Producto;
use App\Models\Categoria;

class CarritoTestSeederFixed extends Seeder
{
    public function run()
    {
        // Asegurar que tenemos categorías
        $categorias = [
            ['nombre_categoria' => 'Programación', 'descripcion' => 'Cursos de programación y desarrollo'],
            ['nombre_categoria' => 'Diseño', 'descripcion' => 'Cursos de diseño gráfico y web'],
            ['nombre_categoria' => 'Marketing', 'descripcion' => 'Cursos de marketing digital'],
            ['nombre_categoria' => 'Negocios', 'descripcion' => 'Cursos de administración y negocios'],
        ];

        foreach ($categorias as $categoria) {
            Categoria::firstOrCreate(['nombre_categoria' => $categoria['nombre_categoria']], $categoria);
        }

        // Productos de ejemplo para el carrito
        $productos = [
            [
                'nombre' => 'Curso Completo de JavaScript',
                'descripcion' => 'Aprende JavaScript desde cero hasta nivel avanzado con proyectos prácticos',
                'precio' => 89.99,
                'id_categoria' => 1,
                'image_path' => 'curso_javascript.jpg'
            ],
            [
                'nombre' => 'Diseño Web con HTML5 y CSS3',
                'descripcion' => 'Crea sitios web modernos y responsivos con las últimas tecnologías',
                'precio' => 69.99,
                'id_categoria' => 1,
                'image_path' => 'curso_html_css.jpg'
            ],
            [
                'nombre' => 'Python para Principiantes',
                'descripcion' => 'Iníciate en la programación con Python, el lenguaje más versátil',
                'precio' => 79.99,
                'id_categoria' => 1,
                'image_path' => 'curso_python.jpg'
            ],
            [
                'nombre' => 'Diseño Gráfico Profesional',
                'descripcion' => 'Domina Adobe Photoshop e Illustrator para crear diseños impactantes',
                'precio' => 99.99,
                'id_categoria' => 2,
                'image_path' => 'curso_diseno.jpg'
            ],
            [
                'nombre' => 'Marketing Digital Completo',
                'descripcion' => 'Estrategias de marketing digital para hacer crecer tu negocio online',
                'precio' => 129.99,
                'id_categoria' => 3,
                'image_path' => 'curso_marketing.jpg'
            ],
            [
                'nombre' => 'React y Node.js Full Stack',
                'descripcion' => 'Desarrollo completo de aplicaciones web con React y Node.js',
                'precio' => 149.99,
                'id_categoria' => 1,
                'image_path' => 'curso_react.jpg'
            ],
            [
                'nombre' => 'WordPress Avanzado',
                'descripcion' => 'Crea sitios web profesionales con WordPress y plugins personalizados',
                'precio' => 59.99,
                'id_categoria' => 1,
                'image_path' => 'curso_wordpress.jpg'
            ],
            [
                'nombre' => 'UI/UX Design Fundamentals',
                'descripcion' => 'Principios de diseño de experiencia de usuario y interfaces modernas',
                'precio' => 89.99,
                'id_categoria' => 2,
                'image_path' => 'curso_ux.jpg'
            ],
            [
                'nombre' => 'Java Programming Masterclass',
                'descripcion' => 'Domina Java y la programación orientada a objetos desde cero',
                'precio' => 109.99,
                'id_categoria' => 1,
                'image_path' => 'curso_java.jpg'
            ],
            [
                'nombre' => 'Emprendimiento Digital',
                'descripcion' => 'Cómo crear y hacer crecer un negocio digital exitoso',
                'precio' => 79.99,
                'id_categoria' => 4,
                'image_path' => 'curso_emprendimiento.jpg'
            ]
        ];

        foreach ($productos as $producto) {
            Producto::firstOrCreate(['nombre' => $producto['nombre']], $producto);
        }
    }
}
