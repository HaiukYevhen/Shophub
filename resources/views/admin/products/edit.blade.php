<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Edit Product') }} | ShopHub</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-100">

    <header class="bg-white shadow-sm dark:bg-gray-800">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
            <a href="{{ route('admin.index') }}"
               class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">
                ShopHub
            </a>

            <a href="{{ route('admin.products.index') }}"
               class="text-sm font-medium text-indigo-600 hover:text-indigo-800 dark:text-indigo-400">
                {{ __('Back to Products') }}
            </a>
        </div>
    </header>

    <main class="mx-auto max-w-4xl px-6 py-10">
        <div class="mb-8">
            <p class="mb-2 text-sm font-semibold uppercase tracking-wider text-indigo-600 dark:text-indigo-400">
                ShopHub
            </p>
            <h1 class="text-3xl font-bold">{{ __('Edit Product') }}</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">
                {{ __('Update the details of this product.') }}
            </p>
        </div>

        <form method="POST"
              action="{{ route('admin.products.update', $product) }}"
              class="space-y-6 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8 dark:border-gray-700 dark:bg-gray-800">
            @csrf
            @method('PUT')

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label for="name" class="mb-2 block text-sm font-medium">
                        {{ __('Name') }}
                    </label>
                    <input type="text" id="name" name="name"
                           value="{{ old('name', $product->name) }}" required
                           class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-gray-900 outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 dark:border-gray-600 dark:bg-gray-900 dark:text-white dark:focus:ring-indigo-900">
                    @error('name')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="category_id" class="mb-2 block text-sm font-medium">
                        {{ __('Category') }}
                    </label>
                    <select id="category_id" name="category_id" required
                            class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-gray-900 outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 dark:border-gray-600 dark:bg-gray-900 dark:text-white dark:focus:ring-indigo-900">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                @selected(old('category_id', $product->category_id) == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="slug" class="mb-2 block text-sm font-medium">
                        {{ __('Slug') }}
                    </label>
                    <input type="text" id="slug" name="slug"
                           value="{{ old('slug', $product->slug) }}" required
                           class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-gray-900 outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 dark:border-gray-600 dark:bg-gray-900 dark:text-white dark:focus:ring-indigo-900">
                    @error('slug')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="price" class="mb-2 block text-sm font-medium">
                        {{ __('Price') }}
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500">$</span>
                        <input type="number" id="price" name="price"
                               value="{{ old('price', $product->price) }}" min="0" step="0.01" required
                               class="w-full rounded-xl border border-gray-300 bg-white py-3 pl-9 pr-4 text-gray-900 outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 dark:border-gray-600 dark:bg-gray-900 dark:text-white dark:focus:ring-indigo-900">
                    </div>
                    @error('price')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="stock" class="mb-2 block text-sm font-medium">
                        {{ __('Stock') }}
                    </label>
                    <input type="number" id="stock" name="stock"
                           value="{{ old('stock', $product->stock) }}" min="0" step="1" required
                           class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-gray-900 outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 dark:border-gray-600 dark:bg-gray-900 dark:text-white dark:focus:ring-indigo-900">
                    @error('stock')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="image" class="mb-2 block text-sm font-medium">
                        {{ __('Image URL or path') }}
                    </label>
                    <input type="text" id="image" name="image"
                           value="{{ old('image', $product->image) }}"
                           placeholder="https://example.com/image.png"
                           class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-gray-900 outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 dark:border-gray-600 dark:bg-gray-900 dark:text-white dark:focus:ring-indigo-900">
                    @error('image')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            @if ($product->image)
                <div>
                    <p class="mb-2 text-sm font-medium">{{ __('Current Image') }}</p>
                    <img src="{{ $product->image }}"
                         alt="{{ $product->name }}"
                         class="h-32 w-32 rounded-xl border border-gray-200 bg-white object-contain p-2 dark:border-gray-700">
                </div>
            @endif

            <div>
                <label for="description" class="mb-2 block text-sm font-medium">
                    {{ __('Description') }}
                </label>
                <textarea id="description" name="description" rows="4"
                          class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-gray-900 outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 dark:border-gray-600 dark:bg-gray-900 dark:text-white dark:focus:ring-indigo-900">{{ old('description', $product->description) }}</textarea>
                @error('description')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="flex cursor-pointer items-center gap-3 rounded-xl border border-gray-200 p-4 dark:border-gray-700">
                    <input type="checkbox" id="is_active" name="is_active" value="1"
                           @checked(old('is_active', $product->is_active))
                           class="h-5 w-5 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                    <span>
                        <span class="block text-sm font-medium">{{ __('Active') }}</span>
                        <span class="mt-1 block text-xs text-gray-500 dark:text-gray-400">
                            {{ __('Make this product visible in the store.') }}
                        </span>
                    </span>
                </label>
                @error('is_active')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex flex-col-reverse gap-3 border-t border-gray-100 pt-5 sm:flex-row sm:justify-end dark:border-gray-700">
                <a href="{{ route('admin.products.index') }}"
                   class="inline-flex justify-center rounded-xl border border-gray-300 px-5 py-3 text-sm font-semibold transition hover:bg-gray-100 dark:border-gray-600 dark:hover:bg-gray-700">
                    {{ __('Cancel') }}
                </a>
                <button type="submit"
                        class="rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700">
                    {{ __('Update Product') }}
                </button>
            </div>
        </form>
    </main>

</body>
</html>