<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Orders</title>
</head>
<body>
    <h1>My Orders</h1>

    <a href="{{ route('products.index') }}">Continue shopping</a>
    <br>
    <a href="{{ route('profile.edit') }}">Profile</a>

    <hr>

    @if ($orders->isEmpty())
        <p>You have no orders yet.</p>
    @else
        @foreach ($orders as $order)
            <div>
                <h2>Order #{{ $order->id }}</h2>

                <p>
                    <strong>Status:</strong>
                    {{ $order->status }}
                </p>

                <p>
                    <strong>Total:</strong>
                    ${{ $order->total }}
                </p>

                <p>
                    <strong>Date:</strong>
                    {{ $order->created_at->format('Y-m-d H:i') }}
                </p>

                <h3>Items</h3>

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