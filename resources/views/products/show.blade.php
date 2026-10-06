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
</body>
</html>