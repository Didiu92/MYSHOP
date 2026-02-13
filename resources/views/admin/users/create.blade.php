<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gold leading-tight">Crear usuario</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-900 shadow sm:rounded-lg p-6">
                @if ($errors->any())
                    <div class="mb-6 rounded-lg border border-red-400/40 bg-red-950/40 px-4 py-3 text-sm text-red-300">
                        <p class="font-semibold">Revisa el formulario:</p>
                        <ul class="mt-2 list-disc space-y-1 pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form
                    x-data="userForm({
                        name: $el.dataset.name || '',
                        email: $el.dataset.email || '',
                        role: $el.dataset.role || '',
                        userId: $el.dataset.userId || '',
                        emailCheckUrl: $el.dataset.emailCheckUrl || '',
                    })"
                    x-on:submit.prevent="if (validateAll()) $el.submit()"
                    action="{{ route('admin.users.store') }}"
                    method="POST"
                    class="space-y-6"
                    autocomplete="off"
                    data-name="{{ old('name', '') }}"
                    data-email="{{ old('email', '') }}"
                    data-role="{{ old('role', '') }}"
                    data-user-id=""
                    data-email-check-url="{{ route('admin.users.check-email') }}"
                >
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gold">Nombre</label>
                        <input
                            type="text"
                            name="name"
                            class="mt-1 input"
                            required
                            x-model="form.name"
                            x-on:blur="touched.name = true; validateField('name')"
                            x-on:input="touched.name = true; validateField('name')"
                            autocomplete="off"
                        >
                        <p x-show="touched.name && errors.name" x-text="errors.name" class="mt-2 text-sm text-red-400"></p>
                        @error('name')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gold">Email</label>
                        <input
                            type="email"
                            name="email"
                            class="mt-1 input"
                            required
                            x-model="form.email"
                            x-on:blur="touched.email = true; validateField('email')"
                            x-on:input="touched.email = true; validateField('email')"
                            autocomplete="off"
                            autocapitalize="none"
                            spellcheck="false"
                        >
                        <p x-show="touched.email && errors.email" x-text="errors.email" class="mt-2 text-sm text-red-400"></p>
                        @error('email')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gold">Contraseña</label>
                        <input
                            type="password"
                            name="password"
                            class="mt-1 input"
                            required
                            minlength="8"
                            x-model="form.password"
                            x-on:blur="touched.password = true; validateField('password')"
                            x-on:input="touched.password = true; validateField('password')"
                            autocomplete="new-password"
                        >
                        <p x-show="touched.password && errors.password" x-text="errors.password" class="mt-2 text-sm text-red-400"></p>
                        @error('password')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gold">Confirmar contraseña</label>
                        <input
                            type="password"
                            name="password_confirmation"
                            class="mt-1 input"
                            required
                            x-model="form.password_confirmation"
                            x-on:blur="touched.password_confirmation = true; validateField('password_confirmation')"
                            x-on:input="touched.password_confirmation = true; validateField('password_confirmation')"
                            autocomplete="new-password"
                        >
                        <p x-show="touched.password_confirmation && errors.password_confirmation" x-text="errors.password_confirmation" class="mt-2 text-sm text-red-400"></p>
                        @error('password_confirmation')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gold">Rol</label>
                        <select
                            name="role"
                            class="mt-1 input"
                            required
                            x-model="form.role"
                            x-on:blur="touched.role = true; validateField('role')"
                            x-on:change="validateField('role')"
                        >
                            <option value="" disabled {{ old('role') ? '' : 'selected' }}>Selecciona un rol</option>
                            <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="worker" {{ old('role') === 'worker' ? 'selected' : '' }}>Trabajador (invitado)</option>
                            <option value="guest" {{ old('role') === 'guest' ? 'selected' : '' }}>Guest</option>
                        </select>
                        <p x-show="touched.role && errors.role" x-text="errors.role" class="mt-2 text-sm text-red-400"></p>
                        @error('role')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex justify-end gap-3">
                        <a href="{{ route('admin.users.index') }}" class="text-silver">Cancelar</a>
                        <button type="submit" class="btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
