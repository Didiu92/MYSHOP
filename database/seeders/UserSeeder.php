<?php
namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Seeder;
class UserSeeder extends Seeder
{
 /**
 * Run the database seeds.
 */
 public function run(): void
 {
 // Crear un usuario específico con datos conocidos
 User::factory()->create([
 'name' => 'Usuario Demo',
 'email' => 'demo@example.com',
 ]);
 // Crear usuarios adicionales con datos aleatorios
 User::factory(2)->create();
 }
}

