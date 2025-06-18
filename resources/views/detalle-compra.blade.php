@extends('layouts.app')

@section('content')
<div                            <div class="d-flex align-items-center py-3 border-bottom">                                <img src="{{ $ventaProducto->producto->image_path ? asset('img/productos/' . $ventaProducto->producto->image_path) : asset('img/webres/placeholder.jpg') }}" 
                                     alt="{{ $ventaProducto->producto->nombre }}" 
                                     class="me-3 rounded" 
                                     style="width: 80px; height: 80px; object-fit: cover;" 
                                     onerror="this.src='{{ asset('img/webres/placeholder.jpg') }}'">s="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Mensaje de éxito -->
            <div class="alert alert-success shadow-sm mb-4 text-center">
                <i class="bi bi-check-circle-fill" style="font-size: 3rem; color: #198754;"></i>
                <h4 class="mt-3 mb-2">¡Compra Realizada Exitosamente!</h4>
                <p class="mb-0">Tu pedido ha sido procesado correctamente. Recibirás un correo de confirmación pronto.</p>
            </div>

            <!-- Detalle de la compra -->
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0"><i class="bi bi-receipt me-2"></i>Detalle de Compra</h4>
                        <span class="badge bg-success">Pagado</span>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Información de la venta -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted">Número de Orden:</h6>
                            <p class="mb-2"><strong>#{{ str_pad($venta->id_venta, 6, '0', STR_PAD_LEFT) }}</strong></p>
                            
                            <h6 class="text-muted">Fecha de Compra:</h6>
                            <p class="mb-2">
                                @php
                                    try {
                                        echo \Carbon\Carbon::parse($venta->fecha_venta)->format('d/m/Y H:i');
                                    } catch (Exception $e) {
                                        echo date('d/m/Y H:i', strtotime($venta->fecha_venta));
                                    }
                                @endphp
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Cliente:</h6>
                            <p class="mb-2">{{ $venta->usuario->nombre }}</p>
                            
                            <h6 class="text-muted">Correo:</h6>
                            <p class="mb-2">{{ $venta->usuario->correo }}</p>
                        </div>
                    </div>

                    <!-- Productos comprados -->
                    <div class="mb-4">
                        <h5 class="border-bottom pb-2">Productos Comprados</h5>
                        @foreach($venta->ventaProductos as $ventaProducto)
                            <div class="d-flex align-items-center py-3 border-bottom">                                <img src="{{ $ventaProducto->producto->image_path ? asset('img/productos/' . $ventaProducto->producto->image_path) : asset('img/webres/placeholder.svg') }}" 
                                     alt="{{ $ventaProducto->producto->nombre }}" 
                                     class="rounded me-3" 
                                     style="width: 80px; height: 80px; object-fit: cover;"
                                     onerror="this.src='{{ asset('img/webres/placeholder.svg') }}'">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">{{ $ventaProducto->producto->nombre }}</h6>
                                    <p class="text-muted small mb-1">{{ $ventaProducto->producto->descripcion }}</p>
                                    <span class="badge bg-secondary">{{ $ventaProducto->producto->categoria->nombre_categoria ?? 'Sin categoría' }}</span>
                                </div>                                <div class="text-end">
                                    <div class="text-muted small">
                                        Curso digital
                                    </div>
                                    <strong>${{ number_format($ventaProducto->precio_unitario, 2) }}</strong>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Total -->
                    <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                        <h5 class="mb-0">Total Pagado:</h5>
                        <h4 class="mb-0 text-success">${{ number_format($venta->total, 2) }}</h4>
                    </div>

                    <!-- Acciones -->
                    <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                        <a href="/" class="btn btn-outline-primary">
                            <i class="bi bi-house me-2"></i>Volver al Inicio
                        </a>
                        <div>
                            <button class="btn btn-outline-secondary me-2" onclick="window.print()">
                                <i class="bi bi-printer me-2"></i>Imprimir Recibo
                            </button>
                            <button class="btn btn-primary" onclick="descargarRecibo()">
                                <i class="bi bi-download me-2"></i>Descargar PDF
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información adicional -->
            <div class="card mt-4 shadow-sm">
                <div class="card-body">
                    <h6 class="card-title"><i class="bi bi-info-circle me-2"></i>Información Importante</h6>
                    <ul class="mb-0">
                        <li>Recibirás un correo de confirmación con los detalles de tu compra.</li>
                        <li>Puedes acceder a tus cursos desde la sección "Mis Compras" en tu perfil.</li>
                        <li>Si tienes alguna pregunta, no dudes en contactar a nuestro equipo de soporte.</li>
                        <li>Los cursos digitales están disponibles inmediatamente después de la compra.</li>                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="{{ asset('css/detalle-compra.css') }}" rel="stylesheet">
@endpush

@push('scripts')
<script src="{{ asset('js/detalle-compra.js') }}"></script>
@endpush
