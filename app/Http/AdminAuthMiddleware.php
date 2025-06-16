<?php

namespace App\Http;

use Closure;
use Illuminate\Http\Request;
use App\Models\Usuario;

class AdminAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Permitir acceso a la pantalla de login admin
        if ($request->is('admin/login') || $request->is('admin/login/submit')) {
            return $next($request);
        }

        // Si no hay sesión admin, redirigir a login
        if (!$request->session()->has('admin_auth')) {
            return redirect('/admin/login');
        }

        // Validar que el usuario de la sesión sea admin
        $usuario = Usuario::find($request->session()->get('admin_auth'));
        if (!$usuario || $usuario->rol !== 'admin') {
            $request->session()->forget('admin_auth');
            return redirect('/admin/login')->with('error', 'No tienes permisos de administrador.');
        }

        return $next($request);
    }
}
