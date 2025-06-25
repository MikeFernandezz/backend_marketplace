@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Detalle de Venta #{{ $venta->id_venta }}</h1>
        <div>
            <a href="{{ route('admin.ventas.index') }}" class="btn btn-secondary">Volver a Ventas</a>
            <a href="{{ route('admin.panel') }}" class="btn btn-outline-secondary ms-2">Panel de Administrador</a>
        </div>
    </div>

    <div class="row">
        <!-- Información de la Venta -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Información de la Venta</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>ID Venta:</strong></td>
                            <td><span class="badge bg-primary">#{{ $venta->id_venta }}</span></td>
                        </tr>
                        <tr>
                            <td><strong>Fecha:</strong></td>
                            <td>{{ $venta->fecha_venta ? $venta->fecha_venta->format('d/m/Y H:i:s') : 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Total:</strong></td>
                            <td><span class="fs-5 text-success fw-bold">${{ number_format($venta->total, 2) }}</span></td>
                        </tr>
                        <tr>
                            <td><strong>Productos:</strong></td>
                            <td><span class="badge bg-info">{{ $venta->ventaProductos->count() }} producto(s)</span></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Información del Usuario -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Información del Comprador</h5>
                </div>
                <div class="card-body">
                    @if($venta->usuario)
                        <div class="row">                            <div class="col-md-6">
                                <p><strong>Nombre:</strong> {{ $venta->usuario->nombre }} {{ $venta->usuario->apellidos }}</p>
                                <p><strong>Email:</strong> {{ $venta->usuario->correo }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Rol:</strong> 
                                    <span class="badge {{ $venta->usuario->rol === 'admin' ? 'bg-danger' : 'bg-secondary' }}">
                                        {{ ucfirst($venta->usuario->rol) }}
                                    </span>
                                </p>
                                <p><strong>ID Usuario:</strong> {{ $venta->usuario->id_usuario }}</p>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            Usuario no encontrado (ID: {{ $venta->id_usuario }})
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Lista de Productos -->
    <div class="card mt-4">
        <div class="card-header">
            <h5 class="mb-0">Productos Vendidos</h5>
        </div>
        <div class="card-body">
            @if($venta->ventaProductos->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>Producto</th>
                                <th>Categoría</th>
                                <th>Precio Unitario</th>
                                <th>Cantidad</th>
                                <th>Subtotal</th>
                                <th>Imagen</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($venta->ventaProductos as $ventaProducto)
                                <tr>
                                    <td>
                                        <strong>{{ $ventaProducto->producto->nombre ?? 'Producto no encontrado' }}</strong>
                                        @if($ventaProducto->producto && $ventaProducto->producto->descripcion)
                                            <br><small class="text-muted">{{ Str::limit($ventaProducto->producto->descripcion, 50) }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($ventaProducto->producto && $ventaProducto->producto->categoria)
                                            <span class="badge bg-secondary">{{ $ventaProducto->producto->categoria->nombre_categoria }}</span>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td>${{ number_format($ventaProducto->precio_unitario, 2) }}</td>
                                    <td>
                                        <span class="badge bg-primary">{{ $ventaProducto->cantidad }}</span>
                                    </td>
                                    <td>
                                        <strong class="text-success">${{ number_format($ventaProducto->precio_unitario * $ventaProducto->cantidad, 2) }}</strong>
                                    </td>
                                    <td>
                                        @if($ventaProducto->producto && $ventaProducto->producto->image_path)
                                            <img src="{{ asset('img/productos/' . $ventaProducto->producto->image_path) }}" 
                                                 alt="Imagen del producto" 
                                                 style="max-width: 60px; max-height: 60px; object-fit: cover;"
                                                 class="rounded">
                                        @else
                                            <span class="text-muted">Sin imagen</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <th colspan="4" class="text-end">Total de la Venta:</th>
                                <th class="text-success fs-5">${{ number_format($venta->total, 2) }}</th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @else
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    No se encontraron productos para esta venta.
                </div>
            @endif
        </div>
    </div>

    <!-- Información adicional si existe archivo de productos -->
    @if($venta->ventaProductos->where('producto', '!=', null)->count() > 0)
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0">Archivos de Productos Digitales</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach($venta->ventaProductos->where('producto', '!=', null) as $ventaProducto)
                        @if($ventaProducto->producto && $ventaProducto->producto->archivo)
                            <div class="col-md-6 mb-3">
                                <div class="card border-info">
                                    <div class="card-body">
                                        <h6 class="card-title">{{ $ventaProducto->producto->nombre }}</h6>
                                        <p class="card-text small text-muted">Archivo digital incluido</p>
                                        <a href="{{ asset('storage/' . $ventaProducto->producto->archivo) }}" 
                                           target="_blank" 
                                           class="btn btn-sm btn-outline-info">
                                            <i class="fas fa-download"></i> Ver Archivo
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>    @endif
</div>
@endsection

@push('styles')
<link href="{{ asset('css/ventas/venta-detalle.css') }}" rel="stylesheet">
@endpush
