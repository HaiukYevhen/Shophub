<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Services\ExchangeRateService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductController extends Controller
{
   public function index(ExchangeRateService $exchangeRateService)
    {
        $category = request('category');
        $search = trim(request('search', ''));
        $minPrice = request('min_price');
        $maxPrice = request('max_price');

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
            ->filter(function ($product) use ($category, $search, $minPrice, $maxPrice) {
                if ($category && ($product['category']['slug'] ?? null) !== $category) {
                    return false;
                }

                if ($search && !str_contains(
                    mb_strtolower($product['name']),
                    mb_strtolower($search)
                )) {
                    return false;
                }

                if ($minPrice !== null && $minPrice !== '' && $product['price'] < (float) $minPrice) {
                    return false;
                }

                if ($maxPrice !== null && $maxPrice !== '' && $product['price'] > (float) $maxPrice) {
                    return false;
                }

                return true;
            })
            ->map(function ($product) {
                $product = (object) $product;

                if (is_array($product->category ?? null)) {
                    $product->category = (object) $product->category;
                }

                return $product;
            })
            ->values();
        
        $perPage = 12;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        $products = new LengthAwarePaginator(
            $products->forPage($currentPage, $perPage)->values(),
            $products->count(),
            $perPage,
            $currentPage,
            [
                'path' => request()->url(),
                'query' => request()->query(),
            ]
        );    

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

        $exchangeRate = null;

        try {
            $exchangeRate = $exchangeRateService->getUsdToUahRate();
        } catch (\RuntimeException $exception) {
            // Keep the product catalog available if the API is unavailable.
        }

        return view('products.index', compact('products', 'categories', 'exchangeRate', 'search', 'minPrice', 'maxPrice'));
    }

    public function show(Product $product, ExchangeRateService $exchangeRateService)
    {
        $exchangeRate = null;

        try {
            $exchangeRate = $exchangeRateService->getUsdToUahRate();
        } catch (\RuntimeException $exception) {
            // Keep the product page available if the API is unavailable.
        }

        return view('products.show', compact('product', 'exchangeRate'));
    }
}
