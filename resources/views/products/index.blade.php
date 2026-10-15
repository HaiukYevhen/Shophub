<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Products') }}</title>
</head>
<body>
    <h1>{{ __('Products') }}</h1>

    <form method="GET" action="{{ route('products.index') }}">
        <div>
            <label for="search">{{ __('Search') }}:</label>
            <input
                type="text"
                id="search"
                name="search"
                value="{{ $search }}"
                placeholder="{{ __('Search products...') }}"
            >
        </div>

        <div>
            <label for="min_price">{{ __('Minimum Price') }}:</label>
            <input
                type="number"
                id="min_price"
                name="min_price"
                min="0"
                step="0.01"
                value="{{ $minPrice }}"
            >
        </div>

        <div>
            <label for="max_price">{{ __('Maximum Price') }}:</label>
            <input
                type="number"
                id="max_price"
                name="max_price"
                min="0"
                step="0.01"
                value="{{ $maxPrice }}"
            >
        </div>

        @if (request('category'))
            <input type="hidden" name="category" value="{{ request('category') }}">
        @endif

        <button type="submit">{{ __('Apply Filters') }}</button>
        <a href="{{ route('products.index') }}">{{ __('Reset') }}</a>
    </form>

    <hr>

    <h3>{{ __('Categories') }}</h3>

    <a href="{{ route('products.index', request()->except('category')) }}">{{ __('All Categories') }}</a>

    @foreach ($categories as $category)
        <a href="{{ route('products.index', ['category' => $category->slug]) }}">
            {{ $category->name }}
        </a>
    @endforeach

    <hr>

    @foreach ($products as $product)
        <div>
            <h2>
                <a href="{{ route('products.show', $product->slug) }}">
                    {{ $product->name }}
                </a>
            </h2>

            <p>{{ __('Category') }}: {{ $product->category->name }}</p>
            <p>{{ __('Price') }}: ${{ $product->price }}
                @if ($exchangeRate !== null)
                    ≈ ₴{{ number_format((float) $product->price * $exchangeRate, 2) }}
                @endif
            </p>
            <p>{{ __('Stock') }}: {{ $product->stock }}</p>

            <a href="{{ route('products.show', $product->slug) }}">
                {{ __('View Details') }}
            </a>
        </div>

        <hr>
    @endforeach

    @if ($products->isEmpty())
        <p>{{ __('No products found.') }}</p>
    @endif
</body>
</html>