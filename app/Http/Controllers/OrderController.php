<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $userId = auth()->id();
        $cartItems = Cart::where('user_id', $userId)->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Корзина пуста');
        }

        $order = Order::create([
           'user_id' => $userId,
           'total_price' => $cartItems->sum(fn ($item) => $item->product->price * $item->quantity),
            'status' => 'pending',
        ]);

        foreach ($cartItems as $item) {
            $order->products()->attach($item->product_id, [
                'quantity' => $item->quantity,
                'price' => $item->product->price
            ]);
        }

        Cart::where('user_id', $userId)->delete();

        return redirect()->route('home')->with('success', 'Заказ успешно оформлен');
    }

    public function history()
    {
        $orders = Order::where('user_id', auth()->id())
            ->with('products')
            ->orderByDesc('created_at')
            ->get();

        $totalOrders = $orders->count();

        $orders = $orders->map(function ($order, $index) use ($totalOrders) {
            $order->order_number = $totalOrders - $index;
            return $order;
        });

        return view('orders.history', compact('orders'));
    }
}
