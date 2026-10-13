<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <title>{{ __('Manage Products') }}</title>
</head>
<body>
    <h1>{{ __('Manage Products') }}</h1>

    <a href="{{ route('admin.index') }}">{{ __('Admin Panel') }}</a>
    |
    <a href="{{ route('admin.products.create') }}">{{ __('Create Product') }}</a>

    <hr>

    @if (session('success'))
        <p>{{ __(session('success')) }}</p>
    @endif

    @if (session('error'))
        <p>{{ __(session('error')) }}</p>
    @endif

    @if ($products->isEmpty())
        <p>{{ __('No products found.') }}</p>
    @else
        @foreach ($products as $product)
            <div>
                <h2>{{ $product->name }}</h2>

                <p>{{ __('Category') }}: {{ $product->category->name }}</p>
                <p>{{ __('Slug') }}: {{ $product->slug }}</p>
                <p>{{ __('Price') }}: ${{ $product->price }}</p>
                <p>{{ __('Stock') }}: {{ $product->stock }}</p>

                <p>
                    {{ __('Status') }}:
                    {{ $product->is_active ? __('Active') : __('Inactive') }}
                </p>

                @if ($product->description)
                    <p>{{ $product->description }}</p>
                @endif

                <a href="{{ route('admin.products.edit', $product) }}">
                    {{ __('Edit') }}
                </a>

                <form
                    method="POST"
                    action="{{ route('admin.products.destroy', $product) }}"
                    style="display: inline;"
                >
                    @csrf
                    @method('DELETE')

                    <button type="submit">{{ __('Delete') }}</button>
                </form>
            </div>

            <hr>
        @endforeach
    @endif
</body>
</html>