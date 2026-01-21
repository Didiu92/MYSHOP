<?php
namespace Database\Seeders;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
class UserSeeder extends Seeder
{
 /**
 * Run the database seeds.
 */
 public function run(): void
 {
		// Usuario admin fijo para acceso conocido
		User::updateOrCreate(
			['email' => 'tu@email.com'],
			[
				'name' => 'Admin',
				'password' => Hash::make('password123'),
				'role' => 'admin',
			]
		);

		// Usuario demo fijo como trabajador invitado (lectura sin CRUD de usuarios)
		User::updateOrCreate(
			['email' => 'demo@example.com'],
			[
				'name' => 'Usuario Demo',
				'password' => Hash::make('password'),
				'role' => 'worker',
			]
		);

		// Cliente autenticado de prueba
		User::updateOrCreate(
			['email' => 'customer@myshop.com'],
			[
				'name' => 'Cliente',
				'password' => Hash::make('password123'),
				'role' => 'guest',
			]
		);
 // Crear usuarios adicionales con datos aleatorios
 User::factory(2)->create();
 }
}

