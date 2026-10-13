<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Checkout') }}</title>
</head>
<body>
    <h1>{{ __('Checkout') }}</h1>

    <h2>{{ __('Your Order') }}</h2>

    @foreach ($cartItems as $cartItem)
        <div>
            <h3>{{ $cartItem->product->name }}</h3>

            <p>
                {{ __('Price') }}:
                ${{ $cartItem->product->price }}
            </p>

            <p>
                {{ __('Quantity') }}:
                {{ $cartItem->quantity }}
            </p>

            <p>
                {{ __('Subtotal') }}:
                ${{ $cartItem->product->price * $cartItem->quantity }}
            </p>
        </div>

        <hr>
    @endforeach

    <h2>{{ __('Customer Information') }}</h2>

    <form method="POST" action="{{ route('orders.store') }}">
        @csrf

        <div>
            <label for="customer_name">{{ __('Name') }}:</label>

            <input
                type="text"
                id="customer_name"
                name="customer_name"
                value="{{ old('customer_name', auth()->user()->name) }}"
                required
            >

            @error('customer_name')
                <p>{{ $message }}</p>
            @enderror
        </div>

        <br>

        <div>
            <label for="customer_email">{{ __('Email') }}:</label>

            <input
                type="email"
                id="customer_email"
                name="customer_email"
                value="{{ old('customer_email', auth()->user()->email) }}"
                required
            >

            @error('customer_email')
                <p>{{ $message }}</p>
            @enderror
        </div>

        <br>

        <div>
            <label for="shipping_address">{{ __('Shipping address') }}:</label>

            <textarea
                id="shipping_address"
                name="shipping_address"
                required
            >{{ old('shipping_address') }}</textarea>

            @error('shipping_address')
                <p>{{ $message }}</p>
            @enderror
        </div>

        <br>

        <button type="submit">{{ __('Place Order') }}</button>
    </form>

    <br>

    <a href="{{ route('cart.index') }}">{{ __('Back to cart') }}</a>
</body>
</html>