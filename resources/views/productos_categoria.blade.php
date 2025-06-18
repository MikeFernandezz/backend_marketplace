@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h2 class="mb-4">Productos de la categoría: {{ $categoria->nombre_categoria }}</h2>
    <div class="row">
        @forelse($productos as $producto)            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <a href="{{ route('producto.detalle', $producto->id) }}" class="text-decoration-none">
                        <img src="{{ $producto->image_path ? asset('img/productos/' . $producto->image_path) : 'https://via.placeholder.com/400x250' }}" class="card-img-top" alt="{{ $producto->nombre }}" style="height: 200px; object-fit: cover;">
                    </a>
                    <div class="card-body">
                        <a href="{{ route('producto.detalle', $producto->id) }}" class="text-decoration-none text-dark">
                            <h5 class="card-title">{{ $producto->nombre }}</h5>
                        </a>
                        <p class="card-text">{{ Str::limit($producto->descripcion, 100) }}</p>
                        <span class="badge bg-success">${{ $producto->precio }}</span>
                    </div>
                    <div class="card-footer bg-transparent border-0">
                        <div class="d-grid gap-2">
                            <a href="{{ route('producto.detalle', $producto->id) }}" class="btn btn-primary">Ver Detalles</a>
                            @if(session('usuario_auth'))
                                <button type="button" class="btn btn-outline-success" onclick="agregarAlCarrito({{ $producto->id }})">
                                    <i class="bi bi-cart-plus me-2"></i>Agregar al Carrito
                                </button>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-outline-success">
                                    <i class="bi bi-cart-plus me-2"></i>Agregar al Carrito
                                </a>
                            @endif
                        </div>
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
