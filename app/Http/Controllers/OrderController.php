<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function create()
    {
        $cartItems = CartItem::where('user_id', auth()->id())
            ->with('product')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }

        return view('orders.create', compact('cartItems'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_email' => ['required', 'email', 'max:255'],
            'shipping_address' => ['required', 'string', 'max:1000'],
        ]);

        $cartItems = CartItem::where('user_id', auth()->id())
            ->with('product')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }

        DB::transaction(function () use ($validated, $cartItems) {
            $total = 0;

            foreach ($cartItems as $cartItem) {
                if (
                    !$cartItem->product->is_active ||
                    $cartItem->product->stock < $cartItem->quantity
                ) {
                    abort(422, 'Not enough product stock.');
                }

                $total += $cartItem->product->price * $cartItem->quantity;
            }

            $order = Order::create([
                'user_id' => auth()->id(),
                'status' => 'pending',
                'total' => $total,
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'shipping_address' => $validated['shipping_address'],
            ]);

            foreach ($cartItems as $cartItem) {
                $order->items()->create([
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->product->price,
                ]);

                $cartItem->product->decrement(
                    'stock',
                    $cartItem->quantity
                );
            }

            CartItem::where('user_id', auth()->id())->delete();
        });

        return redirect()
            ->route('cart.index')
            ->with('success', 'Order created successfully.');
    }
}