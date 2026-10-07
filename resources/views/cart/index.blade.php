<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
</head>
<body>
    <h1>Your Cart</h1>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    @if (session('error'))
        <p>{{ session('error') }}</p>
    @endif

    @if ($cartItems->isEmpty())
        <p>Your cart is empty.</p>
        <a href="{{ route('products.index') }}">Continue shopping</a>
    @else
        @foreach ($cartItems as $cartItem)
            <div>
                <h2>
                    <a href="{{ route('products.show', $cartItem->product->slug) }}">
                        {{ $cartItem->product->name }}
                    </a>
                </h2>

                <p>Price: ${{ $cartItem->product->price }}</p>
                <p>Quantity: {{ $cartItem->quantity }}</p>

                <form method="POST" action="{{ route('cart.update', $cartItem) }}">
                    @csrf
                    @method('PATCH')

                    <input
                        type="number"
                        name="quantity"
                        value="{{ $cartItem->quantity }}"
                        min="1"
                        max="{{ $cartItem->product->stock }}"
                    >

                    <button type="submit">Update</button>
                </form>

                <form method="POST" action="{{ route('cart.remove', $cartItem) }}">
                    @csrf
                    @method('DELETE')

                    <button type="submit">Remove</button>
                </form>
            </div>

            <hr>
        @endforeach

        <a href="{{ route('orders.create') }}">Proceed to Checkout</a>
        
    @endif
</body>
</html>