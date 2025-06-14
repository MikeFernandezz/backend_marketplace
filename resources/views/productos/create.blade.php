@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crear Producto</h1>
    <form method="POST" action="{{ route('admin.productos.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group mb-3">
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" class="form-control" required>
        </div>
        <div class="form-group mb-3">
            <label for="descripcion">Descripción</label>
            <textarea id="descripcion" name="descripcion" class="form-control" required></textarea>
        </div>
        <div class="form-group mb-3">
            <label for="precio">Precio</label>
            <input type="number" id="precio" name="precio" class="form-control" step="0.01" required>
        </div>
        <div class="form-group mb-3">
            <label for="archivo">Archivo</label>
            <input type="text" id="archivo" name="archivo" class="form-control">
        </div>
        <div class="form-group mb-3">
            <label for="id_categoria">Categoría</label>
            <select id="id_categoria" name="id_categoria" class="form-control" required>
                <option value="">Seleccione una categoría</option>
                @foreach (\App\Models\Categoria::all() as $categoria)
                    <option value="{{ $categoria->id_categoria }}">{{ $categoria->nombre_categoria }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="{{ route('admin.productos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
    <a href="{{ route('admin.panel') }}" class="btn btn-secondary mt-3">Volver al Panel de Administrador</a>
</div>
@endsection
