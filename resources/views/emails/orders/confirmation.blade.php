
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <title>{{ __('Order Confirmation') }}</title>
</head>
<body>
    <h1>{{ __('Thank you for your order!') }}</h1>

    <p>
        {{ __('Order') }} #{{ $order->id }}
    </p>

    <p>
        {{ __('Status') }}: {{ __(ucfirst($order->status)) }}
    </p>

    <h2>{{ __('Items') }}</h2>

    @foreach ($order->items as $item)
        <div>
            <p>
                {{ $item->product->name }}
                × {{ $item->quantity }}
            </p>

            <p>
                {{ __('Price') }}: ${{ $item->price }}
            </p>
        </div>
    @endforeach

    <h2>{{ __('Total') }}: ${{ $order->total }}</h2>

    <p>{{ __('Shipping address') }}: {{ $order->shipping_address }}</p>
</body>
</html>
