<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Checkout') }} | ShopHub</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-50 text-gray-900 dark:bg-gray-950 dark:text-gray-100">
    <header class="border-b border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900">
        <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-5 sm:px-6 lg:px-8">
            <a href="{{ route('products.index') }}" class="text-2xl font-bold tracking-tight text-indigo-600 dark:text-indigo-400">
                ShopHub
            </a>

            <a href="{{ route('cart.index') }}"
               class="rounded-lg px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-800">
                {{ __('Back to cart') }}
            </a>
        </div>
    </header>

    <main class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold tracking-tight sm:text-4xl">
                {{ __('Checkout') }}
            </h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">
                {{ __('Complete your details to place your order.') }}
            </p>
        </div>

        @if ($errors->any())
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-800 dark:border-red-900 dark:bg-red-950 dark:text-red-300">
                <p class="font-semibold">{{ __('Please correct the following errors:') }}</p>
                <ul class="mt-2 list-inside list-disc space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 items-start gap-8 lg:grid-cols-3">
            <section class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-gray-900 sm:p-6 lg:col-span-2">
                <h2 class="text-xl font-semibold">
                    {{ __('Customer Information') }}
                </h2>

                <form method="POST" action="{{ route('orders.store') }}" class="mt-6 space-y-5">
                    @csrf

                    <div>
                        <label for="customer_name" class="mb-2 block text-sm font-medium">
                            {{ __('Name') }}
                        </label>
                        <input
                            type="text"
                            id="customer_name"
                            name="customer_name"
                            value="{{ old('customer_name', auth()->user()->name) }}"
                            autocomplete="name"
                            required
                            class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 outline-none transition placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 dark:focus:ring-indigo-900"
                        >
                        @error('customer_name')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="customer_email" class="mb-2 block text-sm font-medium">
                            {{ __('Email') }}
                        </label>
                        <input
                            type="email"
                            id="customer_email"
                            name="customer_email"
                            value="{{ old('customer_email', auth()->user()->email) }}"
                            autocomplete="email"
                            required
                            class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 outline-none transition placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 dark:focus:ring-indigo-900"
                        >
                        @error('customer_email')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="shipping_address" class="mb-2 block text-sm font-medium">
                            {{ __('Shipping address') }}
                        </label>
                        <textarea
                            id="shipping_address"
                            name="shipping_address"
                            rows="4"
                            autocomplete="street-address"
                            required
                            class="w-full resize-y rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-900 outline-none transition placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 dark:focus:ring-indigo-900"
                        >{{ old('shipping_address') }}</textarea>
                        @error('shipping_address')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex flex-col-reverse gap-3 border-t border-gray-200 pt-5 dark:border-gray-800 sm:flex-row sm:items-center sm:justify-between">
                        <a href="{{ route('cart.index') }}"
                           class="inline-flex justify-center rounded-xl border border-gray-300 px-5 py-3 text-sm font-semibold transition hover:bg-gray-100 dark:border-gray-700 dark:hover:bg-gray-800">
                            {{ __('Back to cart') }}
                        </a>

                        <button type="submit"
                            class="inline-flex justify-center rounded-xl bg-indigo-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900">
                            {{ __('Place Order') }}
                        </button>
                    </div>
                </form>
            </section>

            <aside class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-gray-900 sm:p-6">
                <h2 class="text-xl font-semibold">
                    {{ __('Your Order') }}
                </h2>

                <div class="mt-5 divide-y divide-gray-100 dark:divide-gray-800">
                    @foreach ($cartItems as $cartItem)
                        <div class="flex gap-4 py-4 first:pt-0">
                            @if ($cartItem->product->image)
                                <img
                                    src="{{ $cartItem->product->image }}"
                                    alt="{{ $cartItem->product->name }}"
                                    class="h-16 w-16 shrink-0 rounded-lg bg-gray-100 object-contain dark:bg-gray-800"
                                >
                            @else
                                <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-lg bg-gray-100 text-xs text-gray-400 dark:bg-gray-800">
                                    {{ __('No image available') }}
                                </div>
                            @endif

                            <div class="min-w-0 flex-1">
                                <p class="font-medium">
                                    {{ $cartItem->product->name }}
                                </p>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    {{ __('Quantity') }}: {{ $cartItem->quantity }}
                                </p>
                                <p class="mt-2 text-sm font-semibold">
                                    ${{ number_format((float) $cartItem->product->price * $cartItem->quantity, 2) }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>

                @php
                    $orderTotal = $cartItems->sum(
                        fn ($item) => (float) $item->product->price * $item->quantity
                    );
                @endphp

                <div class="mt-4 flex items-center justify-between border-t border-gray-200 pt-5 dark:border-gray-800">
                    <span class="font-semibold">{{ __('Total') }}</span>
                    <span class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">
                        ${{ number_format($orderTotal, 2) }}
                    </span>
                </div>

                <p class="mt-4 text-xs leading-5 text-gray-500 dark:text-gray-400">
                    {{ __('Please review your order details before placing your order.') }}
                </p>
            </aside>
        </div>
    </main>
</body>
</html>