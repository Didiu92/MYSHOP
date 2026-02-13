<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Listado de usuarios.
     */
    public function index(Request $request): View
    {
        $query = User::query();
        
        // Búsqueda por nombre, email o rol
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('role', 'like', "%{$search}%");
            });
        }
        
        $users = $query->latest()->get();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Formulario de creación.
     */
    public function create(): View
    {
        return view('admin.users.create');
    }

    /**
     * Check if an email is available.
     */
    public function checkEmail(Request $request): JsonResponse
    {
        $email = trim((string) $request->input('email', ''));
        if ($email === '') {
            return response()->json([
                'available' => false,
                'message' => 'El correo electronico es obligatorio.',
            ], 200);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return response()->json([
                'available' => false,
                'message' => 'El correo electronico no es valido.',
            ], 200);
        }

        $query = User::query()->where('email', $email);
        if ($request->filled('user_id')) {
            $query->where('id', '!=', (int) $request->input('user_id'));
        }

        $exists = $query->exists();

        return response()->json([
            'available' => !$exists,
            'message' => $exists ? 'El correo electronico ya esta en uso.' : '',
        ]);
    }

    /**
     * Guardar usuario.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,worker,guest',
        ]);

        $data['password'] = Hash::make($data['password']);

        User::create($data);

        return redirect()->route('admin.users.index')->with('success', 'Usuario creado correctamente');
    }

    /**
     * Formulario de edición.
     */
    public function edit(User $user): View
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Actualizar usuario.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin,worker,guest',
        ]);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Usuario actualizado correctamente');
    }

    /**
     * Eliminar usuario.
     */
    public function destroy(User $user): RedirectResponse
    {
        // Evitar que el admin se elimine a sí mismo
        if (auth()->id() === $user->id) {
            return back()->with('error', 'No puedes eliminar tu propio usuario.');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Usuario eliminado');
    }
}
