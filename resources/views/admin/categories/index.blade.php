<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Manage Categories') }} | ShopHub</title>
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

                <a href="{{ route('admin.products.index') }}"
                   class="text-sm font-medium text-gray-600 hover:text-indigo-600 dark:text-gray-300">
                    {{ __('Manage Products') }}
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
                    {{ __('Manage Categories') }}
                </h1>

                <p class="mt-2 text-gray-600 dark:text-gray-400">
                    {{ __('Organize your products into clear and useful categories.') }}
                </p>
            </div>

            <a href="{{ route('admin.categories.create') }}"
               class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700">
                <span class="mr-2 text-lg">+</span>
                {{ __('Create Category') }}
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

        @if ($categories->isEmpty())
            <div class="rounded-2xl border border-gray-200 bg-white p-12 text-center shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <h2 class="text-lg font-semibold">{{ __('No categories found.') }}</h2>

                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                    {{ __('Create your first category to get started.') }}
                </p>
            </div>
        @else
            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($categories as $category)
                    <article class="flex flex-col rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-md dark:border-gray-700 dark:bg-gray-800">
                        <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-100 text-indigo-600 dark:bg-indigo-900/50 dark:text-indigo-300">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-6 w-6"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M4 5h6v6H4zM14 5h6v6h-6zM4 15h6v6H4zM14 15h6v6h-6z" />
                            </svg>
                        </div>

                        <h2 class="text-lg font-semibold">
                            {{ $category->name }}
                        </h2>

                        <p class="mt-2 break-words text-sm text-gray-500 dark:text-gray-400">
                            {{ __('Slug') }}: {{ $category->slug }}
                        </p>

                        @if ($category->description)
                            <p class="mt-4 flex-1 text-sm leading-6 text-gray-600 dark:text-gray-300">
                                {{ $category->description }}
                            </p>
                        @endif

                        <div class="mt-5 border-t border-gray-100 pt-4 dark:border-gray-700">
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                {{ __('Products') }}:
                                <span class="font-semibold text-gray-900 dark:text-white">
                                    {{ $category->products_count }}
                                </span>
                            </p>

                            <div class="mt-4 flex items-center gap-3">
                                <a href="{{ route('admin.categories.edit', $category) }}"
                                   class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium transition hover:border-indigo-500 hover:text-indigo-600 dark:border-gray-600 dark:hover:text-indigo-400">
                                    {{ __('Edit') }}
                                </a>

                                <form method="POST"
                                      action="{{ route('admin.categories.destroy', $category) }}"
                                      onsubmit="return confirm('{{ __('Are you sure you want to delete this category?') }}')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="rounded-lg border border-red-200 px-4 py-2 text-sm font-medium text-red-600 transition hover:bg-red-50 dark:border-red-900 dark:hover:bg-red-900/30">
                                        {{ __('Delete') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </main>

</body>
</html>