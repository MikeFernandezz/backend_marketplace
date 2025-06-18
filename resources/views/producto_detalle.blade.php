@extends('layouts.app')

@section('content')
<div class="container my-5">
    <!-- Breadcrumb con estilo mejorado -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-light rounded-pill px-4 py-2 shadow-sm">
            <li class="breadcrumb-item">
                <a href="{{ url('/') }}" class="text-decoration-none d-flex align-items-center">
                    <i class="bi bi-house-fill me-1"></i>
                    Inicio
                </a>
            </li>
            @if($producto->categoria)
                <li class="breadcrumb-item">
                    <a href="{{ url('/categoria/' . $producto->id_categoria) }}" class="text-decoration-none">
                        {{ $producto->categoria->nombre_categoria ?? $producto->categoria->nombre }}
                    </a>
                </li>
            @endif
            <li class="breadcrumb-item active" aria-current="page">{{ $producto->nombre }}</li>
        </ol>
    </nav>

    <!-- Producto Detalle con diseño mejorado -->
    <div class="row g-4">
        <!-- Imagen del producto -->
        <div class="col-lg-6">
            <div class="product-image-container">
                <div class="card border-0 shadow-lg overflow-hidden h-100">
                    <div class="position-relative">
                        <img src="{{ $producto->image_path ? asset('img/productos/' . $producto->image_path) : 'https://via.placeholder.com/600x400' }}" 
                             class="card-img-top product-main-image" 
                             alt="{{ $producto->nombre }}">
                        <div class="product-image-overlay">
                            <div class="d-flex justify-content-center align-items-center h-100">
                                <button class="btn btn-light btn-sm rounded-pill" onclick="expandImage()">
                                    <i class="bi bi-arrows-fullscreen me-1"></i>
                                    Ver imagen completa
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Información del producto -->
        <div class="col-lg-6">
            <div class="product-info h-100">
                <div class="card border-0 shadow-lg h-100">
                    <div class="card-body p-4">
                        <!-- Categoría -->
                        @if($producto->categoria)
                            <div class="mb-3">
                                <span class="badge bg-secondary fs-6 px-3 py-2 rounded-pill">
                                    <i class="bi bi-tag-fill me-1"></i>
                                    {{ $producto->categoria->nombre_categoria ?? $producto->categoria->nombre }}
                                </span>
                            </div>
                        @endif

                        <!-- Título del producto -->
                        <h1 class="display-6 fw-bold text-primary mb-3 lh-sm">{{ $producto->nombre }}</h1>
                        
                        <!-- Precio con diseño destacado -->
                        <div class="price-section mb-4 p-3 bg-light rounded-3">
                            <div class="d-flex align-items-center">
                                <span class="display-4 fw-bold text-success me-2">${{ number_format($producto->precio, 2) }}</span>
                                <div class="price-details">
                                    <small class="text-muted d-block">USD</small>
                                    <small class="text-success d-block">
                                        <i class="bi bi-check-circle-fill me-1"></i>
                                        Precio especial
                                    </small>
                                </div>
                            </div>
                        </div>

                        <!-- Descripción -->
                        <div class="mb-4">
                            <h5 class="fw-bold mb-3 text-primary">
                                <i class="bi bi-info-circle me-2"></i>
                                Descripción del curso
                            </h5>
                            <p class="text-muted fs-6 lh-lg">{{ $producto->descripcion }}</p>
                        </div>

                        <!-- Botones de acción-->
                        <div class="action-buttons mb-4">
                            <div class="d-grid gap-2">
                                <button type="button" class="btn btn-success btn-lg shadow-sm" onclick="comprarProducto({{ $producto->id }})">
                                    <i class="bi bi-lightning-charge-fill me-2"></i>
                                    Comprar Ahora
                                </button>
                                <button type="button" class="btn btn-outline-primary btn-lg shadow-sm" onclick="agregarAlCarrito({{ $producto->id }})">
                                    <i class="bi bi-cart-plus me-2"></i>
                                    Añadir al Carrito
                                </button>
                            </div>
                        </div>                        <!-- Características incluidas -->
                        <div class="features-section">
                            <h6 class="fw-bold text-primary mb-3">
                                <i class="bi bi-check2-all me-2"></i>
                                Lo que incluye este curso
                            </h6>
                            <div class="row g-2">
                                <div class="col-6">
                                    <div class="feature-item d-flex align-items-center mb-2">
                                        <i class="bi bi-check-circle text-success me-2"></i>
                                        <small>Acceso de por vida</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="feature-item d-flex align-items-center mb-2">
                                        <i class="bi bi-check-circle text-success me-2"></i>
                                        <small>Certificado digital</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="feature-item d-flex align-items-center mb-2">
                                        <i class="bi bi-check-circle text-success me-2"></i>
                                        <small>Soporte técnico</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="feature-item d-flex align-items-center mb-2">
                                        <i class="bi bi-check-circle text-success me-2"></i>
                                        <small>Acceso móvil</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Información adicional en tarjetas -->
    <div class="row g-4 my-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 info-card">
                <div class="card-body text-center p-4">
                    <div class="icon-wrapper mb-3">
                        <i class="bi bi-shield-check text-success display-4"></i>
                    </div>
                    <h6 class="fw-bold mb-2">Garantía de satisfacción</h6>
                    <p class="text-muted small mb-0">30 días de garantía o te devolvemos tu dinero</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 info-card">
                <div class="card-body text-center p-4">
                    <div class="icon-wrapper mb-3">
                        <i class="bi bi-headset text-primary display-4"></i>
                    </div>
                    <h6 class="fw-bold mb-2">Soporte incluido</h6>
                    <p class="text-muted small mb-0">Atención personalizada durante todo el curso</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 info-card">
                <div class="card-body text-center p-4">
                    <div class="icon-wrapper mb-3">
                        <i class="bi bi-arrow-clockwise text-info display-4"></i>
                    </div>
                    <h6 class="fw-bold mb-2">Actualizaciones gratuitas</h6>
                    <p class="text-muted small mb-0">Contenido actualizado sin costo adicional</p>
                </div>
            </div>
        </div>
    </div>    
    <!-- Productos relacionados-->
    <div class="related-products-section mt-5">
        <div class="d-flex align-items-center mb-4">
            <h3 class="fw-bold text-primary me-3">Cursos relacionados</h3>
            <div class="flex-grow-1">
                <hr class="my-0">
            </div>
        </div>
        
        <div class="row g-4">
            @php
                $productosRelacionados = App\Models\Producto::where('id_categoria', $producto->id_categoria)
                    ->where('id', '!=', $producto->id)
                    ->take(3)
                    ->get();
            @endphp
            
            @if($productosRelacionados->count() > 0)
                @foreach($productosRelacionados as $relacionado)
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100 shadow-sm border-0 product-card">
                            <div class="position-relative overflow-hidden">
                                <a href="{{ route('producto.detalle', $relacionado->id) }}" class="text-decoration-none">
                                    <img src="{{ $relacionado->image_path ? asset('img/productos/' . $relacionado->image_path) : 'https://via.placeholder.com/400x250' }}" 
                                         class="card-img-top related-product-image" 
                                         alt="{{ $relacionado->nombre }}">
                                </a>
                                <div class="product-overlay">
                                    <div class="d-flex justify-content-center align-items-center h-100">
                                        <a href="{{ route('producto.detalle', $relacionado->id) }}" class="btn btn-light btn-sm rounded-pill">
                                            <i class="bi bi-eye me-1"></i>
                                            Ver detalles
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-3">
                                <a href="{{ route('producto.detalle', $relacionado->id) }}" class="text-decoration-none text-dark">
                                    <h6 class="card-title fw-bold mb-2">{{ $relacionado->nombre }}</h6>
                                </a>
                                <p class="card-text text-muted small mb-3">{{ Str::limit($relacionado->descripcion, 80) }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="badge bg-success rounded-pill px-3 py-2">
                                        <i class="bi bi-currency-dollar me-1"></i>
                                        {{ $relacionado->precio }}
                                    </span>
                                    <a href="{{ route('producto.detalle', $relacionado->id) }}" class="btn btn-outline-primary btn-sm">
                                        Ver más
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-12">
                    <div class="card border-0 bg-light">
                        <div class="card-body text-center py-5">
                            <i class="bi bi-search text-muted display-1 mb-3"></i>
                            <h5 class="text-muted">No hay cursos relacionados disponibles</h5>
                            <p class="text-muted">Explora nuestro catálogo completo para encontrar más cursos</p>
                            <a href="{{ url('/') }}" class="btn btn-primary">
                                <i class="bi bi-arrow-left me-2"></i>
                                Explorar catálogo
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- JavaScript para funcionalidad de botones -->
<script>
function comprarProducto(productoId) {
    // Mostrar confirmación estilizada
    if (confirm('¿Deseas proceder con la compra de este curso?\n\nSerás redirigido al proceso de pago.')) {
        // Por el momento, mostrar un mensaje
        alert('Funcionalidad de compra será implementada próximamente.\nProducto ID: ' + productoId);
        
        // Aquí se implementará la lógica de compra
        console.log('Comprando producto con ID:', productoId);
    }
}

function agregarAlCarrito(productoId) {
    @if(session('usuario_auth'))
        // Usar la función global del layout
        window.agregarAlCarrito(productoId, 1);
    @else
        alert('Debes iniciar sesión para agregar productos al carrito');
        window.location.href = '{{ route("login") }}';
    @endif
}
</script>
@endsection

@push('styles')
<link href="{{ asset('css/producto-detalle.css') }}" rel="stylesheet">
@endpush

@push('scripts')
<script src="{{ asset('js/producto-detalle.js') }}"></script>
@endpush
