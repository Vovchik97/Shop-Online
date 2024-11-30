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
        ]);

        $cartItem = Cart::updateOrCreate(
          [
              'user_id' => auth()->id(),
              'product_id' => $request->product_id,
          ],
          [
              'quantity' => DB::raw('quantity + 1'),
          ]
        );

        return redirect()->route('cart.index')->with('success', 'Товар добавлен в корзину');
    }

    public function destroy(Cart $cartItem)
    {
        $cartItem->delete();
        return redirect()->route('cart.index')->with('success', 'Товар удален из корзины');
    }
}
