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
        <div class="container">
            <a class="navbar-brand" href="/">Coursemarket</a>
        </div>
        <div class="d-flex align-items-center ms-auto">
            <a href="{{ route('login') }}" class="text-white text-decoration-none me-3">
                <img src="{{ asset('D:\backend_marketplace\public\img\webres\acceso.png') }}" alt="Login" width="32" height="32" class="rounded-circle">
            </a>
        </div>
    </div>
    </nav>
    <main style="margin-top: 2rem;">
        @yield('content')
    </main>
    <!-- Bootstrap JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
