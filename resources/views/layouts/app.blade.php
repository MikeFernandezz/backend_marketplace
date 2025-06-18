<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Coursemarket</title>
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Logo Theme CSS -->
    <link rel="stylesheet" href="{{ asset('css/logo-theme.css') }}">
    <!-- Carrito CSS -->
    <link rel="stylesheet" href="{{ asset('css/carrito.css') }}">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    
    <!-- Estilos específicos de cada página -->
    @stack('styles')
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
                    <div class="navbar-brand-container">
                        <img src="{{ asset('img/webres/logo_img.png') }}" alt="CourseMarket" class="navbar-brand-img">
                        <a class="navbar-brand ms-2" href="/">Coursemarket</a>
                    </div>
                </div>
                <div class="col-auto ms-auto d-flex align-items-center flex-nowrap">
                    @if(session('usuario_auth'))
                        <?php $usuario = \App\Models\Usuario::find(session('usuario_auth')); ?>
                        
                        <!-- Carrito de Compras -->
                        <div class="dropdown me-2 position-relative" onmouseover="document.getElementById('dropdownCarrito').classList.add('show');document.getElementById('carritoMenu').classList.add('show'); cargarCarrito();" onmouseleave="document.getElementById('dropdownCarrito').classList.remove('show');document.getElementById('carritoMenu').classList.remove('show');">
                            <button class="btn position-relative border-0 bg-transparent shadow-none text-white" type="button" id="dropdownCarrito" data-bs-toggle="dropdown" aria-expanded="false" style="padding: 0.5rem 0.75rem;">
                                <i class="bi bi-cart3" style="font-size: 1.5rem;"></i>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="carrito-contador" style="font-size: 0.6rem;">
                                    0
                                </span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end p-0 carrito-dropdown" id="carritoMenu" aria-labelledby="dropdownCarrito">,
                                <div class="p-3 border-bottom">
                                    <h6 class="mb-0 fw-bold">Mi Carrito</h6>
                                </div>
                                <div id="carrito-contenido">
                                    <div class="p-3 text-center text-muted">
                                        <i class="bi bi-cart-x" style="font-size: 2rem;"></i>
                                        <p class="mb-0 mt-2">Tu carrito está vacío</p>
                                    </div>
                                </div>
                                <div class="p-3 border-top" id="carrito-footer" style="display: none;">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <strong>Total: $<span id="carrito-total">0.00</span></strong>
                                    </div>
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('checkout') }}" class="btn btn-primary btn-sm">Finalizar Compra</a>
                                        <button class="btn btn-outline-secondary btn-sm" onclick="vaciarCarrito()">Vaciar Carrito</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Menú desplegable de usuario autenticado -->
                        <div class="dropdown" onmouseover="document.getElementById('dropdownUsuario').classList.add('show');document.getElementById('usuarioMenu').classList.add('show');" onmouseleave="document.getElementById('dropdownUsuario').classList.remove('show');document.getElementById('usuarioMenu').classList.remove('show');">
                            <button class="btn dropdown-toggle d-flex align-items-center border-0 bg-transparent shadow-none text-white" type="button" id="dropdownUsuario" data-bs-toggle="dropdown" aria-expanded="false" style="padding: 0.5rem 0.75rem;">
                                <span class="me-2">Hola, {{ $usuario ? $usuario->nombre : 'Usuario' }}</span>
                                <img src="{{ asset('img/webres/acceso.png') }}" alt="Usuario" width="24" height="24" class="rounded-circle">
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" id="usuarioMenu" aria-labelledby="dropdownUsuario">
                                <li><a class="dropdown-item" href="{{ route('usuario.compras') }}">Ver Mis Compras</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item" style="border: none; background: none; width: 100%; text-align: left;">
                                            Cerrar Sesión
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
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

    <!-- Script del Carrito -->
    <script src="{{ asset('js/carrito.js') }}"></script>
    <!-- Debug temporal -->
    @if(config('app.debug'))
        <script src="{{ asset('js/debug-imagenes.js') }}"></script>
        <script src="{{ asset('js/debug-carrito.js') }}"></script>
    @endif
    
    <!-- Scripts específicos de cada página -->
    @stack('scripts')
</body>
</html>
