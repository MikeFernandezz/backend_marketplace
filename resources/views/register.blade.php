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
              <label for="registerFirstName">Nombre</label>
              <input type="text" class="form-control" id="registerFirstName" required />
              <small id="firstNameError" class="form-text text-danger"></small>
            </div>
            <div class="form-group">
              <label for="registerLastName">Apellidos</label>
              <input type="text" class="form-control" id="registerLastName" required />
              <small id="lastNameError" class="form-text text-danger"></small>
            </div>
            <div class="form-group">
              <label for="registerEmail">Correo electrónico</label>
              <input type="email" class="form-control" id="registerEmail" required />
              <small id="emailError" class="form-text text-danger"></small>
            </div>
            <div class="form-group">
              <label for="registerPassword">Contraseña</label>
              <input type="password" class="form-control" id="registerPassword" required />
              <small id="passwordError" class="form-text text-danger"></small>
              <small class="form-text text-muted">
                La contraseña debe tener mínimo 8 caracteres, una mayúscula, un número y un símbolo.
              </small>
            </div>
            <div class="form-group">
              <label for="confirmPassword">Confirmar contraseña</label>
              <input type="password" class="form-control" id="confirmPassword" required />
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
    function getRegisteredUsers() {
      const users = localStorage.getItem('registeredUsers');
      return users ? JSON.parse(users) : [];
    }

    function saveRegisteredUsers(users) {
      localStorage.setItem('registeredUsers', JSON.stringify(users));
    }

    function validarNombre(nombre) {
      const regex = /^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/;
      return regex.test(nombre);
    }

    function validarCorreo(correo) {
      const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      return regex.test(correo);
    }

    function validarPasswordSegura(password) {
      // Mínimo 8 caracteres, una mayúscula, un número y un símbolo
      const regex = /^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+\-=[\]{};':"\\|,.<>/?]).{8,}$/;
      return regex.test(password);
    }

    document.getElementById('registerForm').addEventListener('submit', function(e) {
      e.preventDefault();

      const firstName = document.getElementById('registerFirstName').value.trim();
      const lastName = document.getElementById('registerLastName').value.trim();
      const email = document.getElementById('registerEmail').value.trim();
      const password = document.getElementById('registerPassword').value;
      const confirmPassword = document.getElementById('confirmPassword').value;

      // Limpiar errores previos
      document.getElementById('firstNameError').textContent = '';
      document.getElementById('lastNameError').textContent = '';
      document.getElementById('emailError').textContent = '';
      document.getElementById('passwordError').textContent = '';
      document.getElementById('confirmPasswordError').textContent = '';

      let valid = true;

      // Validar nombre
      if (!firstName) {
        document.getElementById('firstNameError').textContent = 'El campo nombre es obligatorio.';
        valid = false;
      } else if (!validarNombre(firstName)) {
        document.getElementById('firstNameError').textContent = 'El nombre solo puede contener letras y espacios.';
        valid = false;
      }

      // Validar apellidos
      if (!lastName) {
        document.getElementById('lastNameError').textContent = 'El campo apellidos es obligatorio.';
        valid = false;
      } else if (!validarNombre(lastName)) {
        document.getElementById('lastNameError').textContent = 'Los apellidos solo pueden contener letras y espacios.';
        valid = false;
      }

      // Validar correo
      if (!email) {
        document.getElementById('emailError').textContent = 'El campo correo es obligatorio.';
        valid = false;
      } else if (!validarCorreo(email)) {
        document.getElementById('emailError').textContent = 'Introduce un correo electrónico válido.';
        valid = false;
      }

      // Validar contraseña
      if (!password) {
        document.getElementById('passwordError').textContent = 'La contraseña es obligatoria.';
        valid = false;
      } else if (!validarPasswordSegura(password)) {
        document.getElementById('passwordError').textContent = 'Contraseña insegura. Usa mínimo 8 caracteres, una mayúscula, un número y un símbolo.';
        valid = false;
      }

      // Confirmar contraseña
      if (!confirmPassword) {
        document.getElementById('confirmPasswordError').textContent = 'Debes confirmar la contraseña.';
        valid = false;
      } else if (password !== confirmPassword) {
        document.getElementById('confirmPasswordError').textContent = 'Las contraseñas no coinciden.';
        valid = false;
      }

      // Verificar si correo ya registrado
      const users = getRegisteredUsers();
      if (users.find(u => u.email === email)) {
        document.getElementById('emailError').textContent = 'El correo ya está registrado. Usa otro.';
        valid = false;
      }

      if (!valid) return;

      // Guardar usuario
      users.push({ firstName, lastName, email, password });
      saveRegisteredUsers(users);
      alert('Registro exitoso. Ahora puedes iniciar sesión.');
      this.reset();
      window.location.href = "login.html";
    });
  </script>
</body>
</html>
