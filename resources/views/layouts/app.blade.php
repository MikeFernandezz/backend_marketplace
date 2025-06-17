<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coursemarket</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <div class="row w-100 align-items-center">
                <div class="col-auto">
                    <!-- Menú desplegable de categorías con icono de menú hamburguesa -->
                    <div class="dropdown" onmouseover="document.getElementById('dropdownCategorias').classList.add('show');document.getElementById('categoriasMenu').classList.add('show');" onmouseleave="document.getElementById('dropdownCategorias').classList.remove('show');document.getElementById('categoriasMenu').classList.remove('show');">
                        <button class="btn dropdown-toggle d-flex align-items-center border-0 bg-transparent shadow-none" type="button" id="dropdownCategorias" data-bs-toggle="dropdown" aria-expanded="false" style="padding: 0.5rem 0.75rem;">
                            <span style="font-size: 1.5rem; line-height: 1;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M2.5 12.5a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1h-10a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1h-10a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1h-10a.5.5 0 0 1-.5-.5z"/>
                                </svg>
                            </span>
                        </button>
                        <ul class="dropdown-menu" id="categoriasMenu" aria-labelledby="dropdownCategorias">
                            @foreach($categorias as $categoria)
                                <li><a class="dropdown-item" href="{{ url('/categoria/' . $categoria->id_categoria) }}">{{ $categoria->nombre_categoria }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col">
                    <a class="navbar-brand ms-3" href="/">Coursemarket</a>
                </div>
                <div class="col-auto ms-auto">
                    @if(session('usuario_auth'))
                        <?php $usuario = \App\Models\Usuario::find(session('usuario_auth')); ?>
                        <span class="text-white me-3">Hola, {{ $usuario ? $usuario->nombre : 'Usuario' }}</span>
                    @else
                        <a href="{{ route('login') }}" class="text-white text-decoration-none me-3">
                            <img src="{{ asset('img/webres/acceso.png') }}" alt="Login" width="32" height="32" class="rounded-circle">
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </nav>
    <main style="margin-top: 2rem;">
        @yield('content')
    </main>
    <!-- Bootstrap JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .dropdown:hover .dropdown-menu {
            display: block;
            margin-top: 0;
        }
        .dropdown-menu {
            transition: none;
        }
    </style>
</body>
</html>
