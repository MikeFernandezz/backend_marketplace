<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Marketplace - Login</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
  <link rel="stylesheet" href="{{ asset('estilos.css') }}" />
</head>
<body>
  <img src="{{ asset('logo.png') }}" alt="Logo" class="logo-superior-derecha" />

  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card p-4">
          <form id="loginForm" method="POST" action="{{ route('login.submit') }}">
            @csrf
            @if($errors->has('contrasena'))
              <div class="alert alert-danger">{{ $errors->first('contrasena') }}</div>
            @endif
            <div class="form-group">
              <label for="loginEmail">Correo electrónico</label>
              <input type="email" class="form-control" id="loginEmail" name="correo" placeholder="Ingresa tu correo" required />
              <small id="emailError" class="form-text text-danger"></small>
            </div>

            <div class="form-group">
              <label for="loginPassword">Contraseña</label>
              <input type="password" class="form-control" id="loginPassword" name="contrasena" placeholder="Contraseña" required />
              <small id="passwordError" class="form-text text-danger"></small>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Entrar</button>
          </form>

          <p class="mt-3 text-center">
            ¿No tienes una cuenta? <a href="{{ route('register') }}">Regístrate</a>
          </p>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
