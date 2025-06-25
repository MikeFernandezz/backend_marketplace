@extends('layouts.app')

@section('content')
<div class="container">    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Consulta de Ventas</h1>
        <div class="d-flex gap-2">
            @if($ventas->count() > 0)
                <a href="{{ route('admin.ventas.export.csv', request()->query()) }}" 
                   class="btn btn-success">
                    <i class="fas fa-download"></i> Exportar CSV
                </a>
            @endif
            <a href="{{ route('admin.panel') }}" class="btn btn-secondary">Volver al Panel de Administrador</a>
        </div>
    </div>@if($ventas->count() > 0)
        <!-- Filtros -->
        <div class="card mb-3">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.ventas.index') }}" class="row g-3">
                    <div class="col-md-3">
                        <label for="fecha_desde" class="form-label">Desde:</label>
                        <input type="date" class="form-control" id="fecha_desde" name="fecha_desde" 
                               value="{{ request('fecha_desde') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="fecha_hasta" class="form-label">Hasta:</label>
                        <input type="date" class="form-control" id="fecha_hasta" name="fecha_hasta" 
                               value="{{ request('fecha_hasta') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="usuario" class="form-label">Usuario:</label>
                        <input type="text" class="form-control" id="usuario" name="usuario" 
                               placeholder="Buscar por nombre o email" value="{{ request('usuario') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Filtrar</button>
                            <a href="{{ route('admin.ventas.index') }}" class="btn btn-outline-secondary">Limpiar</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Historial de Ventas</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>ID Venta</th>
                                <th>Usuario</th>
                                <th>Email Usuario</th>
                                <th>Fecha de Venta</th>
                                <th>Total</th>
                                <th>Productos</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ventas as $venta)
                                <tr>
                                    <td>
                                        <span class="badge bg-primary">#{{ $venta->id_venta }}</span>
                                    </td>
                                    <td>{{ $venta->usuario ? $venta->usuario->nombre . ' ' . $venta->usuario->apellidos : 'Usuario no encontrado' }}</td>
                                    <td>{{ $venta->usuario->correo ?? 'N/A' }}</td>
                                    <td>
                                        <small class="text-muted">
                                            {{ $venta->fecha_venta ? $venta->fecha_venta->format('d/m/Y H:i') : 'N/A' }}
                                        </small>
                                    </td>
                                    <td>
                                        <strong class="text-success">${{ number_format($venta->total, 2) }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $venta->ventaProductos->count() }} producto(s)</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.ventas.show', $venta->id_venta) }}" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i> Ver Detalle
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Resumen de estadísticas -->
        <div class="row mt-4">
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title text-primary">{{ $ventas->count() }}</h5>
                        <p class="card-text">Total de Ventas</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title text-success">${{ number_format($ventas->sum('total'), 2) }}</h5>
                        <p class="card-text">Ingresos Totales</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title text-info">{{ $ventas->avg('total') ? number_format($ventas->avg('total'), 2) : '0.00' }}</h5>
                        <p class="card-text">Promedio por Venta</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title text-warning">{{ $ventas->sum(function($venta) { return $venta->ventaProductos->sum('cantidad'); }) }}</h5>
                        <p class="card-text">Productos Vendidos</p>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-info text-center">
            <h4>No hay ventas registradas</h4>
            <p>Aún no se han realizado ventas en el sistema.</p>
        </div>    @endif
</div>
@endsection

@push('styles')
<link href="{{ asset('css/ventas/ventas-shared.css') }}" rel="stylesheet">
@endpush
