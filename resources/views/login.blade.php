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
          <form id="loginForm">
            <div class="form-group">
              <label for="loginEmail">Correo electrónico</label>
              <input type="email" class="form-control" id="loginEmail" placeholder="Ingresa tu correo" required />
              <small id="emailError" class="form-text text-danger"></small>
            </div>

            <div class="form-group">
              <label for="loginPassword">Contraseña</label>
              <input type="password" class="form-control" id="loginPassword" placeholder="Contraseña" required />
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

  <!-- JS -->
  <script>
    function getRegisteredUsers() {
      const users = localStorage.getItem('registeredUsers');
      return users ? JSON.parse(users) : [];
    }

    function esEmailValido(email) {
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      return emailRegex.test(email);
    }

    function esPasswordValida(password) {
      const passwordRegex = /^[A-Za-z0-9@._\-!]{6,20}$/;
      return passwordRegex.test(password);
    }

    document.getElementById('loginForm').addEventListener('submit', function(e) {
      e.preventDefault();

      const email = document.getElementById('loginEmail').value.trim();
      const password = document.getElementById('loginPassword').value;

      document.getElementById('emailError').textContent = '';
      document.getElementById('passwordError').textContent = '';

      let valido = true;

      if (!esEmailValido(email)) {
        document.getElementById('emailError').textContent = 'Por favor, ingresa un correo electrónico válido.';
        valido = false;
      }

      if (!esPasswordValida(password)) {
        document.getElementById('passwordError').textContent =
          'La contraseña debe tener entre 6 y 20 caracteres. Solo se permiten letras, números y símbolos como @ . _ - !';
        valido = false;
      }

      if (!valido) return;

      const users = getRegisteredUsers();
      const foundUser = users.find(u => u.email === email && u.password === password);

      if (!foundUser) {
        document.getElementById('passwordError').textContent = 'Correo o contraseña incorrectos.';
        return;
      }

      alert(`Bienvenido, ${foundUser.firstName || 'usuario'}!`);
      this.reset();
      // window.location.href = 'dashboard.html';
    });
  </script>
</body>
</html>
