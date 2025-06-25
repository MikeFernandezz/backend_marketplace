<?php

use App\Http\AdminAuthMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\CarritoController;
use App\Models\Producto;
use App\Models\Usuario;
use Illuminate\Http\Request;

Route::get('/admin/login', function () {
    return view('admin_login');
});

Route::post('/admin/login/submit', function (Request $request) {
    $request->validate([
        'correo' => 'required|email',
        'contrasena' => 'required|string',
    ]);
    $usuario = Usuario::where('correo', $request->correo)->first();
    if ($usuario && $usuario->contrasena === $request->contrasena && $usuario->rol === 'admin') {
        $request->session()->put('admin_auth', $usuario->id_usuario);
        return redirect('/admin');
    }
    return redirect('/admin/login')->with('error', 'Credenciales inválidas o no eres administrador.');
});

// Middleware manual para proteger rutas admin
Route::middleware([App\Http\AdminAuthMiddleware::class])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::resource('productos', ProductoController::class)->names([
            'index' => 'admin.productos.index',
            'create' => 'admin.productos.create',
            'store' => 'admin.productos.store',
            'show' => 'admin.productos.show',
            'edit' => 'admin.productos.edit',
            'update' => 'admin.productos.update',
            'destroy' => 'admin.productos.destroy',
        ]);
        Route::resource('categorias', CategoriaController::class)->names([
            'index' => 'admin.categorias.index',
            'create' => 'admin.categorias.create',
            'store' => 'admin.categorias.store',
            'show' => 'admin.categorias.show',
            'edit' => 'admin.categorias.edit',
            'update' => 'admin.categorias.update',
            'destroy' => 'admin.categorias.destroy',
        ]);
        // Gestión de usuarios
        Route::get('usuarios', [UsuarioController::class, 'adminIndex'])->name('admin.usuarios.index');
        Route::get('usuarios-export/csv', [UsuarioController::class, 'exportCsv'])->name('admin.usuarios.export.csv');
        Route::patch('usuarios/{id}/make-admin', [UsuarioController::class, 'makeAdmin'])->name('admin.usuarios.makeAdmin');
        Route::patch('usuarios/{id}/remove-admin', [UsuarioController::class, 'removeAdmin'])->name('admin.usuarios.removeAdmin');
        Route::delete('usuarios/{id}', [UsuarioController::class, 'adminDestroy'])->name('admin.usuarios.destroy');
        
        // Gestión de ventas
        Route::get('ventas', [VentaController::class, 'adminIndex'])->name('admin.ventas.index');
        Route::get('ventas/{id}', [VentaController::class, 'adminShow'])->name('admin.ventas.show');
        Route::get('ventas-export/csv', [VentaController::class, 'exportCsv'])->name('admin.ventas.export.csv');
    });
    Route::get('/admin', function () {
        return view('admin');
    })->name('admin.panel');
});

Route::get('/', function () {
    $productos = Producto::with('categoria')->get();
    return view('inicio', compact('productos'));
});

Route::get('/producto/{id}', function ($id) {
    $producto = Producto::with('categoria')->findOrFail($id);
    return view('producto_detalle', compact('producto'));
})->name('producto.detalle');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/register', function () {
    return view('register');
})->name('register');

Route::post('/register', [UsuarioController::class, 'store'])->name('register.submit');
Route::post('/login', [UsuarioController::class, 'login'])->name('login.submit');
Route::post('/logout', [UsuarioController::class, 'logout'])->name('logout');

// Rutas del Carrito de Compras
Route::prefix('carrito')->group(function () {
    Route::post('/agregar', [CarritoController::class, 'agregarProducto'])->name('carrito.agregar');
    Route::get('/obtener', [CarritoController::class, 'obtenerCarrito'])->name('carrito.obtener');
    Route::delete('/eliminar/{producto_id}', [CarritoController::class, 'eliminarProducto'])->name('carrito.eliminar');
    Route::delete('/vaciar', [CarritoController::class, 'vaciarCarrito'])->name('carrito.vaciar');
});

// Rutas de Checkout y Compra
Route::get('/checkout', [CarritoController::class, 'mostrarCheckout'])->name('checkout');
Route::post('/checkout/procesar', [CarritoController::class, 'procesarCompra'])->name('checkout.procesar');
Route::get('/compra/{venta_id}/detalle', [CarritoController::class, 'mostrarDetalleCompra'])->name('compra.detalle');

// Ruta para ver las compras del usuario
Route::get('/mis-compras', [CarritoController::class, 'misCompras'])->name('usuario.compras');

require __DIR__.'/categoria.php';