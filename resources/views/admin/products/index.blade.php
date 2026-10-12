
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Products</title>
</head>
<body>
    <h1>Manage Products</h1>

    <a href="{{ route('admin.index') }}">Admin Panel</a>
    |
    <a href="{{ route('admin.products.create') }}">Create Product</a>

    <hr>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    @if (session('error'))
        <p>{{ session('error') }}</p>
    @endif

    @if ($products->isEmpty())
        <p>No products found.</p>
    @else
        @foreach ($products as $product)
            <div>
                <h2>{{ $product->name }}</h2>

                <p>Category: {{ $product->category->name }}</p>
                <p>Slug: {{ $product->slug }}</p>
                <p>Price: ${{ $product->price }}</p>
                <p>Stock: {{ $product->stock }}</p>
                <p>
                    Status: {{ $product->is_active ? 'Active' : 'Inactive' }}
                </p>

                @if ($product->description)
                    <p>{{ $product->description }}</p>
                @endif

                <a href="{{ route('admin.products.edit', $product) }}">
                    Edit
                </a>

                <form
                    method="POST"
                    action="{{ route('admin.products.destroy', $product) }}"
                    style="display: inline;"
                >
                    @csrf
                    @method('DELETE')

                    <button type="submit">Delete</button>
                </form>
            </div>

            <hr>
        @endforeach
    @endif
</body>
</html>