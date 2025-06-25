@extends('layouts.app')

@section('content')
<div class="container-fluid">    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2">Gestión de Usuarios</h1>
        <div class="d-flex gap-2">
            @if($usuarios->count() > 0)
                <a href="{{ route('admin.usuarios.export.csv', request()->query()) }}" 
                   class="btn btn-success">
                    <i class="fas fa-download"></i> Exportar CSV
                </a>
            @endif
            <a href="{{ route('admin.panel') }}" class="btn btn-secondary">Volver al Panel de Administrador</a>
        </div>
    </div>

    <!-- Mensajes de éxito o error -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Filtros y búsqueda -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.usuarios.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label for="buscar" class="form-label">Buscar Usuario:</label>
                    <input type="text" class="form-control" id="buscar" name="buscar" 
                           placeholder="Nombre, apellidos o email..." 
                           value="{{ request('buscar') }}">
                </div>
                <div class="col-md-3">
                    <label for="rol" class="form-label">Filtrar por rol:</label>
                    <select name="rol" id="rol" class="form-select">
                        <option value="">Todos los roles</option>
                        <option value="admin" {{ request('rol') == 'admin' ? 'selected' : '' }}>Administrador</option>
                        <option value="cliente" {{ request('rol') == 'cliente' ? 'selected' : '' }}>Cliente</option>
                    </select>
                </div>
                <div class="col-md-5">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Buscar
                        </button>
                        <a href="{{ route('admin.usuarios.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i> Limpiar
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Estadísticas -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title text-primary">{{ $usuarios->count() }}</h5>
                    <p class="card-text">Total Mostrados</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title text-success">{{ $usuarios->where('rol', 'admin')->count() }}</h5>
                    <p class="card-text">Administradores</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title text-info">{{ $usuarios->where('rol', 'cliente')->count() }}</h5>
                    <p class="card-text">Clientes</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title text-warning">{{ \App\Models\Usuario::count() }}</h5>
                    <p class="card-text">Total Sistema</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de usuarios -->
    @if($usuarios->count() > 0)
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Lista de Usuarios</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Nombre Completo</th>
                                <th>Correo Electrónico</th>
                                <th>Rol</th>
                                <th>Gestión Admin</th>
                                <th width="100">Eliminar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($usuarios as $usuario)
                            <tr>
                                <td>
                                    <span class="badge bg-secondary">#{{ $usuario->id_usuario }}</span>
                                </td>
                                <td>
                                    <strong>{{ $usuario->nombre }} {{ $usuario->apellidos }}</strong>
                                </td>
                                <td>{{ $usuario->correo }}</td>
                                <td>
                                    @if($usuario->rol === 'admin')
                                        <span class="badge bg-danger">
                                            <i class="fas fa-crown"></i> Administrador
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            <i class="fas fa-user"></i> Cliente
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($usuario->rol !== 'admin')
                                        <!-- Hacer administrador -->
                                        <form action="{{ route('admin.usuarios.makeAdmin', $usuario->id_usuario) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')                                            <button type="submit" class="btn btn-sm btn-success"
                                                    onclick="return confirm('¿Confirmas otorgar permisos de administrador a {{ $usuario->nombre }} {{ $usuario->apellidos }}?')">
                                                <i class="fas fa-user-shield"></i> Hacer Admin
                                            </button>
                                        </form>
                                    @else
                                        <!-- Remover administrador -->
                                        <form action="{{ route('admin.usuarios.removeAdmin', $usuario->id_usuario) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')                                            <button type="submit" class="btn btn-sm btn-warning"
                                                    onclick="return confirm('¿Confirmas remover los permisos de administrador de {{ $usuario->nombre }} {{ $usuario->apellidos }}?')">
                                                <i class="fas fa-user-minus"></i> Remover Admin
                                            </button>
                                        </form>
                                    @endif
                                </td>
                                <td>
                                    <!-- Eliminar usuario -->
                                    <form action="{{ route('admin.usuarios.destroy', $usuario->id_usuario) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')                                        <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('¿Estás seguro de que deseas eliminar permanentemente a {{ $usuario->nombre }} {{ $usuario->apellidos }}? Esta acción no se puede deshacer.')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-info text-center">
            <h4><i class="fas fa-search"></i> Sin resultados</h4>
            <p>No se encontraron usuarios que coincidan con los criterios de búsqueda.</p>
            <a href="{{ route('admin.usuarios.index') }}" class="btn btn-primary">Ver todos los usuarios</a>
        </div>    @endif
</div>
@endsection

@push('styles')
<link href="{{ asset('css/admin/usuarios.css') }}" rel="stylesheet">
@endpush
