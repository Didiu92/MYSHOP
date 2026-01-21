<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;

class ProductImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener todos los productos
        $products = Product::all();

        // Para cada producto, crear 3 imágenes de prueba
        foreach ($products as $product) {
            // Verificar si ya tiene imágenes
            if ($product->images()->count() === 0) {
                for ($i = 1; $i <= 3; $i++) {
                    ProductImage::create([
                        'product_id' => $product->id,
                        'path' => 'products/test-' . $product->id . '-' . $i . '.jpg',
                        'order' => $i - 1,
                    ]);
                }
            }
        }
    }
}
