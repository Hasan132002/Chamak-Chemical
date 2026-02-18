<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            $cart = Cart::where('user_id', auth()->id())
                ->with(['items.product.translations', 'items.product.pricing'])
                ->first();
        } else {
            $sessionId = session()->getId();
            $cart = Cart::where('session_id', $sessionId)
                ->with(['items.product.translations', 'items.product.pricing'])
                ->first();
        }

        return view('cart.index', compact('cart'));
    }
}
