import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
                // CSS modular
                'resources/css/admin/usuarios.css',
                'resources/css/producto-detalle.css',
                'resources/css/checkout.css',
                'resources/css/detalle-compra.css',
                'resources/css/mis-compras.css',
                'resources/css/ventas/ventas-shared.css',
                'resources/css/ventas/venta-detalle.css',
                // JS modular
                'resources/js/producto-detalle.js',
                'resources/js/checkout.js',
                'resources/js/detalle-compra.js',
            ],
            refresh: true,
        }),
    ],
});
