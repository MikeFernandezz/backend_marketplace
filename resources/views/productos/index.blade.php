@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Lista de Productos</h1>
        <div>
            <a href="{{ route('admin.productos.create') }}" class="btn btn-success">Crear Producto</a>
            <a href="{{ route('admin.panel') }}" class="btn btn-secondary ms-2">Volver al Panel de Administrador</a>
        </div>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Archivo</th>
                <th>Categoría</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($productos as $producto)
                <tr>
                    <td>{{ $producto->id }}</td>
                    <td>{{ $producto->nombre }}</td>
                    <td>{{ $producto->descripcion }}</td>
                    <td>{{ $producto->precio }}</td>
                    <td><a href="{{ asset('storage/' . $producto->archivo) }}" target="_blank">Ver archivo</a></td>
                    <td>{{ $producto->categoria->nombre_categoria ?? '' }}</td>
                    <td>
                        <a href="{{ route('admin.productos.show', $producto->id) }}" class="btn btn-info btn-sm">Ver</a>
                        <a href="{{ route('admin.productos.edit', $producto->id) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form method="POST" action="{{ route('admin.productos.destroy', $producto->id) }}" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
