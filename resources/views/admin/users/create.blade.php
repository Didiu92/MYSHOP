<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Crear usuario</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">
                <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nombre</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="mt-1 input" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="mt-1 input" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Contraseña</label>
                        <input type="password" name="password" class="mt-1 input" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Confirmar contraseña</label>
                        <input type="password" name="password_confirmation" class="mt-1 input" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Rol</label>
                        <select name="role" class="mt-1 input" required>
                            <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="guest" {{ old('role') === 'guest' ? 'selected' : '' }}>Guest</option>
                        </select>
                    </div>
                    <div class="flex justify-end gap-3">
                        <a href="{{ route('admin.users.index') }}" class="text-gray-600">Cancelar</a>
                        <button type="submit" class="btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
