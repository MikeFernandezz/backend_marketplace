@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="h2 mb-4">Gestión de Usuarios</h1>
    <form method="GET" action="{{ route('admin.usuarios.index') }}" class="mb-3">
        <div class="row g-2 align-items-end">
            <div class="col-auto">
                <label for="rol" class="form-label">Filtrar por rol:</label>
                <select name="rol" id="rol" class="form-select">
                    <option value="">Todos</option>
                    <option value="admin" {{ request('rol') == 'admin' ? 'selected' : '' }}>Administrador</option>
                    <option value="cliente" {{ request('rol') == 'cliente' ? 'selected' : '' }}>Cliente</option>
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-secondary">Filtrar</button>
            </div>
        </div>
    </form>
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($usuarios as $usuario)
            <tr>
                <td>{{ $usuario->id_usuario }}</td>
                <td>{{ $usuario->nombre }} {{ $usuario->apellidos }}</td>
                <td>{{ $usuario->correo }}</td>
                <td>{{ $usuario->rol }}</td>
                <td>
                    @if($usuario->rol !== 'admin')
                    <form action="{{ route('admin.usuarios.makeAdmin', $usuario->id_usuario) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-sm btn-success">Hacer Admin</button>
                    </form>
                    @endif
                    <form action="{{ route('admin.usuarios.destroy', $usuario->id_usuario) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Seguro que deseas dar de baja este usuario?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Dar de baja</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
