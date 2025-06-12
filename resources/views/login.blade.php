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
          <!-- Solo Login Form -->
          <form id="loginForm">
            <div class="form-group">
              <label for="loginEmail">Correo electrónico</label>
              <input type="email" class="form-control" id="loginEmail" placeholder="Ingresa tu correo" required />
            </div>
            <div class="form-group">
              <label for="loginPassword">Contraseña</label>
              <input type="password" class="form-control" id="loginPassword" placeholder="Contraseña" required />
            </div>
            <button type="submit" class="btn btn-primary btn-block">Entrar</button>
          </form>

          <!-- Mensaje para registro -->
          <p class="mt-3 text-center">
            ¿No tienes una cuenta?
            <a href="registro.html">Regístrate</a>
          </p>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS, Popper.js, and jQuery -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <!-- Lógica JavaScript embebida -->
  <script>
    function getRegisteredUsers() {
      const users = localStorage.getItem('registeredUsers');
      return users ? JSON.parse(users) : [];
    }

    document.getElementById('loginForm').addEventListener('submit', function(e) {
      e.preventDefault();
      const email = document.getElementById('loginEmail').value.trim();
      const password = document.getElementById('loginPassword').value;

      let users = getRegisteredUsers();
      const foundUser = users.find(u => u.email === email && u.password === password);

      if (!foundUser) {
        alert('Correo o contraseña incorrectos.');
        return;
      }

      alert(`Bienvenido, ${foundUser.name}!`);
      this.reset();
      // Aquí podrías redirigir a la página principal o dashboard, ejemplo:
      // window.location.href = 'dashboard.html';
    });
  </script>
</body>
</html>
