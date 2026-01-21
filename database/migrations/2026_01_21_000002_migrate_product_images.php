<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Migrar imágenes existentes del campo 'image' a la tabla 'product_images'
        $products = DB::table('products')->whereNotNull('image')->get();
        
        foreach ($products as $product) {
            DB::table('product_images')->insert([
                'product_id' => $product->id,
                'path' => $product->image,
                'order' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Opcional: Borrar las imágenes migradas
        DB::table('product_images')->delete();
    }
};
