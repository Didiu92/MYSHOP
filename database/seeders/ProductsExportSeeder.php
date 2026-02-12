<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ProductsExportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $exportFile = database_path('data/products-export.php');
        
        // Si no existe el archivo exportado, usa mock-products.php como fallback
        if (!file_exists($exportFile)) {
            $this->command->warn('⚠️  products-export.php not found. Using mock-products.php');
            $products = require database_path('data/mock-products.php');
            
            foreach ($products as $product) {
                Product::create($product);
            }
            return;
        }

        $products = require $exportFile;
        
        $this->command->info('🔄 Importing products with images...');

        ProductImage::truncate();
        
        foreach ($products as $productData) {
            $images = $productData['images'] ?? [];
            unset($productData['images']);
            
            // Crear o actualizar producto
            $product = Product::updateOrCreate(
                ['id' => $productData['id']],
                $productData
            );
            
            // Asignar imágenes
            if (!empty($images)) {
                foreach ($images as $image) {
                    ProductImage::create([
                        'product_id' => $product->id,
                        'path' => $image['path'],
                        'order' => $image['order'],
                    ]);
                }
            }
        }

        $this->command->info("✅ Imported " . count($products) . " products with images");
    }
}
