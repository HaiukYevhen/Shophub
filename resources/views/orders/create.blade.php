<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
</head>
<body>
    <h1>Checkout</h1>

    <h2>Your Order</h2>

    @foreach ($cartItems as $cartItem)
        <div>
            <h3>{{ $cartItem->product->name }}</h3>

            <p>
                Price: ${{ $cartItem->product->price }}
            </p>

            <p>
                Quantity: {{ $cartItem->quantity }}
            </p>

            <p>
                Subtotal:
                ${{ $cartItem->product->price * $cartItem->quantity }}
            </p>
        </div>

        <hr>
    @endforeach

    <h2>Customer Information</h2>

    <form method="POST" action="{{ route('orders.store') }}">
        @csrf

        <div>
            <label for="customer_name">Name:</label>

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
            <label for="customer_email">Email:</label>

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
            <label for="shipping_address">Shipping address:</label>

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

        <button type="submit">Place Order</button>
    </form>

    <br>

    <a href="{{ route('cart.index') }}">Back to cart</a>
</body>
</html>