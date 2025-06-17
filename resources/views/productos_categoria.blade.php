@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h2 class="mb-4">Productos de la categoría: {{ $categoria->nombre_categoria }}</h2>
    <div class="row">
        @forelse($productos as $producto)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <img src="{{ $producto->image_path ? asset('img/productos/' . $producto->image_path) : 'https://via.placeholder.com/400x250' }}" class="card-img-top" alt="{{ $producto->nombre }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $producto->nombre }}</h5>
                        <p class="card-text">{{ $producto->descripcion }}</p>
                        <span class="badge bg-success">${{ $producto->precio }}</span>
                    </div>
                    <div class="card-footer bg-transparent border-0">
                        <a href="#" class="btn btn-primary w-100">Comprar</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center">
                <img src="https://via.placeholder.com/400x250?text=Sin+productos" class="mb-3" style="max-width:300px;">
                <p class="text-muted">No hay productos en esta categoría.</p>
            </div>
        @endforelse
    </div>
    <div class="d-flex justify-content-center mt-4">
        {{ $productos->links() }}
    </div>
</div>
@endsection
