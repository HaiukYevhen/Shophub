<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Category</title>
</head>
<body>
    <h1>Edit Category</h1>

    <form
        method="POST"
        action="{{ route('admin.categories.update', $category) }}"
    >
        @csrf
        @method('PUT')

        <div>
            <label for="name">Name:</label>

            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name', $category->name) }}"
                required
            >

            @error('name')
                <p>{{ $message }}</p>
            @enderror
        </div>

        <br>

        <div>
            <label for="slug">Slug:</label>

            <input
                type="text"
                id="slug"
                name="slug"
                value="{{ old('slug', $category->slug) }}"
                required
            >

            @error('slug')
                <p>{{ $message }}</p>
            @enderror
        </div>

        <br>

        <div>
            <label for="description">Description:</label>

            <textarea
                id="description"
                name="description"
            >{{ old('description', $category->description) }}</textarea>

            @error('description')
                <p>{{ $message }}</p>
            @enderror
        </div>

        <br>

        <button type="submit">Update Category</button>
    </form>

    <br>

    <a href="{{ route('admin.categories.index') }}">
        Back to Categories
    </a>
</body>
</html>