<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Registrarse</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
  <link rel="stylesheet" href="{{ asset('estilos.css') }}" />
</head>
<body>
  <a href="{{ url('/') }}" class="d-inline-block mb-3">
    <img src="{{ asset('img/webres/logo.png') }}" alt="CourseMarket" class="logo-superior-derecha" style="height:150px;" />
  </a>  

  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card p-4">
          <h3 class="text-center mb-4">Registro de Usuario</h3>
          <form id="registerForm" method="POST" action="{{ route('register.submit') }}">
            @csrf
            @if($errors->any())
              <div class="alert alert-danger">
                <ul class="mb-0">
                  @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif
            <div class="form-group">
              <label for="registerFirstName">Nombre</label>
              <input type="text" class="form-control" id="registerFirstName" name="nombre" required />
              <small id="firstNameError" class="form-text text-danger"></small>
            </div>
            <div class="form-group">
              <label for="registerLastName">Apellidos</label>
              <input type="text" class="form-control" id="registerLastName" name="apellidos" required />
              <small id="lastNameError" class="form-text text-danger"></small>
            </div>
            <div class="form-group">
              <label for="registerEmail">Correo electrónico</label>
              <input type="email" class="form-control" id="registerEmail" name="correo" required />
              <small id="emailError" class="form-text text-danger"></small>
            </div>
            <div class="form-group">
              <label for="registerPassword">Contraseña</label>
              <input type="password" class="form-control" id="registerPassword" name="contrasena" required />
              <small id="passwordError" class="form-text text-danger"></small>
              <small class="form-text text-muted">
                La contraseña debe tener mínimo 8 caracteres, una mayúscula, un número y un símbolo.
              </small>
            </div>
            <div class="form-group">
              <label for="confirmPassword">Confirmar contraseña</label>
              <input type="password" class="form-control" id="confirmPassword" name="confirmar_contrasena" required />
              <small id="confirmPasswordError" class="form-text text-danger"></small>
            </div>
            <button type="submit" class="btn btn-success btn-block">Registrarse</button>
            <p class="text-center mt-3">
              ¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión</a>
            </p>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script>
    // Eliminar el manejo de localStorage y validación JS, dejar validación en backend
  </script>
</body>
</html>
