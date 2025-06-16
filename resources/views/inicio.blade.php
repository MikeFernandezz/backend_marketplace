@extends('layouts.app')

@section('content')
<div class="container my-5">
    <!-- Banner principal -->
    <div class="jumbotron text-white bg-primary rounded shadow p-5 mb-5 text-center">
        <h1 class="display-4 font-weight-bold">Bienvenido a Coursemaket</h1>
        <p class="lead">Desbloquea tu potencial con la tecnologia educativa</p>
        <a href="#productos" class="btn btn-light btn-lg mt-3">Ver productos</a>
    </div>

    <!-- Display de productos -->
    <h2 id="productos" class="mb-4">Productos destacados</h2>
    <div class="row">
        @forelse($productos as $producto)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <img src="{{ $producto->archivo ? asset('storage/' . $producto->archivo) : 'https://via.placeholder.com/400x250' }}" class="card-img-top" alt="{{ $producto->nombre }}">
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
