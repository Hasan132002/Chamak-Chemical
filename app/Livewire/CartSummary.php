<?php

namespace App\Livewire;

use App\Models\Cart;
use Livewire\Component;
use Livewire\Attributes\On;

class CartSummary extends Component
{
    public $cart;
    public $subtotal = 0;
    public $shipping = 200;
    public $total = 0;

    public function mount()
    {
        $this->loadCart();
    }

    #[On('cart-updated')]
    public function loadCart()
    {
        if (auth()->check()) {
            $this->cart = Cart::where('user_id', auth()->id())
                ->with(['items.product.pricing'])
                ->first();
        } else {
            $sessionId = session()->getId();
            $this->cart = Cart::where('session_id', $sessionId)
                ->with(['items.product.pricing'])
                ->first();
        }

        $this->calculateTotals();
    }

    protected function calculateTotals()
    {
        if ($this->cart) {
            $this->subtotal = $this->cart->items->sum(function ($item) {
                return $item->quantity * $item->product->pricing->getCurrentPrice();
            });
            $this->total = $this->subtotal + $this->shipping;
        } else {
            $this->subtotal = 0;
            $this->total = 0;
        }
    }

    public function render()
    {
        return view('livewire.cart-summary');
    }
}
