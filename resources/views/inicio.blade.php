@extends('layouts.app')

@section('content')
<div class="container my-5">

    <!-- Banner principal -->
    <div class="jumbotron text-white bg-primary rounded shadow p-5 mb-5 text-center">
        <h1 class="display-4 font-weight-bold">Bienvenido a CourseMarket</h1>
        <p class="lead">Desbloquea tu potencial con la tecnologia educativa</p>
        <a href="#productos" class="btn btn-light btn-lg mt-3">Ver productos</a>
    </div>

    <!-- Carrusel de novedades -->
    <div id="cursosCarrusel" class="carousel slide mb-5" data-bs-ride="carousel">
        <div class="carousel-inner rounded shadow" style="text-align: center;">
            <div class="carousel-item active">
                <div class="row align-items-center justify-content-center" style="min-height: 220px; padding: 32px 0;">
                    <div class="col-4 d-flex justify-content-center align-items-center">
                        <img src="img/productos/curso_html_css.jpg" class="img-thumbnail" style="width: 260px; height: 120px; object-fit: cover;" alt="Novedades 1">
                    </div>
                    <div class="col-8 text-start">
                        <h5>Curso de HTML y CSS</h5>
                        <p>Aprende a crear páginas web modernas desde cero con HTML5 y CSS3. Ideal para principiantes.</p>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="row align-items-center justify-content-center" style="min-height: 220px; padding: 32px 0;">
                    <div class="col-4 d-flex justify-content-center align-items-center">
                        <img src="img/productos/curso_java.jpg" class="img-thumbnail" style="width: 260px; height: 120px; object-fit: cover;" alt="Novedades 2">
                    </div>
                    <div class="col-8 text-start">
                        <h5>Curso de Java</h5>
                        <p>Domina la programación orientada a objetos y desarrolla aplicaciones robustas con Java.</p>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="row align-items-center justify-content-center" style="min-height: 220px; padding: 32px 0;">
                    <div class="col-4 d-flex justify-content-center align-items-center">
                        <img src="img/productos/curso_python.jpg" class="img-thumbnail" style="width: 260px; height: 120px; object-fit: cover;" alt="Novedades 3">
                    </div>
                    <div class="col-8 text-start">
                        <h5>Curso de Python</h5>
                        <p>Iníciate en el mundo de la programación con Python, uno de los lenguajes más versátiles y populares.</p>
                    </div>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#cursosCarrusel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#cursosCarrusel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>

    <!-- Display de productos -->
    <h2 id="productos" class="mb-4">Productos destacados</h2>
    <div class="row">
        @php $maxProductos = $productos->take(6); @endphp
        @foreach($maxProductos->chunk(3) as $fila)
            <div class="row mb-4">
                @foreach($fila as $producto)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <a href="{{ route('producto.detalle', $producto->id) }}" class="text-decoration-none">
                                <img src="{{ $producto->image_path ? asset('img/productos/' . $producto->image_path) : 'https://via.placeholder.com/400x250' }}" class="card-img-top" alt="{{ $producto->nombre }}" style="cursor: pointer; height: 200px; object-fit: cover;">
                            </a>
                            <div class="card-body">
                                <a href="{{ route('producto.detalle', $producto->id) }}" class="text-decoration-none text-dark">
                                    <h5 class="card-title">{{ $producto->nombre }}</h5>
                                </a>
                                <p class="card-text">{{ Str::limit($producto->descripcion, 100) }}</p>
                                <span class="badge bg-success">${{ $producto->precio }}</span>
                                @if($producto->categoria)
                                    <span class="badge bg-secondary ms-2">{{ $producto->categoria->nombre_categoria ?? $producto->categoria->nombre }}</span>
                                @endif
                            </div>
                            <div class="card-footer bg-transparent border-0">
                                <a href="{{ route('producto.detalle', $producto->id) }}" class="btn btn-primary w-100">Ver Detalles</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
        @if($maxProductos->isEmpty())
            <div class="col-12">
                <div class="alert alert-info text-center">No hay productos disponibles.</div>
            </div>
        @endif
    </div>
