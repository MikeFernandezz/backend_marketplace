# CourseMarket - Marketplace de Cursos Digitales

## 📋 Descripción del Proyecto

CourseMarket es un marketplace completo desarrollado en Laravel 12 para la venta de cursos digitales. El sistema incluye un panel de administración avanzado, sistema de carrito de compras, gestión de usuarios, ventas y una arquitectura modular escalable.

## 🚀 Características Principales

### 🛒 Sistema de Carrito de Compras
- **Carrito desplegable** con funcionalidades completas
- **Adaptado para cursos digitales** (sin cantidades múltiples)
- **Proceso de checkout** simplificado sin dirección de envío
- **Historial de compras** con detalles completos
- **Prevención de duplicados** - un curso por usuario
- **Integración completa** con el sistema de ventas

### 👥 Gestión de Usuarios Avanzada
- **CRUD completo** con búsqueda avanzada
- **Gestión de permisos** de administrador
- **Filtros múltiples** (nombre, apellidos, correo, rol)
- **Exportación a CSV** de usuarios filtrados
- **Protecciones de seguridad** (último admin, auto-remoción)
- **Estadísticas en tiempo real**

### 📊 Sistema de Ventas
- **Ventas con múltiples productos** individuales
- **Precios históricos** preservados
- **Consulta avanzada** con filtros por fecha y usuario
- **Exportación a CSV** de ventas
- **Transacciones atómicas** para integridad de datos
- **API REST** completa para ventas

### 🎨 Arquitectura Modular de Assets
- **CSS y JS modulares** por funcionalidad
- **Sistema de sincronización** automatizado
- **Optimización con Vite** para producción
- **Estructura organizada** y escalable

## 🛠️ Tecnologías Utilizadas

### Backend
- **PHP 8.2+** con Laravel 12
- **MySQL** para base de datos (SQLite también soportado)
- **Eloquent ORM** para interacciones con BD
- **Middleware personalizado** para autenticación admin

### Frontend
- **Bootstrap 5.3** para diseño responsivo
- **Vite** para bundling y optimización
- **JavaScript Vanilla** para funcionalidades AJAX
- **SASS** para preprocesamiento CSS
- **Font Awesome** para iconografía

### Herramientas de Desarrollo
- **Composer** para gestión de dependencias PHP
- **NPM** para gestión de dependencias frontend
- **PHPUnit** para testing
- **Laravel Pint** para linting de código

## 📁 Estructura del Proyecto

```
backend_marketplace/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── CarritoController.php      # Lógica del carrito
│   │   │   ├── ProductoController.php     # CRUD productos
│   │   │   ├── CategoriaController.php    # CRUD categorías
│   │   │   ├── UsuarioController.php      # Gestión usuarios
│   │   │   └── VentaController.php        # Sistema de ventas
│   │   └── AdminAuthMiddleware.php        # Middleware admin
│   └── Models/
│       ├── Producto.php                   # Modelo productos
│       ├── Categoria.php                  # Modelo categorías
│       ├── Usuario.php                    # Modelo usuarios
│       ├── Venta.php                      # Modelo ventas
│       └── VentaProducto.php             # Relación venta-producto
├── database/
│   ├── migrations/                        # Migraciones de BD
│   ├── seeders/                          # Datos de prueba
│   └── database.sqlite                   # Base de datos SQLite (opcional)
├── resources/
│   ├── views/                            # Vistas Blade
│   ├── css/                              # CSS modular
│   └── js/                               # JavaScript modular
├── public/                               # Assets públicos
├── routes/
│   └── web.php                           # Rutas web y API
└── scripts/
    ├── sync-assets.ps1                   # Sincronización automática
    └── sync-assets-clean.ps1             # Limpieza de assets
```

## 🚀 Instalación y Configuración

### Requisitos Previos
- PHP 8.2 o superior
- Composer
- Node.js 18+ y NPM
- **MySQL Server** (recomendado) o SQLite

### Pasos de Instalación

1. **Clonar el repositorio**
   ```bash
   git clone <url-del-repositorio>
   cd backend_marketplace
   ```

