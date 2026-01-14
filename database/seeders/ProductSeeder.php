<?php
namespace Database\Seeders;
use App\Models\Product;
use App\Traits\LoadsMockData;
use Illuminate\Database\Seeder;
class ProductSeeder extends Seeder
{
 use LoadsMockData;
 /**
 * Run the database seeds.
 */
 public function run(): void
 {
 $products = $this->getProducts();
 foreach ($products as $product) {
 Product::create($product);
 }
 }
}