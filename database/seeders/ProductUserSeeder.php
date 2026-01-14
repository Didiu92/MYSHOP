<?php
namespace Database\Seeders;
use App\Models\User;
use App\Traits\LoadsMockData;
use Illuminate\Database\Seeder;
class ProductUserSeeder extends Seeder
{
 use LoadsMockData;
 /**
 * Run the database seeds.
 */
 public function run(): void
 {
 $cartItems = $this->getCart();
 // Obtener el primer usuario
 $user = User::first();
 foreach ($cartItems as $item) {
 // Usar attach() para añadir productos al carrito del usuario
 $user->products()->attach($item['product_id'], [
 'quantity' => $item['quantity'],
 ]);
 }
 }
}
