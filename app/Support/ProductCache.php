<?php

namespace App\Support;

use Illuminate\Support\Facades\Cache;

class ProductCache
{
    public static function clear(): void
    {
        Cache::forget('products.all');
        Cache::forget('categories.all');
    }
}