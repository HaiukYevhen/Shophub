
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Product</title>
</head>
<body>
    <h1>Create Product</h1>

    <form method="POST" action="{{ route('admin.products.store') }}">
        @csrf

        <div>
            <label for="category_id">Category:</label>

            <select id="category_id" name="category_id" required>
                <option value="">Select category</option>

                @foreach ($categories as $category)
                    <option
                        value="{{ $category->id }}"
                        @selected(old('category_id') == $category->id)
                    >
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            @error('category_id')
                <p>{{ $message }}</p>
            @enderror
        </div>

        <br>

        <div>
            <label for="name">Name:</label>
            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name') }}"
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
                value="{{ old('slug') }}"
                required
            >

            @error('slug')
                <p>{{ $message }}</p>
            @enderror
        </div>

        <br>

        <div>
            <label for="description">Description:</label>
            <textarea id="description" name="description">{{ old('description') }}</textarea>

            @error('description')
                <p>{{ $message }}</p>
            @enderror
        </div>

        <br>

        <div>
            <label for="price">Price:</label>
            <input
                type="number"
                id="price"
                name="price"
                value="{{ old('price') }}"
                min="0"
                step="0.01"
                required
            >

            @error('price')
                <p>{{ $message }}</p>
            @enderror
        </div>

        <br>

        <div>
            <label for="stock">Stock:</label>
            <input
                type="number"
                id="stock"
                name="stock"
                value="{{ old('stock', 0) }}"
                min="0"
                step="1"
                required
            >

            @error('stock')
                <p>{{ $message }}</p>
            @enderror
        </div>

        <br>

        <div>
            <label for="image">Image URL or path:</label>
            <input
                type="text"
                id="image"
                name="image"
                value="{{ old('image') }}"
            >

            @error('image')
                <p>{{ $message }}</p>
            @enderror
        </div>

        <br>

        <div>
            <input
                type="checkbox"
                id="is_active"
                name="is_active"
                value="1"
                @checked(old('is_active', true))
            >

            <label for="is_active">Active</label>

            @error('is_active')
                <p>{{ $message }}</p>
            @enderror
        </div>

        <br>

        <button type="submit">Create Product</button>
    </form>

    <br>

    <a href="{{ route('admin.products.index') }}">Back to Products</a>
</body>
</html>