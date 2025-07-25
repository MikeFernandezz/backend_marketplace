@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
            <div class="position-sticky pt-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.productos.*') ? 'active' : '' }}" 
                           href="{{ route('admin.productos.index') }}">
                            <span data-feather="box"></span>
                            Productos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.categorias.*') ? 'active' : '' }}" 
                           href="{{ route('admin.categorias.index') }}">
                            <span data-feather="layers"></span>
                            Categorías
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.ventas.*') ? 'active' : '' }}" 
                           href="{{ route('admin.ventas.index') }}">
                            <span data-feather="bar-chart-2"></span>
                            Ventas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.usuarios.*') ? 'active' : '' }}" 
                           href="{{ route('admin.usuarios.index') }}">
                            <span data-feather="users"></span>
                            Usuarios
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Panel de Administrador</h1>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Productos</h5>
                            <p class="card-text">Gestiona los productos del marketplace.</p>
                            <a href="{{ route('admin.productos.index') }}" class="btn btn-primary">Ir a Productos</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Categorías</h5>
                            <p class="card-text">Administra las categorías disponibles.</p>
                            <a href="{{ route('admin.categorias.index') }}" class="btn btn-primary">Ir a Categorías</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Ventas</h5>
                            <p class="card-text">Consulta el historial de ventas.</p>
                            <a href="{{ route('admin.ventas.index') }}" class="btn btn-primary">Ver Ventas</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Usuarios</h5>
                            <p class="card-text">Gestiona y administra los usuarios del sistema.</p>
                            <a href="{{ route('admin.usuarios.index') }}" class="btn btn-primary">Ir a Usuarios</a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
