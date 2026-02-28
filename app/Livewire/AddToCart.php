<?php

namespace App\Livewire;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Livewire\Component;

class AddToCart extends Component
{
    public $productId;
    public $quantity = 1;
    public $product;
    public $selectedVariant = null;
    public $currentPrice = 0;
    public $variants = [];

    public function mount($productId)
    {
        $this->productId = $productId;
        $this->product = Product::with('pricing', 'variations')->find($productId);

        // Set default quantity to MOQ if exists
        $this->quantity = $this->product->moq ?? 1;

        // Setup variants (kg/size options)
        $this->variants = $this->getProductVariants();

        // Default to base product (null) if variations exist
        $this->selectedVariant = null;

        $this->updatePrice();
    }

    protected function getProductVariants()
    {
        // Get variations from database
        $variations = $this->product->variations()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        if ($variations->isEmpty()) {
            return []; // No variations, use base product
        }

        $variants = [];
        foreach ($variations as $variation) {
            $variants[$variation->id] = [
                'label' => $variation->size,
                'price' => $variation->retail_price,
            ];
        }

        return $variants;
    }

    public function updatedSelectedVariant()
    {
        $this->updatePrice();
    }

    protected function updatePrice()
    {
        if ($this->selectedVariant && isset($this->variants[$this->selectedVariant])) {
            // Use variation price
            $this->currentPrice = $this->variants[$this->selectedVariant]['price'];
        } else {
            // Use base product price
            $this->currentPrice = $this->product->pricing->getCurrentPrice();
        }
    }

    public function increment()
    {
        $maxStock = $this->product->stock_quantity ?? 9999;
        if ($this->quantity < $maxStock) {
            $this->quantity++;
        }
    }

    public function decrement()
    {
        $minQty = $this->product->moq ?? 1;
        if ($this->quantity > $minQty) {
            $this->quantity--;
        }
    }

    public function addToCart($redirect = false)
    {
        if ($this->product->isOutOfStock()) {
            session()->flash('error', __('Product is out of stock'));
            return;
        }

        $minQty = $this->product->moq ?? 1;
        if ($this->quantity < $minQty) {
            session()->flash('error', __('Minimum order quantity is') . ' ' . $minQty);
            return;
        }

        $maxStock = $this->product->stock_quantity ?? 9999;
        if ($this->quantity > $maxStock) {
            session()->flash('error', __('Insufficient stock'));
            return;
        }

        // Get or create cart
        if (auth()->check()) {
            $cart = Cart::firstOrCreate(
                ['user_id' => auth()->id()],
                ['expires_at' => now()->addDays(7)]
            );
        } else {
            $sessionId = session()->getId();
            $cart = Cart::firstOrCreate(
                ['session_id' => $sessionId],
                ['expires_at' => now()->addDays(7)]
            );
        }

        // Add or update cart item
        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $this->productId)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $this->quantity;
            $cartItem->save();
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $this->productId,
                'quantity' => $this->quantity,
            ]);
        }

        // Dispatch Livewire event + browser event for reliable cart icon update
        $this->dispatch('cart-updated');
        $this->js("window.dispatchEvent(new CustomEvent('cart-count-changed'))");

        if ($redirect) {
            return redirect()->route('checkout.index');
        }

        session()->flash('success', __('Product added to cart successfully!'));
        $this->quantity = $minQty;
    }

    public function render()
    {
        return view('livewire.add-to-cart');
    }
}
