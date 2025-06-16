@extends('layouts.app')

@section('content')
<div class="container my-5">
    <!-- Banner principal -->
    <div class="jumbotron text-white bg-primary rounded shadow p-5 mb-5 text-center">
        <h1 class="display-4 font-weight-bold">Bienvenido al Marketplace</h1>
        <p class="lead">Encuentra los mejores productos al mejor precio</p>
        <a href="#productos" class="btn btn-light btn-lg mt-3">Ver productos</a>
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
