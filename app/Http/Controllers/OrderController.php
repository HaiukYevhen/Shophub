<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Mail\OrderConfirmation;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->with('items.product')
            ->latest()
            ->get();

        return view('orders.index', compact('orders'));
    }

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
        foreach ($cartItems as $cartItem) {
            if (!$cartItem->product->is_active) {
                return redirect()
                    ->route('cart.index')
                    ->with(
                        'error',
                        "Товар «{$cartItem->product->name}» більше недоступний. Видаліть його з кошика, щоб продовжити."
                    );
            }

            if ($cartItem->product->stock < $cartItem->quantity) {
                Log::warning('Order creation blocked due to insufficient stock.', [
                    'user_id' => auth()->id(),
                    'product_id' => $cartItem->product_id,
                    'requested_quantity' => $cartItem->quantity,
                    'available_stock' => $cartItem->product->stock,
                ]);
                
                return redirect()
                    ->route('cart.index')
                    ->with(
                        'error',
                        "Товар «{$cartItem->product->name}» має недостатню кількість на складі. Оновіть кількість у кошику."
                    );
            }
        }

        $order = DB::transaction(function () use ($validated, $cartItems) {
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

            return $order;
        });
        
        $order->load('items.product');

        Mail::to($order->customer_email)
            ->queue(new OrderConfirmation($order));
        
        Log::info('Order created successfully.', [
            'order_id' => $order->id,
            'user_id' => $order->user_id,
            'total' => $order->total,
        ]);    

        return redirect()
            ->route('cart.index')
            ->with('success', 'Order created successfully.');
    }
}