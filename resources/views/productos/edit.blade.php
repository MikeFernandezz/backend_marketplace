@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Producto</h1>
    <form method="POST" action="{{ route('admin.productos.update', $producto->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group mb-3">
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" class="form-control" value="{{ $producto->nombre }}" required>
        </div>
        <div class="form-group mb-3">
            <label for="descripcion">Descripción</label>
            <textarea id="descripcion" name="descripcion" class="form-control" required>{{ $producto->descripcion }}</textarea>
        </div>
        <div class="form-group mb-3">
            <label for="precio">Precio</label>
            <input type="number" id="precio" name="precio" class="form-control" step="0.01" value="{{ $producto->precio }}" required>
        </div>
        <div class="form-group mb-3">
            <label for="archivo">Archivo</label>
            <input type="text" id="archivo" name="archivo" class="form-control" value="{{ $producto->archivo }}">
        </div>
        <div class="form-group mb-3">
            <label for="id_categoria">Categoría</label>
            <select id="id_categoria" name="id_categoria" class="form-control" required>
                <option value="">Seleccione una categoría</option>
                @foreach (\App\Models\Categoria::all() as $categoria)
                    <option value="{{ $categoria->id_categoria }}" {{ $producto->id_categoria == $categoria->id_categoria ? 'selected' : '' }}>{{ $categoria->nombre_categoria }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group mb-3">
            <label for="image">Imagen del producto</label>
            <input type="file" id="image" name="image" class="form-control">
            @if($producto->image_path)
                <img src="{{ asset('img/productos/' . $producto->image_path) }}" alt="Imagen actual" class="img-thumbnail mt-2" style="max-width: 150px;">
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('admin.productos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
    <a href="{{ route('admin.panel') }}" class="btn btn-secondary mt-3">Volver al Panel de Administrador</a>
</div>
@endsection
