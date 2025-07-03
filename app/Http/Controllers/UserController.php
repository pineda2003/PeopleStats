<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Muestra el listado de usuarios con filtros.
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Búsqueda por nombre o email
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        // Filtro por estado
        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }

        // Filtro por rol
        if ($request->filled('role')) {
            $query->where('role', $request->get('role'));
        }

        // Ordenar por fecha de creación
        $users = $query->orderBy('created_at', 'desc')->paginate(10);

        // 👇 Vista corregida
        return view('admin.admin', compact('users'));
    }

    /**
     * Guarda un nuevo usuario.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:admin,moderator,user',
            'status' => 'required|string|in:active,inactive,pending',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.admin')->with('success', 'Usuario creado exitosamente');
    }

    /**
     * Actualiza un usuario existente.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role' => 'required|string|in:admin,moderator,user',
            'status' => 'required|string|in:active,inactive,pending',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'status' => $request->status,
        ];

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $user->update($userData);

        return redirect()->route('admin.admin')->with('success', 'Usuario actualizado exitosamente');
    }

    /**
     * Elimina un usuario.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.admin')->with('success', 'Usuario eliminado exitosamente');
    }

    /**
     * Muestra los detalles de un usuario (en JSON).
     */
    public function show(User $user)
    {
        return response()->json($user);
    }
}
