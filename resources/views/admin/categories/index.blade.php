<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Categories</title>
</head>
<body>
    <h1>Manage Categories</h1>

    <a href="{{ route('admin.index') }}">Admin Panel</a>
    |
    <a href="{{ route('admin.categories.create') }}">Create Category</a>

    <hr>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    @if (session('error'))
        <p>{{ session('error') }}</p>
    @endif

    @if ($categories->isEmpty())
        <p>No categories found.</p>
    @else
        @foreach ($categories as $category)
            <div>
                <h2>{{ $category->name }}</h2>

                <p>Slug: {{ $category->slug }}</p>

                <p>
                    Products: {{ $category->products_count }}
                </p>

                @if ($category->description)
                    <p>{{ $category->description }}</p>
                @endif

                <a href="{{ route('admin.categories.edit', $category) }}">
                    Edit
                </a>

                <form
                    method="POST"
                    action="{{ route('admin.categories.destroy', $category) }}"
                    style="display: inline;"
                >
                    @csrf
                    @method('DELETE')

                    <button type="submit">
                        Delete
                    </button>
                </form>
            </div>

            <hr>
        @endforeach
    @endif
</body>
</html>