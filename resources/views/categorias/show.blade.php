@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detalle de la Categoría</h1>
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">{{ $categoria->nombre_categoria }}</h5>
            <a href="{{ route('admin.categorias.edit', $categoria->id_categoria) }}" class="btn btn-warning">Editar</a>
            <a href="{{ route('admin.categorias.index') }}" class="btn btn-secondary">Volver</a>
            <a href="{{ route('admin.panel') }}" class="btn btn-secondary mt-3">Volver al Panel de Administrador</a>
        </div>
    </div>
</div>
@endsection
