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
    // Por el momento, mostrar un mensaje
    const mensaje = 'Curso añadido al carrito exitosamente.\n\n¡Continúa explorando nuestro catálogo!';
    alert(mensaje);
    
    // Aquí se implementará la lógica del carrito
    console.log('Añadiendo al carrito producto con ID:', productoId);
    
    // Feedback visual mejorado
    const boton = event.target;
    const textoOriginal = boton.innerHTML;
    boton.innerHTML = '<i class="bi bi-check-circle-fill me-2"></i>¡Añadido!';
    boton.classList.remove('btn-outline-primary');
    boton.classList.add('btn-success');
    boton.disabled = true;
    
    setTimeout(() => {
        boton.innerHTML = textoOriginal;
        boton.classList.remove('btn-success');
        boton.classList.add('btn-outline-primary');
        boton.disabled = false;
    }, 3000);
}

function expandImage() {
    const img = document.querySelector('.product-main-image');
    const modal = document.createElement('div');
    modal.className = 'modal fade';
    modal.innerHTML = `
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <img src="${img.src}" class="img-fluid w-100" alt="${img.alt}">
                </div>
            </div>
        </div>
    `;
    document.body.appendChild(modal);
    const bootstrapModal = new bootstrap.Modal(modal);
    bootstrapModal.show();
    
    modal.addEventListener('hidden.bs.modal', () => {
        document.body.removeChild(modal);
    });
}
</script>

<!-- Estilos CSS personalizados alineados con el tema del proyecto -->
<style>
/* Estilo principal del producto */
.product-main-image {
    height: 450px;
    object-fit: cover;
    transition: transform 0.4s ease;
    border-radius: 0.5rem;
}

.product-image-container:hover .product-main-image {
    transform: scale(1.02);
}

.product-image-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(91, 127, 214, 0.8);
    opacity: 0;
    transition: opacity 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 0.5rem;
}

.product-image-container:hover .product-image-overlay {
    opacity: 1;
}

/* Sección de precio */
.price-section {
    background: linear-gradient(135deg, rgba(91, 127, 214, 0.1) 0%, rgba(72, 201, 176, 0.1) 100%);
    border: 1px solid rgba(91, 127, 214, 0.2);
}

/* Botones de acción */
.action-buttons .btn {
    border-radius: 0.75rem;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    letter-spacing: 0.025em;
    transition: all 0.3s ease;
}

.action-buttons .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.action-buttons .btn-success {
    background: linear-gradient(135deg, #58D68D 0%, #48C9B0 100%);
    border: none;
}

.action-buttons .btn-success:hover {
    background: linear-gradient(135deg, #48C9B0 0%, #58D68D 100%);
    box-shadow: 0 8px 25px rgba(88, 214, 141, 0.4);
}

.action-buttons .btn-outline-primary {
    border: 2px solid var(--logo-primary);
    color: var(--logo-primary);
    background: transparent;
}

.action-buttons .btn-outline-primary:hover {
    background: var(--logo-primary);
    border-color: var(--logo-primary);
    color: white;
}

/* Tarjetas de información */
.info-card {
    transition: all 0.3s ease;
    border-radius: 1rem;
    overflow: hidden;
}

.info-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.info-card .icon-wrapper {
    background: linear-gradient(135deg, rgba(91, 127, 214, 0.1) 0%, rgba(72, 201, 176, 0.1) 100%);
    width: 80px;
    height: 80px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
}

/* Características del curso */
.features-section {
    background: linear-gradient(135deg, rgba(248, 249, 250, 0.8) 0%, rgba(91, 127, 214, 0.05) 100%);
    border-radius: 1rem;
    padding: 1.5rem;
    border: 1px solid rgba(91, 127, 214, 0.1);
}

.feature-item {
    transition: transform 0.2s ease;
}

.feature-item:hover {
    transform: translateX(5px);
}

/* Productos relacionados */
.related-products-section h3 {
    position: relative;
}

.product-card {
    transition: all 0.3s ease;
    border-radius: 1rem;
    overflow: hidden;
}

.product-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.1);
}

.related-product-image {
    height: 200px;
    object-fit: cover;
    transition: transform 0.4s ease;
}

.product-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(91, 127, 214, 0.8);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.product-card:hover .product-overlay {
    opacity: 1;
}

.product-card:hover .related-product-image {
    transform: scale(1.1);
}

/* Breadcrumb mejorado */
.breadcrumb {
    background: linear-gradient(135deg, rgba(248, 249, 250, 0.9) 0%, rgba(91, 127, 214, 0.1) 100%);
    border: 1px solid rgba(91, 127, 214, 0.15);
    backdrop-filter: blur(10px);
}

.breadcrumb-item a {
    color: var(--logo-primary);
    transition: color 0.3s ease;
}

.breadcrumb-item a:hover {
    color: var(--logo-secondary);
    text-decoration: none;
}

/* Animaciones de entrada */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.product-info, .product-image-container {
    animation: fadeInUp 0.6s ease-out;
}

.info-card {
    animation: fadeInUp 0.6s ease-out;
}

.info-card:nth-child(2) {
    animation-delay: 0.1s;
}

.info-card:nth-child(3) {
    animation-delay: 0.2s;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .product-main-image {
        height: 300px;
    }
    
    .action-buttons .btn {
        padding: 0.75rem;
        font-size: 0.9rem;
    }
    
    .display-6 {
        font-size: 1.75rem;
    }
    
    .display-4 {
        font-size: 2rem;
    }
}
</style>
@endsection
