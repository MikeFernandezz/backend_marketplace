@extends('layouts.app')

@section('content')
<div class="container my-5">

    <!-- Banner principal -->
    <div class="jumbotron text-white bg-primary rounded shadow p-5 mb-5 text-center">
        <h1 class="display-4 font-weight-bold">Bienvenido a Coursemaket</h1>
        <p class="lead">Desbloquea tu potencial con la tecnologia educativa</p>
        <a href="#productos" class="btn btn-light btn-lg mt-3">Ver productos</a>
    </div>

<!-- Carrusel de novedades -->
    <div id="cursosCarrusel" class="carousel slide mb-5" data-bs-ride="carousel">
        <div class="carousel-inner rounded shadow">
            <div class="carousel-item active">
                <img src="https://via.placeholder.com/1200x400?text=¡Nuevos+Cursos+de+Programación!" class="d-block w-100" alt="Novedades 1">
            </div>
            <div class="carousel-item">
                <img src="https://via.placeholder.com/1200x400?text=Aprende+Inteligencia+Artificial" class="d-block w-100" alt="Novedades 2">
            </div>
            <div class="carousel-item">
                <img src="https://via.placeholder.com/1200x400?text=Descuentos+exclusivos+este+mes" class="d-block w-100" alt="Novedades 3">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#cursosCarrusel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#cursosCarrusel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>

    <!-- Display de productos -->
    <h2 id="productos" class="mb-4">Productos destacados</h2>
    <div class="row">
        @forelse($productos as $producto)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <img src="{{ $producto->image_path ? asset('img/productos/' . $producto->image_path) : 'https://via.placeholder.com/400x250' }}" class="card-img-top" alt="{{ $producto->nombre }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $producto->nombre }}</h5>
                        <p class="card-text">{{ $producto->descripcion }}</p>
                        <span class="badge bg-success">${{ $producto->precio }}</span>
                        @if($producto->categoria)
                            <span class="badge bg-secondary ms-2">{{ $producto->categoria->nombre }}</span>
                        @endif
                    </div>
                    <div class="card-footer bg-transparent border-0">
                        <a href="#" class="btn btn-primary w-100">Comprar</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">No hay productos disponibles.</div>
            </div>
        @endforelse
    </div>
</div>

@endsection
