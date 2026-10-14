<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
   public function index()
    {
        $category = request('category');

        $cachedProducts = Cache::remember(
            'products.all',
            now()->addMinutes(10),
            function () {
                return Product::where('is_active', true)
                    ->with('category')
                    ->get()
                    ->toArray();
            }
        );

        $products = collect($cachedProducts)
            ->filter(function ($product) use ($category) {
                return !$category ||
                    ($product['category']['slug'] ?? null) === $category;
            })
            ->map(function ($product) {
                $product = (object) $product;

                if (is_array($product->category ?? null)) {
                    $product->category = (object) $product->category;
                }

                return $product;
            })
            ->values();

        $cachedCategories = Cache::remember(
            'categories.all',
            now()->addMinutes(10),
            function () {
                return Category::orderBy('name')
                    ->get()
                    ->toArray();
            }
        );

        $categories = collect($cachedCategories)
            ->map(fn ($category) => (object) $category);

        return view('products.index', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }
}
