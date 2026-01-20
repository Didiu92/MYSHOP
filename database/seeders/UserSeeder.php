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
 ]
 );

		// Usuario demo fijo (evita duplicados si ya existe)
		User::updateOrCreate(
			['email' => 'demo@example.com'],
			[
				'name' => 'Usuario Demo',
				'password' => Hash::make('password'),
			]
		);
 // Crear usuarios adicionales con datos aleatorios
 User::factory(2)->create();
 }
}

