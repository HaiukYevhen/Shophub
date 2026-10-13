<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <title>{{ __('My Orders') }}</title>
</head>
<body>
    <h1>{{ __('My Orders') }}</h1>

    <a href="{{ route('products.index') }}">{{ __('Continue shopping') }}</a>
    <br>
    <a href="{{ route('profile.edit') }}">{{ __('Profile') }}</a>

    <hr>

    @if ($orders->isEmpty())
        <p>{{ __('You have no orders yet.') }}</p>
    @else
        @foreach ($orders as $order)
            <div>
                <h2>{{ __('Order') }} #{{ $order->id }}</h2>

                <p>
                    <strong>{{ __('Status') }}:</strong>
                    {{ __(ucfirst($order->status)) }}
                </p>

                <p>
                    <strong>{{ __('Total') }}:</strong>
                    ${{ $order->total }}
                </p>

                <p>
                    <strong>{{ __('Date') }}:</strong>
                    {{ $order->created_at->format('Y-m-d H:i') }}
                </p>

                <h3>{{ __('Items') }}</h3>

                @foreach ($order->items as $item)
                    <div>
                        <p>
                            {{ $item->product->name }}
                            × {{ $item->quantity }}
                            — ${{ $item->price }}
                        </p>
                    </div>
                @endforeach
            </div>

            <hr>
        @endforeach
    @endif
</body>
</html>