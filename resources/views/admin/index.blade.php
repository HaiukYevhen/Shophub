<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Admin Panel') }} | ShopHub</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-100">

    <header class="bg-white shadow-sm dark:bg-gray-800">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
            <a href="{{ route('admin.index') }}" class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">
                ShopHub
            </a>

            <div class="flex items-center gap-4">
                <span class="text-sm text-gray-600 dark:text-gray-300">
                    {{ auth()->user()->name }}
                </span>

                <a href="{{ route('products.index') }}"
                   class="text-sm font-medium text-indigo-600 hover:text-indigo-800 dark:text-indigo-400">
                    {{ __('View Store') }}
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="rounded-lg bg-gray-100 px-4 py-2 text-sm font-medium hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600">
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>
    </header>

    <main class="mx-auto max-w-7xl px-6 py-10">
        <div class="mb-8">
            <p class="mb-2 text-sm font-semibold uppercase tracking-wider text-indigo-600 dark:text-indigo-400">
                {{ __('ShopHub Administration') }}
            </p>

            <h1 class="text-3xl font-bold tracking-tight">
                {{ __('Welcome') }}, {{ auth()->user()->name }}!
            </h1>

            <p class="mt-2 text-gray-600 dark:text-gray-400">
                {{ __('You have access to the admin panel.') }}
            </p>
        </div>

        <h2 class="mb-4 text-xl font-semibold">
            {{ __('Management') }}
        </h2>

        <div class="grid gap-6 md:grid-cols-2">
            <a href="{{ route('admin.products.index') }}"
               class="group rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:border-indigo-300 hover:shadow-lg dark:border-gray-700 dark:bg-gray-800 dark:hover:border-indigo-500">

                <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-100 text-indigo-600 dark:bg-indigo-900/50 dark:text-indigo-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M3 7h18M5 7l1 13h12l1-13M9 7V4h6v3" />
                    </svg>
                </div>

                <h3 class="text-lg font-semibold group-hover:text-indigo-600 dark:group-hover:text-indigo-400">
                    {{ __('Manage Products') }}
                </h3>

                <p class="mt-2 text-sm leading-6 text-gray-600 dark:text-gray-400">
                    {{ __('Create, edit and manage the products available in your store.') }}
                </p>

                <span class="mt-5 inline-flex items-center gap-2 text-sm font-semibold text-indigo-600 dark:text-indigo-400">
                    {{ __('Manage Products') }} <span aria-hidden="true">&rarr;</span>
                </span>
            </a>

            <a href="{{ route('admin.categories.index') }}"
               class="group rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:border-indigo-300 hover:shadow-lg dark:border-gray-700 dark:bg-gray-800 dark:hover:border-indigo-500">

                <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-100 text-emerald-600 dark:bg-emerald-900/50 dark:text-emerald-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M4 5h6v6H4zM14 5h6v6h-6zM4 15h6v6H4zM14 15h6v6h-6z" />
                    </svg>
                </div>

                <h3 class="text-lg font-semibold group-hover:text-emerald-600 dark:group-hover:text-emerald-400">
                    {{ __('Manage Categories') }}
                </h3>

                <p class="mt-2 text-sm leading-6 text-gray-600 dark:text-gray-400">
                    {{ __('Organize your products into clear and useful categories.') }}
                </p>

                <span class="mt-5 inline-flex items-center gap-2 text-sm font-semibold text-emerald-600 dark:text-emerald-400">
                    {{ __('Manage Categories') }} <span aria-hidden="true">&rarr;</span>
                </span>
            </a>
        </div>
    </main>

</body>
</html>