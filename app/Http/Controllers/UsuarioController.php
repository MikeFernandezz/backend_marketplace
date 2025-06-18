<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function index()
    {
        return response()->json(Usuario::all());
    }

    public function show($id)
    {
        return response()->json(Usuario::findOrFail($id));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:100', 'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/'],
            'apellidos' => ['required', 'string', 'max:100', 'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/'],
            'correo' => 'required|string|email|max:100|unique:usuarios,correo',
            'contrasena' => [
                'required',
                'string',
                'min:8',
                'max:255',
                'regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+\-=\[\]{};\\:\"|,.<>\/?]).{8,}$/'
            ],
            'confirmar_contrasena' => 'required|same:contrasena',
        ], [
            'nombre.regex' => 'El nombre solo puede contener letras y espacios.',
            'apellidos.regex' => 'Los apellidos solo pueden contener letras y espacios.',
            'correo.unique' => 'El correo ya está registrado.',
            'contrasena.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'contrasena.regex' => 'La contraseña debe tener mínimo 8 caracteres, una mayúscula, un número y un símbolo.',
            'confirmar_contrasena.same' => 'Las contraseñas no coinciden.'
        ]);
        try {
            $usuario = Usuario::create([
                'nombre' => $validated['nombre'],
                'apellidos' => $validated['apellidos'],
                'correo' => $validated['correo'],
                'contrasena' => Hash::make($validated['contrasena']),
                'rol' => 'cliente',
            ]);
        } catch (\Exception $e) {
            return back()->withErrors(['general' => 'Ocurrió un error al crear el usuario: ' . $e->getMessage()])->withInput();
        }
        return redirect()->route('login')->with('success', 'Registro exitoso. Ahora puedes iniciar sesión.');
    }

    public function login(Request $request)
    {
        $request->validate([
            'correo' => 'required|email',
            'contrasena' => 'required|string',
        ]);
        $usuario = Usuario::where('correo', $request->correo)->first();
        if ($usuario && Hash::check($request->contrasena, $usuario->contrasena)) {
            $request->session()->put('usuario_auth', $usuario->id_usuario);
            return redirect('/')->with('success', 'Bienvenido, ' . $usuario->nombre . '!');
        }        return back()->withErrors(['contrasena' => 'Correo o contraseña incorrectos.'])->withInput();
    }

    public function logout(Request $request)
    {
        $request->session()->forget('usuario_auth');
        return redirect('/')->with('success', 'Sesión cerrada exitosamente.');
    }

    public function update(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);
        $validated = $request->validate([
            'nombre' => 'sometimes|required|string|max:100',
            'apellidos' => 'sometimes|required|string|max:100',
            'correo' => 'sometimes|required|string|email|max:100|unique:usuarios,correo,' . $id . ',id_usuario',
            'contrasena' => 'sometimes|required|string|max:255',
            'rol' => 'sometimes|in:cliente,admin',
        ]);
        $usuario->update($validated);
        return response()->json($usuario);
    }

    public function destroy($id)
    {
        Usuario::destroy($id);
        return response()->json(null, 204);
    }    public function adminIndex(Request $request)
    {
        $query = Usuario::query();
        
        // Filtro por rol
        if ($request->filled('rol')) {
            $query->where('rol', $request->rol);
        }
        
        // Filtro por búsqueda (nombre, apellidos o correo)
        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function($q) use ($buscar) {
                $q->where('nombre', 'LIKE', '%' . $buscar . '%')
                  ->orWhere('apellidos', 'LIKE', '%' . $buscar . '%')
                  ->orWhere('correo', 'LIKE', '%' . $buscar . '%');
            });
        }
        
        $usuarios = $query->orderBy('nombre')->get();
        return view('admin_usuarios', compact('usuarios'));
    }

    public function makeAdmin($id)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->rol = 'admin';
        $usuario->save();
        return redirect()->route('admin.usuarios.index')->with('success', 'Permiso de administrador otorgado.');
    }
      public function removeAdmin($id)
    {
        $usuario = Usuario::findOrFail($id);
        
        // Verificar que no sea el último administrador
        $adminCount = Usuario::where('rol', 'admin')->count();
        if ($adminCount <= 1) {
            return redirect()->route('admin.usuarios.index')
                           ->with('error', 'No se puede remover el último administrador del sistema.');
        }
        
        // Verificar que no se esté intentando remover a sí mismo (opcional)
        $currentAdminId = session('admin_auth');
        if ($currentAdminId == $id) {
            return redirect()->route('admin.usuarios.index')
                           ->with('error', 'No puedes remover tus propios permisos de administrador.');
        }
        
        $usuario->rol = 'cliente';
        $usuario->save();
        
        return redirect()->route('admin.usuarios.index')
                       ->with('success', 'Permisos de administrador removidos correctamente.');
    }

    public function exportCsv(Request $request)
    {
        $query = Usuario::query();
        
        // Aplicar los mismos filtros que en adminIndex
        if ($request->filled('rol')) {
            $query->where('rol', $request->rol);
        }
        
        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function($q) use ($buscar) {
                $q->where('nombre', 'LIKE', '%' . $buscar . '%')
                  ->orWhere('apellidos', 'LIKE', '%' . $buscar . '%')
                  ->orWhere('correo', 'LIKE', '%' . $buscar . '%');
            });
        }
        
        $usuarios = $query->orderBy('nombre')->get();
        
        $filename = 'usuarios_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $callback = function() use ($usuarios) {
            $file = fopen('php://output', 'w');
            
            // Agregar BOM para UTF-8
            fwrite($file, "\xEF\xBB\xBF");
            
            // Encabezados
            fputcsv($file, [
                'ID Usuario',
                'Nombre',
                'Apellidos',
                'Nombre Completo',
                'Correo Electrónico',
                'Rol'
            ]);
            
            foreach ($usuarios as $usuario) {
                fputcsv($file, [
                    $usuario->id_usuario,
                    $usuario->nombre,
                    $usuario->apellidos,
                    $usuario->nombre . ' ' . $usuario->apellidos,
                    $usuario->correo,
                    ucfirst($usuario->rol)
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }

    public function adminDestroy($id)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->delete();
        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario dado de baja correctamente.');
    }
}
