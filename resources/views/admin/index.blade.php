<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <title>{{ __('Admin Panel') }}</title>
</head>
<body>
    <h1>{{ __('Admin Panel') }}</h1>

    <p>{{ __('Welcome') }}, {{ auth()->user()->name }}!</p>
    <p>{{ __('You have access to the admin panel.') }}</p>

    <h2>{{ __('Management') }}</h2>

    <a href="{{ route('admin.categories.index') }}">
        {{ __('Manage Categories') }}
    </a>

    <br>

    <a href="{{ route('admin.products.index') }}">
        {{ __('Manage Products') }}
    </a>
</body>
</html>