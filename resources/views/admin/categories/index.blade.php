<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <title>{{ __('Manage Categories') }}</title>
</head>
<body>
    <h1>{{ __('Manage Categories') }}</h1>

    <a href="{{ route('admin.index') }}">{{ __('Admin Panel') }}</a>
    |
    <a href="{{ route('admin.categories.create') }}">{{ __('Create Category') }}</a>

    <hr>

    @if (session('success'))
        <p>{{ __(session('success')) }}</p>
    @endif

    @if (session('error'))
        <p>{{ __(session('error')) }}</p>
    @endif

    @if ($categories->isEmpty())
        <p>{{ __('No categories found.') }}</p>
    @else
        @foreach ($categories as $category)
            <div>
                <h2>{{ $category->name }}</h2>

                <p>{{ __('Slug') }}: {{ $category->slug }}</p>

                <p>
                    {{ __('Products') }}: {{ $category->products_count }}
                </p>

                @if ($category->description)
                    <p>{{ $category->description }}</p>
                @endif

                <a href="{{ route('admin.categories.edit', $category) }}">
                    {{ __('Edit') }}
                </a>

                <form
                    method="POST"
                    action="{{ route('admin.categories.destroy', $category) }}"
                    style="display: inline;"
                >
                    @csrf
                    @method('DELETE')

                    <button type="submit">
                        {{ __('Delete') }}
                    </button>
                </form>
            </div>

            <hr>
        @endforeach
    @endif
</body>
</html>