<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }}</title>
</head>
<body>
    <a href="{{ route('products.index') }}">← {{ __('Back to products') }}</a>

    <h1>{{ $product->name }}</h1>

    <p>
        <strong>{{ __('Category') }}:</strong>
        {{ $product->category->name }}
    </p>

    <p>
        <strong>{{ __('Description') }}:</strong>
        {{ $product->description }}
    </p>

    <p>
        <strong>{{ __('Price') }}:</strong>
        ${{ $product->price }}
        @if ($exchangeRate !== null)
            ≈ ₴{{ number_format((float) $product->price * $exchangeRate, 2) }}
        @endif
    </p>

    <p>
        <strong>{{ __('Stock') }}:</strong>
        {{ $product->stock }}
    </p>

    @if ($product->is_active && $product->stock > 0)
        @auth
            <form method="POST" action="{{ route('cart.add', $product) }}">
                @csrf

                <label for="quantity">{{ __('Quantity') }}:</label>

                <input
                    type="number"
                    id="quantity"
                    name="quantity"
                    value="1"
                    min="1"
                    max="{{ $product->stock }}"
                >

                <button type="submit">{{ __('Add to Cart') }}</button>
            </form>
        @else
            <p>
                <a href="{{ route('login') }}">{{ __('Log in') }}</a>
                {{ __('to add this product to your cart.') }}
            </p>
        @endauth
    @else
        <p>{{ __('Out of stock.') }}</p>
    @endif
</body>
</html>