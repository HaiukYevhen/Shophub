<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
</head>
<body>
    <h1>Products</h1>

    <h3>Categories</h3>

    <a href="{{ route('products.index') }}">All</a>

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

            <p>Category: {{ $product->category->name }}</p>
            <p>Price: ${{ $product->price }}</p>
            <p>Stock: {{ $product->stock }}</p>
        </div>

        <hr>
    @endforeach

    @if ($products->isEmpty())
        <p>No products found.</p>
    @endif
</body>
</html>