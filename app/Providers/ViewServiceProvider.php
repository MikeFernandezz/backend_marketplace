<?php
use App\Models\Categoria;

// Compartir todas las categorías con todas las vistas
view()->composer('*', function ($view) {
    $view->with('categorias', Categoria::all());
});
