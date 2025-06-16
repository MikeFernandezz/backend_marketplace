@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Crear Categoría</h1>
    <form method="POST" action="{{ route('admin.categorias.store') }}">
        @csrf
        <div class="form-group mb-3">
            <label for="nombre_categoria">Nombre de la Categoría</label>
            <input type="text" id="nombre_categoria" name="nombre_categoria" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="{{ route('admin.categorias.index') }}" class="btn btn-secondary">Cancelar</a>
        <a href="{{ route('admin.panel') }}" class="btn btn-secondary">Volver al Panel de Administrador</a>
    </form>
</div>
@endsection
