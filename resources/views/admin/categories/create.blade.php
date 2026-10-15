<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Create Category') }} | ShopHub</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-100">

    <header class="bg-white shadow-sm dark:bg-gray-800">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
            <a href="{{ route('admin.index') }}"
               class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">
                ShopHub
            </a>

            <a href="{{ route('admin.categories.index') }}"
               class="text-sm font-medium text-indigo-600 hover:text-indigo-800 dark:text-indigo-400">
                {{ __('Back to Categories') }}
            </a>
        </div>
    </header>

    <main class="mx-auto max-w-3xl px-6 py-10">
        <div class="mb-8">
            <p class="mb-2 text-sm font-semibold uppercase tracking-wider text-indigo-600 dark:text-indigo-400">
                ShopHub
            </p>
            <h1 class="text-3xl font-bold">{{ __('Create Category') }}</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">
                {{ __('Enter the details for the new category.') }}
            </p>
        </div>

        <form method="POST"
              action="{{ route('admin.categories.store') }}"
              class="space-y-6 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8 dark:border-gray-700 dark:bg-gray-800">
            @csrf

            <div>
                <label for="name" class="mb-2 block text-sm font-medium">
                    {{ __('Name') }}
                </label>
                <input type="text" id="name" name="name"
                       value="{{ old('name') }}" required
                       class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-gray-900 outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 dark:border-gray-600 dark:bg-gray-900 dark:text-white dark:focus:ring-indigo-900">
                @error('name')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="slug" class="mb-2 block text-sm font-medium">
                    {{ __('Slug') }}
                </label>
                <input type="text" id="slug" name="slug"
                       value="{{ old('slug') }}" required
                       class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-gray-900 outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 dark:border-gray-600 dark:bg-gray-900 dark:text-white dark:focus:ring-indigo-900">
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                    {{ __('Used in the category URL.') }}
                </p>
                @error('slug')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="description" class="mb-2 block text-sm font-medium">
                    {{ __('Description') }}
                </label>
                <textarea id="description" name="description" rows="4"
                          class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-gray-900 outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 dark:border-gray-600 dark:bg-gray-900 dark:text-white dark:focus:ring-indigo-900">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex flex-col-reverse gap-3 border-t border-gray-100 pt-5 sm:flex-row sm:justify-end dark:border-gray-700">
                <a href="{{ route('admin.categories.index') }}"
                   class="inline-flex justify-center rounded-xl border border-gray-300 px-5 py-3 text-sm font-semibold transition hover:bg-gray-100 dark:border-gray-600 dark:hover:bg-gray-700">
                    {{ __('Cancel') }}
                </a>
                <button type="submit"
                        class="rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700">
                    {{ __('Create Category') }}
                </button>
            </div>
        </form>
    </main>

</body>
</html>