</div>

{{-- Footer CourseMarket --}}
<footer class="bg-dark text-light pt-5 pb-3 mt-5">
    <div class="container">
        <div class="row text-start">
            <div class="col-12 text-center mb-4">
                <a href="{{ url('/') }}" class="d-inline-block mb-3">
                    <img src="{{ asset('img/webres/logo.png') }}" alt="CourseMarket" style="height:200px;">
                </a>
            </div>
            <div class="col-6 col-md-3 mb-4">
                <h6 class="fw-bold mb-3">Conócenos</h6>
                <ul class="list-unstyled">
                    <li><a href="{{ url('/sobre-nosotros') }}" class="text-light text-decoration-none">Sobre CourseMarket</a></li>
                    <li><a href="{{ url('/trabaja-con-nosotros') }}" class="text-light text-decoration-none">Trabaja con nosotros</a></li>
                    <li><a href="{{ url('/blog') }}" class="text-light text-decoration-none">Blog</a></li>
                    <li><a href="{{ url('/prensa') }}" class="text-light text-decoration-none">Prensa</a></li>
                </ul>
            </div>
            <div class="col-6 col-md-3 mb-4">
                <h6 class="fw-bold mb-3">Gana dinero con CourseMarket</h6>
                <ul class="list-unstyled">
                    <li><a href="{{ url('/instructores') }}" class="text-light text-decoration-none">Conviértete en instructor</a></li>
                    <li><a href="{{ url('/afiliados') }}" class="text-light text-decoration-none">Programa de afiliados</a></li>
                    <li><a href="{{ url('/publica-tu-curso') }}" class="text-light text-decoration-none">Publica tu curso</a></li>
                </ul>
            </div>
            <div class="col-6 col-md-3 mb-4">
                <h6 class="fw-bold mb-3">Podemos ayudarte</h6>
                <ul class="list-unstyled">
                    <li><a href="{{ url('/faq') }}" class="text-light text-decoration-none">Preguntas frecuentes</a></li>
                    <li><a href="{{ url('/ayuda') }}" class="text-light text-decoration-none">Centro de ayuda</a></li>
                    <li><a href="{{ url('/contacto') }}" class="text-light text-decoration-none">Contacto</a></li>
                    <li><a href="{{ url('/soporte') }}" class="text-light text-decoration-none">Soporte técnico</a></li>
                </ul>
            </div>
            <div class="col-6 col-md-3 mb-4">
                <h6 class="fw-bold mb-3">Información legal</h6>
                <ul class="list-unstyled">
                    <li><a href="{{ url('/politica-privacidad') }}" class="text-light text-decoration-none">Política de privacidad</a></li>
                    <li><a href="{{ url('/terminos-condiciones') }}" class="text-light text-decoration-none">Términos y condiciones</a></li>
                </ul>
                <h6 class="fw-bold mt-4 mb-2">Síguenos</h6>
                <div>
                    <a href="https://facebook.com/coursemarket" target="_blank" class="text-light me-2" aria-label="Facebook">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="https://twitter.com/coursemarket" target="_blank" class="text-light me-2" aria-label="Twitter">
                        <i class="bi bi-twitter"></i>
                    </a>
                    <a href="https://instagram.com/coursemarket" target="_blank" class="text-light" aria-label="Instagram">
                        <i class="bi bi-instagram"></i>
                    </a>
                </div>
            </div>
        </div>
        <hr class="border-secondary my-4">
        <div class="row">
            <div class="col-md-6 text-center text-md-start mb-2 mb-md-0">
                <small>
                    <strong>Contacto:</strong> samuelfloresmateos@hotmail.com | +52 5564465466 | Calle General Barragan 803, Ciudad Paleta, Machupichu , Peru
                </small>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <small>
                    &copy; {{ date('Y') }} CourseMarket. Todos los derechos reservados.
                </small>
            </div>
        </div>
    </div>
</footer>

@endsection

