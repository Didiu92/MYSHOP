<?php

namespace Database\Seeders;

use App\Models\ProductImage;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ProductImageFromLocalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Mapeo exacto según imagen real → producto
     * Busca cada producto por nombre y asigna las imágenes correpondientes
     */
    public function run(): void
    {
        // Mapeo de nombre de producto => lista de imágenes (en orden)
        $productImageMap = [
            'Colgante plata calavera y oro' => [
                'Colganteplatacalaverayoro_1024x1024.webp',
                'colgante-calavera1_1024x1024.webp',
                'Colganteplatacalaverayorohombre2_1024x1024.webp',
            ],
            'Anillo Crossed' => [
                'ANI0732MTL000_mod1_1024x1024.webp',
                'ANI0732MTL0009_1_1024x1024.webp',
            ],
            'Collar Superfly' => [
                'COL1857MCLMTL_1_1024x1024.webp',
                'COL1857MCLMTL_1_mod_1024x1024.webp',
                'COL1857MCLMTL_2_1024x1024.webp',
                'COL1857MCLMTL_2_mod_1024x1024.webp',
            ],
            'Pulsera Silver Key' => [
                'PUL2305MTL000_1_1024x1024.webp',
                'PUL2305MTL000_3_1024x1024.webp',
            ],
            'Pendientes triángulo' => [
                'pendientes-de-plata-y-oro_83d4de80-33dc-4dc8-b21a-b014ca19d9d9_1024x1024.webp',
            ],
            'Colgante Cupido' => [
                'COL1884MTL000_1_1024x1024.webp',
                'COL1884MTL000_3_1024x1024.webp',
                'COL1884MTL000_mod1_1024x1024.webp',
                'COL1884MTL000_mod2_1024x1024.jpg',
            ],
            'Anillo oro rosa 18kt con brillante negro' => [
                'GA014ORBL_1024x1024.webp',
            ],
            'Pulsera Ser Natural' => [
                'PUL2458MARMTL_2_1024x1024.webp',
                'PUL2458MARMTL_2_mod_1024x1024.webp',
                'PUL2458MARMTL_3_1024x1024.webp',
            ],
            'Pulsera amatistas' => [
                'PUL0227MAR_1_1024x1024.webp',
                'PUL0227MAR_1_mod_1024x1024.webp',
                'PUL0227MAR_2_1024x1024.webp',
                'PUL0227MAR_3_1024x1024.webp',
            ],
            'Pendientes perla botón' => [
                'delcerro_SOFIA_dormilonas_42_v_600x_1a8e05ed-947c-4bd7-9724-3b7586bf4a1b_1024x1024.webp',
                'F5C577F3-7133-4911-94AB-BB46D2F9E05A_600x_b496be47-0246-49d4-b69f-4f654853d7f1_1024x1024.webp',
            ],
            'Anillo solitario moissanita' => [
                'ANI0700MTL000_1_1024x1024.webp',
                'ANI0700MTL000_2_1024x1024.webp',
                'ANI0700MTL000_mod1_1024x1024.webp',
            ],
            'Alianza titanio cepillado' => [
                'ANI0711GRSMTL_2_1024x1024.webp',
                'ANI0711GRSMTL_mod1_1024x1024.webp',
            ],
            'Pendientes aro minimal' => [
                'PEN0970MTL000_1_1024x1024.webp',
                'PEN0970MTL000_2_mod_1024x1024.webp',
            ],
            'Alianza oro blanco mate' => [
                'COL1844BPLMTL_1_mod_1024x1024.webp',
                'COL1844BPLMTL_2_1024x1024.webp',
                'COL1844BPLMTL_2_mod_1024x1024.webp',
                'COL1844BPLMTL_3_1024x1024.webp',
            ],
            'Anillo media alianza zafiro' => [
                'ani0639mtl000_1_3_1024x1024.webp',
                'ani0639mtl000_2_3_1024x1024.webp',
                'ANI0639MTL000_mod1_1024x1024.webp',
            ],
            'Pendientes topacio azul' => [
                'pen0055mtl000_4_mod_1_1024x1024.webp',
                'unode50-14_1024x1024.webp',
            ],
            'Pendientes amatista gota' => [
                'Pendiente-tu-orbitas_1024x1024.webp',
                'pen0433mtl000_1_mod_1_1024x1024.webp',
                'PEN0433MTL000_2_1024x1024.webp',
                'PEN0433MTL000_mod2_1024x1024.webp',
            ],
        ];

        ProductImage::truncate();

        $totalInserted = 0;
        $this->command->info("🎯 Iniciando mapeo de imágenes por producto...");

        // Asignar imágenes por producto
        foreach ($productImageMap as $productName => $images) {
            $product = Product::where('name', $productName)->first();
            
            if (!$product) {
                $this->command->warn("⚠️  Producto no encontrado: $productName");
                continue;
            }

            foreach ($images as $order => $imagePath) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'path' => 'products/' . $imagePath,
                    'order' => $order,
                ]);
                $totalInserted++;
            }
        }

        $this->command->info("✅ Se insertaron $totalInserted registros en product_images");
    }
}
