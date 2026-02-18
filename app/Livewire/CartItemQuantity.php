<?php

namespace App\Livewire;

use App\Models\CartItem;
use Livewire\Component;

class CartItemQuantity extends Component
{
    public $cartItemId;
    public $quantity;
    public $cartItem;

    public function mount($cartItemId)
    {
        $this->cartItemId = $cartItemId;
        $this->cartItem = CartItem::with('product')->find($cartItemId);
        $this->quantity = $this->cartItem->quantity;
    }

    public function increment()
    {
        if ($this->quantity < $this->cartItem->product->stock_quantity) {
            $this->quantity++;
            $this->updateQuantity();
        }
    }

    public function decrement()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
            $this->updateQuantity();
        }
    }

    public function updateQuantity()
    {
        $this->cartItem->refresh(); // Refresh to get latest data
        $this->cartItem->update(['quantity' => $this->quantity]);
        $this->dispatch('cart-updated');
    }

    public function remove()
    {
        $this->cartItem->delete();
        $this->dispatch('cart-updated');
        return redirect()->route('cart.index');
    }

    public function render()
    {
        return view('livewire.cart-item-quantity');
    }
}
