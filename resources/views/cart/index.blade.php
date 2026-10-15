<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Cart') }} | ShopHub</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-50 text-gray-900 dark:bg-gray-950 dark:text-gray-100">
    <header class="border-b border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900">
        <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-5 sm:px-6 lg:px-8">
            <a href="{{ route('products.index') }}" class="text-2xl font-bold tracking-tight text-indigo-600 dark:text-indigo-400">
                ShopHub
            </a>

            <a href="{{ route('products.index') }}"
               class="rounded-lg px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-800">
                {{ __('Continue shopping') }}
            </a>
        </div>
    </header>

    <main class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold tracking-tight sm:text-4xl">
                {{ __('Your Cart') }}
            </h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">
                {{ __('Review your items before checkout.') }}
            </p>
        </div>

        @if (session('success'))
            <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800 dark:border-green-900 dark:bg-green-950 dark:text-green-300">
                {{ __(session('success')) }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800 dark:border-red-900 dark:bg-red-950 dark:text-red-300">
                {{ __(session('error')) }}
            </div>
        @endif

        @if ($cartItems->isEmpty())
            <div class="rounded-2xl border border-gray-200 bg-white px-6 py-16 text-center shadow-sm dark:border-gray-800 dark:bg-gray-900">
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-indigo-50 text-indigo-600 dark:bg-indigo-950 dark:text-indigo-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l2.4 11.2a2 2 0 002 1.6h7.9a2 2 0 002-1.6L21 7H6M10 21h.01M18 21h.01" />
                    </svg>
                </div>

                <h2 class="mt-5 text-xl font-semibold">
                    {{ __('Your cart is empty.') }}
                </h2>
                <p class="mt-2 text-gray-600 dark:text-gray-400">
                    {{ __('Browse our products and add something you like.') }}
                </p>

                <a href="{{ route('products.index') }}"
                   class="mt-6 inline-flex items-center rounded-lg bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500">
                    {{ __('Continue shopping') }}
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 items-start gap-8 lg:grid-cols-3">
                <section class="space-y-4 lg:col-span-2">
                    @foreach ($cartItems as $cartItem)
                        <article class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-gray-900 sm:p-6">
                            <div class="flex flex-col gap-5 sm:flex-row">
                                @if ($cartItem->product->image)
                                    <img
                                        src="{{ $cartItem->product->image }}"
                                        alt="{{ $cartItem->product->name }}"
                                        class="h-36 w-full rounded-xl bg-gray-100 object-contain dark:bg-gray-800 sm:w-36"
                                    >
                                @else
                                    <div class="flex h-36 w-full items-center justify-center rounded-xl bg-gray-100 text-sm text-gray-400 dark:bg-gray-800 sm:w-36">
                                        {{ __('No image available') }}
                                    </div>
                                @endif

                                <div class="min-w-0 flex-1">
                                    <h2 class="text-lg font-semibold">
                                        <a href="{{ route('products.show', $cartItem->product->slug) }}"
                                           class="transition hover:text-indigo-600 dark:hover:text-indigo-400">
                                            {{ $cartItem->product->name }}
                                        </a>
                                    </h2>

                                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                        {{ __('Price') }}:
                                        <span class="font-medium text-gray-900 dark:text-gray-100">
                                            ${{ number_format((float) $cartItem->product->price, 2) }}
                                        </span>
                                    </p>

                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                        {{ __('Quantity') }}: {{ $cartItem->quantity }}
                                    </p>

                                    <p class="mt-3 text-lg font-bold text-indigo-600 dark:text-indigo-400">
                                        ${{ number_format((float) $cartItem->product->price * $cartItem->quantity, 2) }}
                                    </p>

                                    <div class="mt-4 flex flex-wrap items-end gap-3">
                                        <form method="POST" action="{{ route('cart.update', $cartItem) }}" class="flex items-end gap-2">
                                            @csrf
                                            @method('PATCH')

                                            <div>
                                                <label for="quantity-{{ $cartItem->id }}" class="mb-1 block text-xs font-medium text-gray-600 dark:text-gray-400">
                                                    {{ __('Quantity') }}
                                                </label>
                                                <input
                                                    id="quantity-{{ $cartItem->id }}"
                                                    type="number"
                                                    name="quantity"
                                                    value="{{ $cartItem->quantity }}"
                                                    min="1"
                                                    max="{{ $cartItem->product->stock }}"
                                                    required
                                                    class="w-24 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 dark:focus:ring-indigo-900"
                                                >
                                            </div>

                                            <button type="submit"
                                                class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-semibold transition hover:bg-gray-100 dark:border-gray-700 dark:hover:bg-gray-800">
                                                {{ __('Update') }}
                                            </button>
                                        </form>

                                        <form method="POST" action="{{ route('cart.remove', $cartItem) }}">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                class="rounded-lg px-3 py-2 text-sm font-semibold text-red-600 transition hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-950">
                                                {{ __('Remove') }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </section>

                <aside class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                    <h2 class="text-lg font-semibold">
                        {{ __('Order Summary') }}
                    </h2>

                    <div class="mt-5 flex items-center justify-between border-b border-gray-200 pb-4 text-sm dark:border-gray-800">
                        <span class="text-gray-600 dark:text-gray-400">
                            {{ __('Items') }} ({{ $cartItems->sum('quantity') }})
                        </span>
                        <span class="font-medium">
                            ${{ number_format($cartItems->sum(fn ($item) => (float) $item->product->price * $item->quantity), 2) }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between py-4">
                        <span class="font-semibold">{{ __('Total') }}</span>
                        <span class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">
                            ${{ number_format($cartItems->sum(fn ($item) => (float) $item->product->price * $item->quantity), 2) }}
                        </span>
                    </div>

                    <a href="{{ route('orders.create') }}"
                       class="mt-2 flex w-full items-center justify-center rounded-lg bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500">
                        {{ __('Proceed to Checkout') }}
                    </a>

                    <a href="{{ route('products.index') }}"
                       class="mt-3 flex w-full items-center justify-center rounded-lg px-5 py-3 text-sm font-medium text-gray-700 transition hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-800">
                        {{ __('Continue shopping') }}
                    </a>
                </aside>
            </div>
        @endif
    </main>
</body>
</html>