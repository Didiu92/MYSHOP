<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gold leading-tight">Editar usuario</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-900 shadow sm:rounded-lg p-6">
                <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-sm font-medium text-gold">Nombre</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="mt-1 input" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gold">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" class="mt-1 input" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gold">Contraseña (dejar en blanco para mantener)</label>
                        <input type="password" name="password" class="mt-1 input">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gold">Confirmar contraseña</label>
                        <input type="password" name="password_confirmation" class="mt-1 input">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gold">Rol</label>
                        <select name="role" class="mt-1 input" required>
                            <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="worker" {{ old('role', $user->role) === 'worker' ? 'selected' : '' }}>Trabajador (invitado)</option>
                            <option value="guest" {{ old('role', $user->role) === 'guest' ? 'selected' : '' }}>Guest</option>
                        </select>
                    </div>
                    <div class="flex justify-end gap-3">
                        <a href="{{ route('admin.users.index') }}" class="text-silver">Cancelar</a>
                        <button type="submit" class="btn-primary">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
