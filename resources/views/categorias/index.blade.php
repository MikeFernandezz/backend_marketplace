@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Lista de Categorías</h1>
        <div>
            <a href="{{ route('admin.categorias.create') }}" class="btn btn-success">Crear Categoría</a>
            <a href="{{ route('admin.panel') }}" class="btn btn-secondary ms-2">Volver al Panel de Administrador</a>
        </div>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categorias as $categoria)
                <tr>
                    <td>{{ $categoria->id_categoria }}</td>
                    <td>{{ $categoria->nombre_categoria }}</td>
                    <td>
                        <a href="{{ route('admin.categorias.show', $categoria->id_categoria) }}" class="btn btn-info btn-sm">Ver</a>
                        <a href="{{ route('admin.categorias.edit', $categoria->id_categoria) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form method="POST" action="{{ route('admin.categorias.destroy', $categoria->id_categoria) }}" style="display:inline;">
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
