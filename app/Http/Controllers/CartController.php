<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::where('user_id', auth()->id())->with('product')->get();
        return view('cart.index', compact('cartItems'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',  // Валидация для количества
        ]);

        // Получаем введённое количество
        $quantity = $request->input('quantity');

        // Проверяем, существует ли товар в корзине
        $cartItem = Cart::where('user_id', auth()->id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($cartItem) {
            // Если товар уже есть в корзине, обновляем количество
            $cartItem->quantity = $quantity;
            $cartItem->save();
        } else {
            // Если товара нет в корзине, добавляем его с количеством
            Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $request->product_id,
                'quantity' => $quantity,
            ]);
        }

        // Сохраняем сообщение в сессии
        session()->flash('success', 'Товар успешно добавлен в корзину!');

        // Возвращаемся на ту же страницу
        return back();
        //return redirect()->route('home')->with('success', 'Товар добавлен в корзину');
    }


    public function destroy(Cart $cartItem)
    {
        $cartItem->delete();
        return redirect()->route('cart.index');
    }
}
