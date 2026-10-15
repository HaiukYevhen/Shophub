<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Manage Products') }} | ShopHub</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-100">

    <header class="bg-white shadow-sm dark:bg-gray-800">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
            <a href="{{ route('admin.index') }}"
               class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">
                ShopHub
            </a>

            <nav class="flex items-center gap-4">
                <a href="{{ route('admin.index') }}"
                   class="text-sm font-medium text-gray-600 hover:text-indigo-600 dark:text-gray-300">
                    {{ __('Admin Panel') }}
                </a>

                <a href="{{ route('products.index') }}"
                   class="text-sm font-medium text-gray-600 hover:text-indigo-600 dark:text-gray-300">
                    {{ __('View Store') }}
                </a>
            </nav>
        </div>
    </header>

    <main class="mx-auto max-w-7xl px-6 py-10">
        <div class="mb-8 flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
            <div>
                <p class="mb-2 text-sm font-semibold uppercase tracking-wider text-indigo-600 dark:text-indigo-400">
                    ShopHub
                </p>

                <h1 class="text-3xl font-bold tracking-tight">
                    {{ __('Manage Products') }}
                </h1>

                <p class="mt-2 text-gray-600 dark:text-gray-400">
                    {{ __('Manage your store products, prices and stock.') }}
                </p>
            </div>

            <a href="{{ route('admin.products.create') }}"
               class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700">
                <span class="mr-2 text-lg">+</span>
                {{ __('Create Product') }}
            </a>
        </div>

        @if (session('success'))
            <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800 dark:border-green-800 dark:bg-green-900/30 dark:text-green-300">
                {{ __(session('success')) }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800 dark:border-red-800 dark:bg-red-900/30 dark:text-red-300">
                {{ __(session('error')) }}
            </div>
        @endif

        @if ($products->isEmpty())
            <div class="rounded-2xl border border-gray-200 bg-white p-12 text-center shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <h2 class="text-lg font-semibold">{{ __('No products found.') }}</h2>
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                    {{ __('Create your first product to get started.') }}
                </p>
            </div>
        @else
            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <div class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach ($products as $product)
                        <article class="flex flex-col gap-5 p-5 transition hover:bg-gray-50 sm:flex-row sm:items-center dark:hover:bg-gray-700/30">
                            <div class="flex h-24 w-24 shrink-0 items-center justify-center overflow-hidden rounded-xl bg-gray-100 dark:bg-gray-700">
                                @if ($product->image)
                                    <img src="{{ $product->image }}"
                                         alt="{{ $product->name }}"
                                         class="h-full w-full object-contain"
                                         loading="lazy">
                                @else
                                    <span class="px-2 text-center text-xs text-gray-400">
                                        {{ __('No image available.') }}
                                    </span>
                                @endif
                            </div>

                            <div class="min-w-0 flex-1">
                                <div class="flex flex-wrap items-center gap-2">
                                    <h2 class="text-lg font-semibold">
                                        {{ $product->name }}
                                    </h2>

                                    <span class="rounded-full px-2.5 py-1 text-xs font-medium
                                        {{ $product->is_active
                                            ? 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300'
                                            : 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300' }}">
                                        {{ $product->is_active ? __('Active') : __('Inactive') }}
                                    </span>
                                </div>

                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    {{ __('Category') }}:
                                    {{ $product->category->name ?? '—' }}
                                </p>

                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                    {{ __('Slug') }}: {{ $product->slug }}
                                </p>

                                @if ($product->description)
                                    <p class="mt-2 line-clamp-2 text-sm text-gray-600 dark:text-gray-300">
                                        {{ $product->description }}
                                    </p>
                                @endif
                            </div>

                            <div class="flex items-center justify-between gap-6 sm:justify-end">
                                <div>
                                    <p class="text-lg font-bold text-gray-900 dark:text-white">
                                        ${{ number_format((float) $product->price, 2) }}
                                    </p>

                                    <p class="mt-1 text-sm {{ $product->stock > 0 ? 'text-gray-500 dark:text-gray-400' : 'font-medium text-red-600 dark:text-red-400' }}">
                                        {{ __('Stock') }}: {{ $product->stock }}
                                    </p>
                                </div>

                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.products.edit', $product) }}"
                                       class="rounded-lg border border-gray-300 px-3 py-2 text-sm font-medium transition hover:border-indigo-500 hover:text-indigo-600 dark:border-gray-600 dark:hover:text-indigo-400">
                                        {{ __('Edit') }}
                                    </a>

                                    <form method="POST"
                                          action="{{ route('admin.products.destroy', $product) }}"
                                          onsubmit="return confirm('{{ __('Are you sure you want to delete this product?') }}')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="rounded-lg border border-red-200 px-3 py-2 text-sm font-medium text-red-600 transition hover:bg-red-50 dark:border-red-900 dark:hover:bg-red-900/30">
                                            {{ __('Delete') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="mt-6">
            <a href="{{ route('admin.categories.index') }}"
               class="text-sm font-medium text-indigo-600 hover:text-indigo-800 dark:text-indigo-400">
                &larr; {{ __('Manage Categories') }}
            </a>
        </div>
    </main>

</body>
</html>