<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    /**
     * Mostrar el formulario de login
     */
    public function index()
    {
        // Si el usuario ya está autenticado, redirigir según su rol
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }
        
        return view('auth.login');
    }

    /**
     * Registrar un nuevo usuario
     */
    public function registro(Request $request)
    {
        try {
            // Validar los datos del formulario
            $request->validate([
                'name' => 'required|string|max:255|min:2',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'rol_id' => 'required|in:1,2,3', // Validar que el rol sea válido
            ], [
                'name.required' => 'El nombre es obligatorio.',
                'name.min' => 'El nombre debe tener al menos 2 caracteres.',
                'name.max' => 'El nombre no puede exceder los 255 caracteres.',
                'email.required' => 'El email es obligatorio.',
                'email.email' => 'Debes ingresar un email válido.',
                'email.unique' => 'Este email ya está registrado en nuestro sistema.',
                'password.required' => 'La contraseña es obligatoria.',
                'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
                'password.confirmed' => 'Las contraseñas no coinciden.',
                'rol_id.required' => 'El rol es obligatorio.',
                'rol_id.in' => 'El rol seleccionado no es válido.',
            ]);

            // Crear el nuevo usuario
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->rol_id = $request->rol_id; // Asignar el rol
            $user->save();

            // Log del registro exitoso
            Log::info('Nuevo usuario registrado', [
                'user_id' => $user->id,
                'email' => $user->email,
                'rol_id' => $user->rol_id,
                'ip' => $request->ip()
            ]);

            // Autenticar automáticamente al usuario
            Auth::login($user);
            
            // Regenerar la sesión
            $request->session()->regenerate();

            // Redirigir según el rol del usuario
            return $this->redirectBasedOnRole($user)->with('success', '¡Registro exitoso! Bienvenido ' . $user->name);

        } catch (ValidationException $e) {
            // Regresar con errores de validación
            return back()->withErrors($e->errors())->withInput($request->except('password', 'password_confirmation'));
        } catch (\Exception $e) {
            // Log del error
            Log::error('Error en registro de usuario', [
                'error' => $e->getMessage(),
                'email' => $request->email,
                'ip' => $request->ip()
            ]);

            return back()->with('error', 'Ocurrió un error durante el registro. Por favor, inténtalo de nuevo.')->withInput($request->except('password', 'password_confirmation'));
        }
    }

    /**
     * Autenticar usuario
     */
    public function login(Request $request)
    {
        try {
            // Validar las credenciales
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ], [
                'email.required' => 'El email es obligatorio.',
                'email.email' => 'Debes ingresar un email válido.',
                'password.required' => 'La contraseña es obligatoria.',
            ]);

            // Verificar si el usuario existe
            $user = User::where('email', $credentials['email'])->first();
            
            if (!$user) {
                // Log del intento fallido
                Log::warning('Intento de login con email inexistente', [
                    'email' => $credentials['email'],
                    'ip' => $request->ip()
                ]);

                return back()->withErrors([
                    'email' => 'No existe una cuenta con este email.'
                ])->withInput($request->only('email'));
            }

            // Intentar autenticar al usuario
            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                if ($user->rol_id == 1) {
                    return redirect()->route('admin');
                } elseif ($user->rol_id == 2) {
                    return redirect()->route('home');
                }elseif ($user->rol_id == 2) {
                    return redirect()->route('home');
                } elseif ($user->rol_id == 3) {
                    return redirect()->route('homeConcejal');
                } elseif ($user->rol_id == 4) {
                    return redirect()->route('homeLider');
                }
                // Otros roles si los tienes
            }

            // Si las credenciales son incorrectas
            Log::warning('Intento de login con contraseña incorrecta', [
                'email' => $credentials['email'],
                'ip' => $request->ip()
            ]);

            return back()->withErrors([
                'password' => 'La contraseña es incorrecta.'
            ])->withInput($request->only('email'));

        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput($request->only('email'));
        } catch (\Exception $e) {
            // Log del error
            Log::error('Error en proceso de login', [
                'error' => $e->getMessage(),
                'email' => $request->email ?? 'N/A',
                'ip' => $request->ip()
            ]);

            return back()->with('error', 'Ocurrió un error durante el login. Por favor, inténtalo de nuevo.')->withInput($request->only('email'));
        }
    }

    /**
     * Redirigir según el rol del usuario
     */
    private function redirectBasedOnRole($user)
    {
        switch ($user->rol_id) {
            case 1:
                return redirect()->route('admin');
            case 2:
                return redirect()->route('home');
            case 3:
                return redirect()->route('homeConcejal');
            case 4:
                return redirect()->route('homeLider');
            default:
                // Si el rol no es válido, cerrar sesión y redirigir al login
                Auth::logout();
                return redirect()->route('login')->with('error', 'Rol de usuario no válido. Contacta al administrador.');
        }
    }

    /**
     * Cerrar sesión del usuario
     */
    public function logout(Request $request)
    {
        // Verificar que el usuario esté autenticado antes de hacer logout
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Log del logout
        Log::info('Usuario cerró sesión', [
            'user_id' => Auth::id(),
            'email' => Auth::user()->email,
            'ip' => $request->ip()
        ]);

        // Cerrar sesión
        Auth::logout();
        
        // Invalidar la sesión y regenerar el token CSRF
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Has cerrado sesión correctamente.');
    }

    /**
     * Mostrar la página de administración
     */
    public function admin()
    {
        // Esta verificación es redundante si usas middleware, pero es buena práctica
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para acceder a esta página.');
        }

        $user = Auth::user();
        return view('admin.admin', compact('user'));
    }

    /**
     * Mostrar la lista de usuarios
     */
    public function users()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para acceder a esta página.');
        }

        $users = User::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Mostrar el dashboard
     */
    public function dashboard()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para acceder a esta página.');
        }

        $user = Auth::user();
        $totalUsers = User::count();
        return view('admin.dashboard', compact('user', 'totalUsers'));
    }

    /**
     * Verificar si un email ya existe (para AJAX)
     */
    public function checkEmail(Request $request)
    {
        $email = $request->input('email');
        $exists = User::where('email', $email)->exists();
        
        return response()->json(['exists' => $exists]);
    }
}