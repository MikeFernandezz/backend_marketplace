@extends('layouts.app')

@section('content')
<div class="container my-5">

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

    <!-- Título principal -->
    <div class="text-center mb-5">
        <h1 class="fw-bold text-primary-emphasis">Bienvenido al Marketplace de Cursos</h1>
        <p class="fs-5 text-muted">Cursos de alta calidad para tu desarrollo profesional</p>
        <a href="#productos" class="btn btn-success btn-lg px-4">Ver productos</a>
    </div>

    <!-- Productos destacados -->
    <h2 id="productos" class="mb-4 text-success">Productos destacados</h2>
    <div class="row">
        @forelse($productos as $producto)
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm rounded-3">
                    <img src="{{ $producto->archivo ? asset('storage/' . $producto->archivo) : 'https://via.placeholder.com/400x250' }}" class="card-img-top" alt="{{ $producto->nombre }}">
                    <div class="card-body">
                        <h5 class="card-title text-primary">{{ $producto->nombre }}</h5>
                        <p class="card-text text-muted">{{ Str::limit($producto->descripcion, 80) }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge bg-success fs-6">${{ $producto->precio }}</span>
                            @if($producto->categoria)
                                <span class="badge bg-info">{{ $producto->categoria->nombre }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0">
                        <a href="#" class="btn btn-outline-success w-100">Comprar</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">No hay productos disponibles en este momento.</div>
            </div>
        @endforelse
    </div>
</div>
@endsection
