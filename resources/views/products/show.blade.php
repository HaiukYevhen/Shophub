<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }}</title>
</head>
<body>
    <a href="{{ route('products.index') }}">← Back to products</a>

    <h1>{{ $product->name }}</h1>

    <p>
        <strong>Category:</strong>
        {{ $product->category->name }}
    </p>

    <p>
        <strong>Description:</strong>
        {{ $product->description }}
    </p>

    <p>
        <strong>Price:</strong>
        ${{ $product->price }}
    </p>

    <p>
        <strong>Stock:</strong>
        {{ $product->stock }}
    </p>

    @if ($product->stock > 0)
        @auth
            <form method="POST" action="{{ route('cart.add', $product) }}">
                @csrf

                <label for="quantity">Quantity:</label>

                <input
                    type="number"
                    id="quantity"
                    name="quantity"
                    value="1"
                    min="1"
                    max="{{ $product->stock }}"
                >

                <button type="submit">Add to Cart</button>
            </form>
        @else
            <p>
                <a href="{{ route('login') }}">Log in</a>
                to add this product to your cart.
            </p>
        @endauth
    @else
        <p>Out of stock.</p>
    @endif
</body>
</html>