2. **Instalar dependencias PHP**
   ```bash
   composer install
   ```

3. **Instalar dependencias Node.js**
   ```bash
   npm install
   ```

4. **Configurar el entorno**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configurar la base de datos**

   #### Opción A: MySQL (Recomendado para producción)
   ```bash
   # Editar .env para configurar MySQL
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=marketplace_db
   DB_USERNAME=tu_usuario
   DB_PASSWORD=tu_contraseña
   ```
   
   **Pasos adicionales para MySQL:**
   1. Instalar MySQL Server
   2. Crear base de datos: `CREATE DATABASE marketplace_db;`
   3. Crear usuario y otorgar permisos
   4. Ejecutar migraciones: `php artisan migrate`

   #### Opción B: SQLite (Ideal para desarrollo)
   ```bash
   # Configuración por defecto en .env
   DB_CONNECTION=sqlite
   
   # Crear archivo de base de datos
   touch database/database.sqlite
   php artisan migrate
   ```

6. **Ejecutar seeders (opcional)**
   ```bash
   php artisan db:seed
   ```

7. **Compilar assets**
   ```bash
   npm run build
   # O para desarrollo
   npm run dev
   ```

8. **Sincronizar assets modulares**
   ```powershell
   .\sync-assets-clean.ps1
   ```

9. **Iniciar el servidor**
   ```bash
   php artisan serve
   ```

## 🗄️ Configuración de Base de Datos

### MySQL vs SQLite

#### MySQL (Recomendado)
- **✅ Ventajas:**
  - Mejor rendimiento para aplicaciones en producción
  - Soporte completo para operaciones concurrentes
  - Escalabilidad superior
  - Funcionalidades avanzadas (vistas, procedimientos almacenados)
  - Ideal para aplicaciones web con múltiples usuarios

- **⚙️ Configuración:**
  ```bash
  # Instalar MySQL
  # Windows: Descargar MySQL Installer
  # macOS: brew install mysql
  # Ubuntu: sudo apt install mysql-server
  
  # Configurar .env
  DB_CONNECTION=mysql
  DB_HOST=127.0.0.1
  DB_PORT=3306
  DB_DATABASE=marketplace_db
  DB_USERNAME=tu_usuario
  DB_PASSWORD=tu_contraseña
  ```

#### SQLite (Desarrollo)
- **✅ Ventajas:**
  - Configuración mínima
  - Ideal para desarrollo y testing
  - No requiere servidor separado
  - Base de datos en archivo único

- **⚙️ Configuración:**
  ```bash
  # Configurar .env
  DB_CONNECTION=sqlite
  
  # Crear base de datos
  touch database/database.sqlite
  ```

### Migración entre Bases de Datos

Si necesitas cambiar de SQLite a MySQL:

1. **Exportar datos existentes:**
   ```bash
   php artisan db:seed --class=DatabaseSeeder
   ```

2. **Configurar MySQL** según los pasos anteriores

3. **Ejecutar migraciones:**
   ```bash
   php artisan migrate:fresh --seed
   ```

## 🎯 Uso del Sistema

### Para Usuarios Finales

1. **Registro y Login**
   - Registrarse en `/register`
   - Iniciar sesión en `/login`

2. **Explorar Cursos**
   - Navegar por categorías
   - Ver detalles de productos
   - Buscar cursos específicos

3. **Comprar Cursos**
   - Agregar cursos al carrito
   - Revisar carrito desplegable
   - Completar checkout
   - Ver historial de compras en `/mis-compras`

### Para Administradores

1. **Acceso al Panel**
   - Login admin en `/admin/login`
   - Panel principal en `/admin`

2. **Gestión de Productos**
   - CRUD completo de productos y categorías
   - Subida de imágenes
   - Gestión de precios

3. **Gestión de Usuarios**
   - Ver todos los usuarios
   - Buscar y filtrar usuarios
   - Otorgar/remover permisos admin
   - Exportar datos de usuarios

4. **Consulta de Ventas**
   - Ver todas las ventas
   - Filtrar por fecha y usuario
   - Ver detalles de cada venta
   - Exportar reportes de ventas

