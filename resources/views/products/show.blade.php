<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} | ShopHub</title>
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

    <main class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8">
        <a href="{{ route('products.index') }}"
           class="inline-flex items-center gap-2 text-sm font-medium text-indigo-400 transition hover:text-indigo-300">
            <span aria-hidden="true">←</span>
            {{ __('Back to products') }}
        </a>

        <article class="mt-6 overflow-hidden rounded-2xl border border-gray-800 bg-gray-950 shadow-xl">
            <div class="grid grid-cols-1 lg:grid-cols-2">

                {{-- Product image --}}
                <div class="flex min-h-80 items-center justify-center bg-gray-900 p-6 sm:p-10 lg:min-h-[520px]">
                    @if ($product->image)
                        <img
                            src="{{ $product->image }}"
                            alt="{{ $product->name }}"
                            class="max-h-[460px] w-full object-contain"
                        >
                    @else
                        <div class="flex flex-col items-center gap-4 text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 7a2 2 0 012-2h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V7z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 15l5-5 4 4 3-3 6 6M9 9h.01" />
                            </svg>
                            <span>{{ __('No image available') }}</span>
                        </div>
                    @endif
                </div>

                {{-- Product details --}}
                <div class="flex flex-col p-6 sm:p-10">
                    <div>
                        <span class="inline-block rounded-full bg-indigo-950 px-3 py-1 text-sm font-semibold text-indigo-300">
                            {{ $product->category->name }}
                        </span>

                        <h1 class="mt-5 text-3xl font-bold tracking-tight sm:text-4xl">
                            {{ $product->name }}
                        </h1>

                        <div class="mt-6">
                            <p class="text-sm font-medium text-gray-400">{{ __('Price') }}</p>
                            <p class="mt-1 text-3xl font-bold text-white">
                                ${{ number_format((float) $product->price, 2) }}
                            </p>

                            @if ($exchangeRate !== null)
                                <p class="mt-1 text-lg text-gray-400">
                                    ≈ ₴{{ number_format((float) $product->price * $exchangeRate, 2) }}
                                </p>
                            @endif
                        </div>

                        <div class="mt-6 flex items-center gap-3">
                            <span class="text-sm font-medium text-gray-400">{{ __('Stock') }}:</span>
                            <span class="text-sm font-semibold {{ $product->stock > 0 ? 'text-green-400' : 'text-red-400' }}">
                                {{ $product->stock }}
                            </span>
                        </div>

                        <div class="mt-8 border-t border-gray-800 pt-6">
                            <h2 class="text-lg font-semibold">{{ __('Description') }}</h2>
                            <p class="mt-2 whitespace-pre-line leading-7 text-gray-400">
                                {{ $product->description ?: '—' }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-8 border-t border-gray-800 pt-6">
                        @if ($product->is_active && $product->stock > 0)
                            @auth
                                <form method="POST" action="{{ route('cart.add', $product) }}" class="flex flex-col gap-4 sm:flex-row sm:items-end">
                                    @csrf

                                    <div>
                                        <label for="quantity" class="mb-2 block text-sm font-medium text-gray-300">
                                            {{ __('Quantity') }}
                                        </label>

                                        <input
                                            type="number"
                                            id="quantity"
                                            name="quantity"
                                            value="{{ old('quantity', 1) }}"
                                            min="1"
                                            max="{{ $product->stock }}"
                                            required
                                            class="w-28 rounded-lg border border-gray-700 bg-gray-900 px-3 py-2.5 text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        >
                                    </div>

                                    <button type="submit"
                                        class="rounded-lg bg-indigo-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-indigo-500">
                                        {{ __('Add to Cart') }}
                                    </button>
                                </form>

                                @error('quantity')
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            @else
                                <p class="leading-7 text-gray-400">
                                    <a href="{{ route('login') }}" class="font-semibold text-indigo-400 hover:text-indigo-300">
                                        {{ __('Log in') }}
                                    </a>
                                    {{ __('to add this product to your cart.') }}
                                </p>
                            @endauth
                        @else
                            <p class="rounded-lg border border-red-900 bg-red-950 px-4 py-3 text-sm font-medium text-red-300">
                                {{ __('Out of stock.') }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </article>
    </main>

    <footer class="mt-16 border-t border-gray-800 bg-gray-950">
        <div class="mx-auto max-w-7xl px-4 py-6 text-sm text-gray-500 sm:px-6 lg:px-8">
            ShopHub
        </div>
    </footer>
</body>
</html>