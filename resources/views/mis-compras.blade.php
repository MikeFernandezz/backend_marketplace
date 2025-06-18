@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="bi bi-bag-check me-2"></i>Mis Compras</h2>
                <a href="/" class="btn btn-outline-primary">
                    <i class="bi bi-house me-2"></i>Volver al Inicio
                </a>
            </div>

            @if($ventas->count() > 0)
                <div class="row">
                    @foreach($ventas as $venta)
                        <div class="col-12 mb-4">
                            <div class="card shadow-sm">
                                <div class="card-header bg-light">
                                    <div class="row align-items-center">
                                        <div class="col-md-3">
                                            <strong>Orden #{{ str_pad($venta->id_venta, 6, '0', STR_PAD_LEFT) }}</strong>
                                        </div>
                                        <div class="col-md-3">
                                            <small class="text-muted">
                                                <i class="bi bi-calendar me-1"></i>
                                                @php
                                                    try {
                                                        echo \Carbon\Carbon::parse($venta->fecha_venta)->format('d/m/Y H:i');
                                                    } catch (Exception $e) {
                                                        echo date('d/m/Y H:i', strtotime($venta->fecha_venta));
                                                    }
                                                @endphp
                                            </small>
                                        </div>
                                        <div class="col-md-3">
                                            <span class="badge bg-success">
                                                <i class="bi bi-currency-dollar me-1"></i>
                                                ${{ number_format($venta->total, 2) }}
                                            </span>
                                        </div>
                                        <div class="col-md-3 text-end">
                                            <a href="{{ route('compra.detalle', $venta->id_venta) }}" 
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye me-1"></i>Ver Detalle
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        @foreach($venta->ventaProductos->take(3) as $ventaProducto)
                                            <div class="col-md-4 mb-3">                                                <div class="d-flex align-items-center">                                                    <img src="{{ $ventaProducto->producto->image_path ? asset('img/productos/' . $ventaProducto->producto->image_path) : asset('img/webres/placeholder.jpg') }}" 
                                                         alt="{{ $ventaProducto->producto->nombre }}" 
                                                         class="rounded me-3" 
                                                         style="width: 60px; height: 60px; object-fit: cover;"
                                                         onerror="this.src='{{ asset('img/webres/placeholder.jpg') }}'">                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-1">{{ $ventaProducto->producto->nombre }}</h6>
                                                        <small class="text-muted">
                                                            Curso digital - ${{ number_format($ventaProducto->precio_unitario, 2) }}
                                                        </small>
                                                        <br>
                                                        <span class="badge bg-secondary small">
                                                            {{ $ventaProducto->producto->categoria->nombre_categoria ?? 'Sin categoría' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        
                                        @if($venta->ventaProductos->count() > 3)
                                            <div class="col-md-12 text-center">
                                                <small class="text-muted">
                                                    y {{ $venta->ventaProductos->count() - 3 }} producto(s) más...
                                                </small>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">
                                            <i class="bi bi-box me-1"></i>
                                            {{ $venta->ventaProductos->count() }} producto(s)
                                        </small>
                                        <div>
                                            <a href="{{ route('compra.detalle', $venta->id_venta) }}" 
                                               class="btn btn-primary btn-sm">
                                                <i class="bi bi-receipt me-1"></i>Ver Recibo
                                            </a>
                                            <button class="btn btn-outline-secondary btn-sm ms-2" 
                                                    onclick="window.print()">
                                                <i class="bi bi-printer me-1"></i>Imprimir
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Paginación -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $ventas->links() }}
                </div>
            @else
                <!-- Estado vacío -->
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="bi bi-bag-x" style="font-size: 4rem; color: #6c757d;"></i>
                    </div>
                    <h4 class="text-muted mb-3">No tienes compras realizadas</h4>
                    <p class="text-muted mb-4">
                        Explora nuestro catálogo y encuentra los mejores cursos para ti
                    </p>
                    <a href="/" class="btn btn-primary btn-lg">
                        <i class="bi bi-search me-2"></i>Explorar Productos
                    </a>                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="{{ asset('css/mis-compras.css') }}" rel="stylesheet">
@endpush
