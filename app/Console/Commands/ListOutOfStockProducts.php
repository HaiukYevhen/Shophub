<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;

class ListOutOfStockProducts extends Command
{
    protected $signature = 'products:out-of-stock';

    protected $description = 'List products that are out of stock';

    public function handle(): int
    {
        $products = Product::where('stock', 0)
            ->orderBy('name')
            ->get();

        if ($products->isEmpty()) {
            $this->info('There are no out-of-stock products.');

            return self::SUCCESS;
        }

        $this->table(
            ['ID', 'Name', 'SKU/Slug', 'Stock'],
            $products->map(fn ($product) => [
                $product->id,
                $product->name,
                $product->slug,
                $product->stock,
            ])->toArray()
        );

        $this->info('Found ' . $products->count() . ' out-of-stock product(s).');

        return self::SUCCESS;
    }
}
