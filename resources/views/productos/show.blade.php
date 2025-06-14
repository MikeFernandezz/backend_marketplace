@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detalle del Producto</h1>
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">{{ $producto->nombre }}</h5>
            <p class="card-text"><strong>Descripción:</strong> {{ $producto->descripcion }}</p>
            <p class="card-text"><strong>Precio:</strong> ${{ $producto->precio }}</p>
            <p class="card-text"><strong>Categoría:</strong> {{ $producto->categoria->nombre_categoria ?? '' }}</p>
            <p class="card-text"><strong>Archivo:</strong> <a href="{{ asset('storage/' . $producto->archivo) }}" target="_blank">Ver archivo</a></p>
            <a href="{{ route('admin.productos.edit', $producto->id) }}" class="btn btn-warning">Editar</a>
            <a href="{{ route('admin.productos.index') }}" class="btn btn-secondary">Volver</a>
            <a href="{{ route('admin.panel') }}" class="btn btn-secondary mt-3">Volver al Panel de Administrador</a>
        </div>
    </div>
</div>
@endsection
