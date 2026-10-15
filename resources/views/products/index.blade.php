<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Products') }} | ShopHub</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-black text-gray-100 antialiased">
    <header class="border-b border-gray-800 bg-gray-950">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-5 sm:px-6 lg:px-8">
            <a href="{{ route('products.index') }}" class="text-2xl font-bold tracking-tight text-indigo-400">
                ShopHub
            </a>

            <nav class="flex items-center gap-3 text-sm font-medium sm:gap-5">
                @auth
                    <a href="{{ route('cart.index') }}" class="text-gray-300 transition hover:text-indigo-400">
                        {{ __('Cart') }}
                    </a>
                    <a href="{{ route('dashboard') }}" class="text-gray-300 transition hover:text-indigo-400">
                        {{ __('Dashboard') }}
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-gray-300 transition hover:text-indigo-400">
                        {{ __('Log in') }}
                    </a>
                    <a href="{{ route('register') }}" class="rounded-lg bg-indigo-600 px-4 py-2 text-white transition hover:bg-indigo-500">
                        {{ __('Register') }}
                    </a>
                @endauth
            </nav>
        </div>
    </header>

    <main class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold tracking-tight sm:text-4xl">
                {{ __('Products') }}
            </h1>
            <p class="mt-2 text-gray-400">
                {{ __('Find the products you need.') }}
            </p>
        </div>

        {{-- Search and filters --}}
        <section class="mb-8 rounded-2xl border border-gray-800 bg-gray-950 p-5 shadow-lg sm:p-6">
            <form method="GET" action="{{ route('products.index') }}" class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <div class="sm:col-span-2">
                    <label for="search" class="mb-1 block text-sm font-medium text-gray-300">
                        {{ __('Search') }}
                    </label>
                    <input
                        type="text"
                        id="search"
                        name="search"
                        value="{{ $search }}"
                        placeholder="{{ __('Search products...') }}"
                        class="w-full rounded-lg border border-gray-700 bg-gray-900 text-gray-100 placeholder-gray-500 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    >
                </div>

                <div>
                    <label for="min_price" class="mb-1 block text-sm font-medium text-gray-300">
                        {{ __('Minimum Price') }}
                    </label>
                    <input
                        type="number"
                        id="min_price"
                        name="min_price"
                        min="0"
                        step="0.01"
                        value="{{ $minPrice }}"
                        class="w-full rounded-lg border border-gray-700 bg-gray-900 text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    >
                </div>

                <div>
                    <label for="max_price" class="mb-1 block text-sm font-medium text-gray-300">
                        {{ __('Maximum Price') }}
                    </label>
                    <input
                        type="number"
                        id="max_price"
                        name="max_price"
                        min="0"
                        step="0.01"
                        value="{{ $maxPrice }}"
                        class="w-full rounded-lg border border-gray-700 bg-gray-900 text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    >
                </div>

                @if (request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif

                <div class="flex flex-wrap items-center gap-3 sm:col-span-2 lg:col-span-4">
                    <button type="submit" class="rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500">
                        {{ __('Apply Filters') }}
                    </button>
                    <a href="{{ route('products.index') }}" class="rounded-lg border border-gray-700 px-5 py-2.5 text-sm font-semibold text-gray-300 transition hover:bg-gray-800">
                        {{ __('Reset') }}
                    </a>
                </div>
            </form>
        </section>

        {{-- Categories --}}
        <section class="mb-8">
            <h2 class="mb-3 text-lg font-semibold">{{ __('Categories') }}</h2>

            <div class="flex flex-wrap gap-2">
                <a
                    href="{{ route('products.index', request()->except('category')) }}"
                    class="rounded-full border px-4 py-2 text-sm font-medium transition {{ !request('category') ? 'border-indigo-500 bg-indigo-600 text-white' : 'border-gray-700 bg-gray-950 text-gray-300 hover:border-indigo-500' }}"
                >
                    {{ __('All Categories') }}
                </a>

                @foreach ($categories as $category)
                    <a
                        href="{{ route('products.index', array_merge(request()->except('category', 'page'), ['category' => $category->slug])) }}"
                        class="rounded-full border px-4 py-2 text-sm font-medium transition {{ request('category') === $category->slug ? 'border-indigo-500 bg-indigo-600 text-white' : 'border-gray-700 bg-gray-950 text-gray-300 hover:border-indigo-500' }}"
                    >
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>
        </section>

        @if ($products->isEmpty())
            <div class="rounded-2xl border border-dashed border-gray-700 bg-gray-950 px-6 py-16 text-center">
                <h2 class="text-lg font-semibold">{{ __('No products found.') }}</h2>
                <a href="{{ route('products.index') }}" class="mt-3 inline-block font-medium text-indigo-400 hover:text-indigo-300">
                    {{ __('Reset') }}
                </a>
            </div>
        @else
            <section class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($products as $product)
                    <article class="flex flex-col overflow-hidden rounded-2xl border border-gray-800 bg-gray-950 shadow-lg transition duration-200 hover:-translate-y-1 hover:border-indigo-500/60 hover:shadow-indigo-950/40">

                        {{-- Product image --}}
                        <a href="{{ route('products.show', $product->slug) }}"
                           class="flex h-64 items-center justify-center overflow-hidden bg-gray-900 p-5">
                            @if ($product->image)
                                <img
                                    src="{{ $product->image }}"
                                    alt="{{ $product->name }}"
                                    loading="lazy"
                                    class="h-full w-full object-contain transition duration-300 hover:scale-105"
                                >
                            @else
                                <div class="flex flex-col items-center gap-3 text-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 7a2 2 0 012-2h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V7z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 15l5-5 4 4 3-3 6 6M9 9h.01" />
                                    </svg>
                                    <span class="text-sm">{{ __('No image available') }}</span>
                                </div>
                            @endif
                        </a>

                        <div class="flex flex-1 flex-col p-5 sm:p-6">
                            <div class="mb-4 flex items-start justify-between gap-3">
                                <span class="rounded-full bg-indigo-950 px-3 py-1 text-xs font-semibold text-indigo-300">
                                    {{ $product->category->name }}
                                </span>

                                @if ($product->stock > 0)
                                    <span class="text-xs font-medium text-green-400">
                                        {{ __('In Stock') }}
                                    </span>
                                @else
                                    <span class="text-xs font-medium text-red-400">
                                        {{ __('Out of stock.') }}
                                    </span>
                                @endif
                            </div>

                            <h2 class="text-xl font-semibold">
                                <a href="{{ route('products.show', $product->slug) }}" class="transition hover:text-indigo-400">
                                    {{ $product->name }}
                                </a>
                            </h2>

                            @if (!empty($product->description))
                                <p class="mt-2 line-clamp-3 text-sm leading-6 text-gray-400">
                                    {{ $product->description }}
                                </p>
                            @endif

                            <div class="mt-auto pt-6">
                                <p class="text-2xl font-bold text-white">
                                    ${{ number_format((float) $product->price, 2) }}
                                </p>

                                @if ($exchangeRate !== null)
                                    <p class="mt-1 text-sm text-gray-400">
                                        ≈ ₴{{ number_format((float) $product->price * $exchangeRate, 2) }}
                                    </p>
                                @endif

                                <p class="mt-2 text-sm text-gray-500">
                                    {{ __('Stock') }}: {{ $product->stock }}
                                </p>

                                <a href="{{ route('products.show', $product->slug) }}"
                                   class="mt-5 block rounded-lg bg-indigo-600 px-4 py-2.5 text-center text-sm font-semibold text-white transition hover:bg-indigo-500">
                                    {{ __('View Details') }}
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </section>
            
            @if ($products->hasPages())
                <div class="mt-8 flex justify-center">
                    {{ $products->links() }}
                </div>
            @endif
        @endif
    </main>

    <footer class="mt-16 border-t border-gray-800 bg-gray-950">
        <div class="mx-auto max-w-7xl px-4 py-6 text-sm text-gray-500 sm:px-6 lg:px-8">
            ShopHub
        </div>
    </footer>
</body>
</html>