## 🔧 Características Técnicas Avanzadas

### Sistema de Carrito Adaptado para Cursos Digitales

#### Funcionalidades Específicas:
- **Cantidad fija = 1**: Todos los cursos tienen cantidad 1
- **Sin duplicados**: Prevención de agregar el mismo curso múltiples veces
- **Sin dirección de envío**: Checkout simplificado para productos digitales
- **Notificaciones informativas**: Mensajes claros para el usuario

#### Flujo de Compra:
1. Usuario agrega curso al carrito
2. Sistema valida si el curso ya existe
3. Si existe: muestra mensaje informativo
4. Si no existe: agrega con cantidad = 1
5. Checkout sin campos de dirección
6. Procesamiento y creación de venta
7. Acceso inmediato al curso digital

### Sistema de Ventas con Productos Múltiples

#### Características:
- **Tabla pivot `venta_productos`**: Relación many-to-many entre ventas y productos
- **Precios históricos**: Conserva el precio al momento de la venta
- **Transacciones atómicas**: Garantiza integridad de datos
- **API REST completa**: Endpoints para todas las operaciones CRUD

#### Endpoints API:
```
GET    /api/ventas                    - Listar ventas
GET    /api/ventas/{id}               - Ver venta específica
POST   /api/ventas                    - Crear venta
PUT    /api/ventas/{id}               - Actualizar venta
DELETE /api/ventas/{id}               - Eliminar venta
GET    /api/ventas/{id}/productos     - Productos de una venta
POST   /api/ventas/{id}/productos     - Agregar producto a venta
DELETE /api/ventas/{ventaId}/productos/{productoId} - Remover producto
```

### Arquitectura Modular de Assets

#### Estructura CSS:
```
resources/css/
├── admin/
│   └── usuarios.css          # Estilos admin usuarios
├── ventas/
│   ├── ventas-shared.css     # Estilos compartidos ventas
│   └── venta-detalle.css     # Detalle de venta
├── producto-detalle.css      # Detalle de productos
├── checkout.css              # Proceso de compra
├── detalle-compra.css        # Detalle de compras
└── mis-compras.css           # Historial de compras
```

#### Sistema de Sincronización:
```powershell
# Sincronización automática
.\sync-assets.ps1

# Limpieza de assets
.\sync-assets-clean.ps1
```

## 🔒 Características de Seguridad

### Autenticación y Autorización
- **Middleware personalizado** para rutas admin
- **Validación de tokens CSRF** en todas las peticiones
- **Protección contra auto-eliminación** de administradores
- **Verificación de rol** en operaciones sensibles

### Validación de Datos
- **Validación robusta** en todos los formularios
- **Sanitización de entrada** de usuario
- **Validación de existencia** de registros
- **Manejo de errores** comprehensivo

### Transacciones y Consistencia
- **Transacciones de base de datos** para operaciones críticas
- **Rollback automático** en caso de errores
- **Integridad referencial** preservada
- **Logging detallado** de operaciones

## 🐛 Soluciones a Problemas Comunes

### Problema: Error de Primera Notificación en Carrito
**Síntoma**: Primera vez agregando producto muestra error aunque sea exitoso
**Solución**: Implementado event listener robusto y validación mejorada de respuestas

### Problema: Imágenes no se Muestran
**Síntoma**: Imágenes no aparecen en carrito ni checkout
**Solución**: Corregida inconsistencia entre `image_path` e `imagen_path`, agregado fallback a placeholder

### Problema: Error de Formato de Fechas
**Síntoma**: `Call to a member function format() on string`
**Solución**: Configurado cast de `fecha_venta` como datetime en modelo, manejo robusto en vistas

## 📊 Comandos Útiles

### Desarrollo
```bash
# Servidor de desarrollo con herramientas
composer run dev

# Solo servidor Laravel
php artisan serve

# Assets en modo watch
npm run dev

# Sincronizar assets modulares
.\sync-assets.ps1
```

### Producción
```bash
# Build optimizado
npm run build

# Optimizar aplicación
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Base de Datos
```bash
# Migraciones
php artisan migrate

