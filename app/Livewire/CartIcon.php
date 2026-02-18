<?php

namespace App\Livewire;

use App\Models\Cart;
use Livewire\Component;
use Livewire\Attributes\On;

class CartIcon extends Component
{
    public $itemCount = 0;

    public function mount()
    {
        $this->updateCartCount();
    }

    #[On('cart-updated')]
    public function updateCartCount()
    {
        if (auth()->check()) {
            $cart = Cart::where('user_id', auth()->id())->first();
            $this->itemCount = $cart ? $cart->items()->sum('quantity') : 0;
        } else {
            $sessionId = session()->getId();
            $cart = Cart::where('session_id', $sessionId)->first();
            $this->itemCount = $cart ? $cart->items()->sum('quantity') : 0;
        }
    }

    public function render()
    {
        return view('livewire.cart-icon');
    }
}
