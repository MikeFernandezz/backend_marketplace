        @extends('layouts.app')

@section('content')
<div class="container my-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none">Inicio</a></li>
            @if($producto->categoria)
                <li class="breadcrumb-item">{{ $producto->categoria->nombre_categoria ?? $producto->categoria->nombre }}</li>
            @endif
            <li class="breadcrumb-item active" aria-current="page">{{ $producto->nombre }}</li>
        </ol>
    </nav>

    <!-- Producto Detalle -->
    <div class="row">
        <!-- Imagen del producto -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm">
                <img src="{{ $producto->image_path ? asset('img/productos/' . $producto->image_path) : 'https://via.placeholder.com/600x400' }}" 
                     class="card-img-top" 
                     alt="{{ $producto->nombre }}" 
                     style="height: 400px; object-fit: cover;">
            </div>
        </div>

        <!-- Información del producto -->
        <div class="col-lg-6">
            <div class="product-info">
                <!-- Título del producto -->
                <h1 class="display-5 fw-bold text-primary mb-3">{{ $producto->nombre }}</h1>
                
                <!-- Categoría -->
                @if($producto->categoria)
                    <div class="mb-3">
                        <span class="badge bg-secondary fs-6 px-3 py-2">
                            <i class="bi bi-tag-fill me-1"></i>
                            {{ $producto->categoria->nombre_categoria ?? $producto->categoria->nombre }}
                        </span>
                    </div>
                @endif

                <!-- Precio -->
                <div class="mb-4">
                    <span class="display-4 fw-bold text-success">${{ number_format($producto->precio, 2) }}</span>
                    <small class="text-muted ms-2">USD</small>
                </div>

                <!-- Descripción -->
                <div class="mb-4">
                    <h5 class="fw-bold mb-3">Descripción del producto</h5>
                    <p class="text-muted fs-6 lh-lg">{{ $producto->descripcion }}</p>
                </div>

                <!-- Botones de acción -->
                <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                    <button type="button" class="btn btn-success btn-lg px-4 me-md-2" onclick="comprarProducto({{ $producto->id }})">
                        <i class="bi bi-cart-check-fill me-2"></i>
                        Comprar Ahora
                    </button>
                    <button type="button" class="btn btn-outline-primary btn-lg px-4" onclick="agregarAlCarrito({{ $producto->id }})">
                        <i class="bi bi-cart-plus me-2"></i>
                        Añadir al Carrito
                    </button>
                </div>

                <!-- Información adicional -->
                <div class="mt-5">
                    <div class="row">
                        <div class="col-12">
                            <div class="card bg-light border-0">
                                <div class="card-body">
                                    <h6 class="card-title fw-bold">
                                        <i class="bi bi-info-circle me-2"></i>
                                        Información adicional
                                    </h6>
                                    <ul class="list-unstyled mb-0">
                                        <li class="mb-2">
                                            <i class="bi bi-check-circle text-success me-2"></i>
                                            Acceso inmediato al contenido
                                        </li>
                                        <li class="mb-2">
                                            <i class="bi bi-check-circle text-success me-2"></i>
                                            Soporte técnico incluido
                                        </li>
                                        <li class="mb-2">
                                            <i class="bi bi-check-circle text-success me-2"></i>
                                            Garantía de satisfacción
                                        </li>
                                        <li class="mb-0">
                                            <i class="bi bi-check-circle text-success me-2"></i>
                                            Actualizaciones gratuitas
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Productos relacionados -->
    <div class="mt-5">
        <h3 class="mb-4">Productos relacionados</h3>
        <div class="row">
            @php
                $productosRelacionados = App\Models\Producto::where('id_categoria', $producto->id_categoria)
                    ->where('id', '!=', $producto->id)
                    ->take(3)
                    ->get();
            @endphp
            
            @if($productosRelacionados->count() > 0)
                @foreach($productosRelacionados as $relacionado)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <a href="{{ route('producto.detalle', $relacionado->id) }}" class="text-decoration-none">
                                <img src="{{ $relacionado->image_path ? asset('img/productos/' . $relacionado->image_path) : 'https://via.placeholder.com/400x250' }}" 
                                     class="card-img-top" 
                                     alt="{{ $relacionado->nombre }}" 
                                     style="height: 200px; object-fit: cover;">
                            </a>
                            <div class="card-body">
                                <a href="{{ route('producto.detalle', $relacionado->id) }}" class="text-decoration-none text-dark">
                                    <h6 class="card-title">{{ $relacionado->nombre }}</h6>
                                </a>
                                <p class="card-text text-muted small">{{ Str::limit($relacionado->descripcion, 80) }}</p>
                                <span class="badge bg-success">${{ $relacionado->precio }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        <i class="bi bi-info-circle me-2"></i>
                        No hay productos relacionados disponibles.
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- JavaScript para funcionalidad de botones -->
<script>
function comprarProducto(productoId) {
    // Por el momento, mostrar un mensaje
    alert('Funcionalidad de compra será implementada próximamente.\nProducto ID: ' + productoId);
    
    // Aquí se implementará la lógica de compra
    console.log('Comprando producto con ID:', productoId);
}

function agregarAlCarrito(productoId) {
    // Por el momento, mostrar un mensaje
    alert('Funcionalidad de carrito será implementada próximamente.\nProducto añadido al carrito.\nProducto ID: ' + productoId);
    
    // Aquí se implementará la lógica del carrito
    console.log('Añadiendo al carrito producto con ID:', productoId);
    
    // Feedback visual temporal
    const boton = event.target;
    const textoOriginal = boton.innerHTML;
    boton.innerHTML = '<i class="bi bi-check me-2"></i>¡Añadido!';
    boton.classList.remove('btn-outline-primary');
    boton.classList.add('btn-success');
    
    setTimeout(() => {
        boton.innerHTML = textoOriginal;
        boton.classList.remove('btn-success');
        boton.classList.add('btn-outline-primary');
    }, 2000);
}
</script>

<!-- Estilos adicionales -->
<style>
.product-info h1 {
    line-height: 1.2;
}

.card-img-top {
    transition: transform 0.3s ease;
}

.card:hover .card-img-top {
    transform: scale(1.05);
}

.btn {
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.breadcrumb-item a:hover {
    color: #0d6efd !important;
}
</style>
@endsection
