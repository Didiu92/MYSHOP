<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ProductImageWithPlaceholderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener todos los productos que no tienen imágenes
        $products = Product::whereDoesntHave('images')->limit(10)->get();

        foreach ($products as $product) {
            // Crear 3 imágenes placeholder para cada producto
            for ($i = 1; $i <= 3; $i++) {
                $imagePath = "products/{$product->id}-image-{$i}.jpg";
                
                // Descargar una imagen placeholder
                $imageUrl = "https://picsum.photos/400/300?random=" . rand(1, 10000);
                $imageContent = @file_get_contents($imageUrl);
                
                if ($imageContent) {
                    // Guardar la imagen en el almacenamiento
                    Storage::disk('public')->put($imagePath, $imageContent);
                    
                    // Crear el registro en la base de datos
                    ProductImage::create([
                        'product_id' => $product->id,
                        'path' => $imagePath,
                        'order' => $i - 1,
                    ]);
                    
                    echo "Imagen creada: {$imagePath}\n";
                }
            }
        }
    }
}
