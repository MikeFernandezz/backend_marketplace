<?php

use App\Http\AdminAuthMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\UsuarioController;
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
        Route::patch('usuarios/{id}/make-admin', [UsuarioController::class, 'makeAdmin'])->name('admin.usuarios.makeAdmin');
        Route::delete('usuarios/{id}', [UsuarioController::class, 'adminDestroy'])->name('admin.usuarios.destroy');
    });
    Route::get('/admin', function () {
        return view('admin');
    })->name('admin.panel');
});

Route::get('/', function () {
    $productos = Producto::with('categoria')->get();
    return view('inicio', compact('productos'));
});

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/register', function () {
    return view('register');
})->name('register');

Route::post('/register', [UsuarioController::class, 'store'])->name('register.submit');
Route::post('/login', [UsuarioController::class, 'login'])->name('login.submit');

require __DIR__.'/categoria.php';