<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Products') }}</title>
</head>
<body>
    <h1>{{ __('Products') }}</h1>

    <h3>{{ __('Categories') }}</h3>

    <a href="{{ route('products.index') }}">{{ __('All Categories') }}</a>

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