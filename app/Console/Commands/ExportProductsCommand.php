<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;

class ExportProductsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export products with images to a file for version control';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('🔄 Exporting products with images...');

        $products = Product::with('images')->get();
        
        $export = [];
        
        foreach ($products as $product) {
            $export[] = [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'category_id' => $product->category_id,
                'offer_id' => $product->offer_id,
                'images' => $product->images->map(function ($image) {
                    return [
                        'path' => $image->path,
                        'order' => $image->order,
                    ];
                })->toArray(),
            ];
        }

        $filePath = database_path('data/products-export.php');
        
        $content = "<?php\nreturn " . var_export($export, true) . ";";
        
        file_put_contents($filePath, $content);

        $this->info("✅ Exported " . count($export) . " products to " . $filePath);
        
        return Command::SUCCESS;
    }
}
