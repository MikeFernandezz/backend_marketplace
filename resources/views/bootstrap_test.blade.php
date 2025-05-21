<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prueba Bootstrap</title>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-primary">¡Bootstrap está funcionando!</h1>
        <button class="btn btn-success">Botón de prueba</button>
        <div class="alert alert-info mt-3">Si ves este mensaje con estilos, Bootstrap está instalado correctamente.</div>
    </div>
</body>
</html>
