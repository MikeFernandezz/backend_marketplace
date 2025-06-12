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
  <img src="{{ asset('logo.png') }}" alt="Logo" class="logo-superior-derecha" />

  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card p-4">
          <h3 class="text-center mb-4">Registro de Usuario</h3>
          <form id="registerForm">
            <div class="form-group">
              <label for="registerName">Nombre completo</label>
              <input type="text" class="form-control" id="registerName" required />
            </div>
            <div class="form-group">
              <label for="registerEmail">Correo electrónico</label>
              <input type="email" class="form-control" id="registerEmail" required />
            </div>
            <div class="form-group">
              <label for="registerPassword">Contraseña</label>
              <input type="password" class="form-control" id="registerPassword" required />
            </div>
            <div class="form-group">
              <label for="confirmPassword">Confirmar contraseña</label>
              <input type="password" class="form-control" id="confirmPassword" required />
            </div>
            <button type="submit" class="btn btn-success btn-block">Registrarse</button>
            <p class="text-center mt-3">
              ¿Ya tienes cuenta? <a href="login.html">Inicia sesión</a>
            </p>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script>
    function getRegisteredUsers() {
      const users = localStorage.getItem('registeredUsers');
      return users ? JSON.parse(users) : [];
    }

    function saveRegisteredUsers(users) {
      localStorage.setItem('registeredUsers', JSON.stringify(users));
    }

    document.getElementById('registerForm').addEventListener('submit', function(e) {
      e.preventDefault();
      const name = document.getElementById('registerName').value.trim();
      const email = document.getElementById('registerEmail').value.trim();
      const password = document.getElementById('registerPassword').value;
      const confirmPassword = document.getElementById('confirmPassword').value;

      if (!name || !email || !password || !confirmPassword) {
        alert('Por favor, llena todos los campos.');
        return;
      }

      if (password !== confirmPassword) {
        alert('Las contraseñas no coinciden.');
        return;
      }

      let users = getRegisteredUsers();
      if (users.find(u => u.email === email)) {
        alert('El correo ya está registrado. Usa otro.');
        return;
      }

      users.push({ name, email, password });
      saveRegisteredUsers(users);
      alert('Registro exitoso. Ahora puedes iniciar sesión.');
      this.reset();
      window.location.href = "login.html";
    });
  </script>
</body>
</html>
