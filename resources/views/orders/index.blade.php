<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('My Orders') }} | ShopHub</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-50 text-gray-900 dark:bg-gray-950 dark:text-gray-100">
    <header class="border-b border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900">
        <div class="mx-auto flex max-w-6xl flex-wrap items-center justify-between gap-4 px-4 py-5 sm:px-6 lg:px-8">
            <a href="{{ route('products.index') }}" class="text-2xl font-bold tracking-tight text-indigo-600 dark:text-indigo-400">
                ShopHub
            </a>

            <nav class="flex flex-wrap items-center gap-2">
                <a href="{{ route('products.index') }}"
                   class="rounded-lg px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-800">
                    {{ __('Continue shopping') }}
                </a>
                <a href="{{ route('profile.edit') }}"
                   class="rounded-lg px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-800">
                    {{ __('Profile') }}
                </a>
            </nav>
        </div>
    </header>

    <main class="mx-auto max-w-5xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold tracking-tight sm:text-4xl">
                {{ __('My Orders') }}
            </h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">
                {{ __('View your order history and details.') }}
            </p>
        </div>

        @if ($orders->isEmpty())
            <div class="rounded-2xl border border-gray-200 bg-white px-6 py-16 text-center shadow-sm dark:border-gray-800 dark:bg-gray-900">
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-indigo-50 text-indigo-600 dark:bg-indigo-950 dark:text-indigo-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 7h6m-6 4h6" />
                    </svg>
                </div>

                <h2 class="mt-5 text-xl font-semibold">
                    {{ __('You have no orders yet.') }}
                </h2>
                <p class="mt-2 text-gray-600 dark:text-gray-400">
                    {{ __('Your placed orders will appear here.') }}
                </p>

                <a href="{{ route('products.index') }}"
                   class="mt-6 inline-flex items-center rounded-lg bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500">
                    {{ __('Continue shopping') }}
                </a>
            </div>
        @else
            <div class="space-y-6">
                @foreach ($orders as $order)
                    <article class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
                        <div class="flex flex-col gap-4 border-b border-gray-200 p-5 dark:border-gray-800 sm:flex-row sm:items-center sm:justify-between sm:p-6">
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ __('Order') }} #{{ $order->id }}
                                </p>
                                <h2 class="mt-1 text-xl font-bold">
                                    ${{ number_format((float) $order->total, 2) }}
                                </h2>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    {{ __('Date') }}:
                                    {{ $order->created_at->format('Y-m-d H:i') }}
                                </p>
                            </div>

                            @php
                                $status = strtolower($order->status);
                                $statusClasses = match ($status) {
                                    'completed', 'delivered' => 'bg-green-100 text-green-800 dark:bg-green-950 dark:text-green-300',
                                    'cancelled', 'canceled', 'failed' => 'bg-red-100 text-red-800 dark:bg-red-950 dark:text-red-300',
                                    'processing', 'shipped' => 'bg-blue-100 text-blue-800 dark:bg-blue-950 dark:text-blue-300',
                                    default => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-950 dark:text-yellow-300',
                                };
                            @endphp

                            <div class="flex flex-wrap items-center gap-2">
                                <span class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ __('Status') }}:
                                </span>
                                <span class="inline-flex rounded-full px-3 py-1 text-sm font-semibold {{ $statusClasses }}">
                                    {{ __(ucfirst($order->status)) }}
                                </span>
                            </div>
                        </div>

                        <div class="p-5 sm:p-6">
                            <h3 class="mb-4 text-sm font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                                {{ __('Items') }} ({{ $order->items->sum('quantity') }})
                            </h3>

                            <div class="divide-y divide-gray-100 dark:divide-gray-800">
                                @foreach ($order->items as $item)
                                    <div class="flex items-start justify-between gap-4 py-4 first:pt-0 last:pb-0">
                                        <div class="min-w-0">
                                            <p class="font-medium">
                                                {{ $item->product->name ?? __('Product no longer available') }}
                                            </p>
                                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                                {{ __('Quantity') }}: {{ $item->quantity }}
                                                × ${{ number_format((float) $item->price, 2) }}
                                            </p>
                                        </div>

                                        <p class="shrink-0 font-semibold">
                                            ${{ number_format((float) $item->price * $item->quantity, 2) }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </main>
</body>
</html>