# Rollback migraciones
php artisan migrate:rollback

# Recrear base de datos con seeders
php artisan migrate:fresh --seed

# Seeders específicos
php artisan db:seed --class=CarritoTestSeeder
php artisan db:seed --class=CarritoTestSeederFixed

# Verificar estado de migraciones
php artisan migrate:status

# Para MySQL: verificar conexión
php artisan tinker
# Luego: DB::connection()->getPdo();
```

### Testing
```bash
# Ejecutar tests
php artisan test

# Tests específicos
composer run test
```

## 🎨 Diseño y UX

### Principios de Diseño
- **Cohesión estética** en todo el sistema
- **Diseño responsivo** con Bootstrap 5
- **Iconografía consistente** con Font Awesome
- **Paleta de colores** profesional y accesible
- **Tipografía** legible y moderna

### Experiencia de Usuario
- **Navegación intuitiva** con breadcrumbs implícitos
- **Feedback visual** inmediato en todas las acciones
- **Mensajes informativos** claros y contextuales
- **Animaciones sutiles** para mejorar la interacción
- **Carga optimizada** de recursos por página

## 🚀 Mejoras Futuras Sugeridas

### Funcionalidades
- [ ] **Carrito persistente** en base de datos
- [ ] **Wishlist** o lista de deseos
- [ ] **Sistema de cupones** de descuento
- [ ] **Múltiples métodos de pago** (PayPal, Stripe)
- [ ] **Notificaciones por email** de compras
- [ ] **Generación de PDFs** para recibos
- [ ] **Sistema de reviews** de cursos
- [ ] **Dashboard analítico** avanzado

### Técnicas
- [ ] **Cache Redis** para carrito y sesiones
- [ ] **API REST** para aplicación móvil
- [ ] **WebSockets** para notificaciones en tiempo real
- [ ] **Queue system** para emails y procesos pesados
- [ ] **CDN integration** para assets estáticos
- [ ] **Optimización de consultas** con eager loading
- [ ] **Logging avanzado** con Monolog

### UX/UI
- [ ] **PWA** (Progressive Web App)
- [ ] **Dark mode** opcional
- [ ] **Drag & drop** en carrito
- [ ] **Vista rápida** de productos
- [ ] **Recomendaciones** personalizadas
- [ ] **Búsqueda avanzada** con filtros
- [ ] **Comparador** de cursos

## 🤝 Contribución

### Estructura de Commits
```
tipo(scope): descripción breve

Descripción detallada del cambio (opcional)

Fixes #issue_number (si aplica)
```

### Tipos de Commits
- `feat`: Nueva funcionalidad
- `fix`: Corrección de bug
- `docs`: Documentación
- `style`: Formateo, espacios, etc.
- `refactor`: Refactorización de código
- `test`: Agregar o modificar tests
- `chore`: Tareas de mantenimiento

### Pull Request Guidelines
1. Fork del repositorio
2. Crear rama feature: `git checkout -b feature/nueva-funcionalidad`
3. Commit de cambios: `git commit -m 'feat: agregar nueva funcionalidad'`
4. Push a la rama: `git push origin feature/nueva-funcionalidad`
5. Crear Pull Request

## 📄 Licencia

Este proyecto está licenciado bajo la Licencia MIT. Ver el archivo `LICENSE` para más detalles.

## 📞 Soporte

Para soporte técnico o reportar bugs:

1. **Issues**: Usar el sistema de issues del repositorio
2. **Documentación**: Revisar este README y documentación en `/docs`
3. **Logs**: Revisar `storage/logs/laravel.log` para errores
4. **Debug**: Activar modo debug en `.env` para desarrollo

## 🙏 Agradecimientos

- **Laravel Framework** por la base sólida
- **Bootstrap** por el sistema de diseño
- **Font Awesome** por la iconografía
- **Vite** por la optimización de assets
- **Comunidad Laravel** por el soporte y recursos

---

**CourseMarket** - Desarrollado para la venta eficiente de cursos digitales con herramientas modernas y arquitectura escalable.

*Última actualización: Junio 2025*
