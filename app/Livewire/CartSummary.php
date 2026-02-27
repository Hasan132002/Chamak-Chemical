<?php

namespace App\Livewire;

use App\Models\Cart;
use App\Models\Coupon;
use Livewire\Component;
use Livewire\Attributes\On;

class CartSummary extends Component
{
    public $cart;
    public $subtotal = 0;
    public $shipping = 200;
    public $discount = 0;
    public $total = 0;
    public $couponCode = '';
    public $couponMessage = '';
    public $couponError = false;
    public $appliedCoupon = null;

    public function mount()
    {
        // Restore coupon from session
        $sessionCoupon = session('applied_coupon');
        if ($sessionCoupon) {
            $this->appliedCoupon = $sessionCoupon;
            $this->couponCode = $sessionCoupon['code'];
        }

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

    public function applyCoupon()
    {
        $this->couponMessage = '';
        $this->couponError = false;

        if (empty(trim($this->couponCode))) {
            $this->couponMessage = __('Please enter a coupon code');
            $this->couponError = true;
            return;
        }

        $coupon = Coupon::where('code', strtoupper(trim($this->couponCode)))->first();

        if (!$coupon) {
            $this->couponMessage = __('Invalid coupon code');
            $this->couponError = true;
            return;
        }

        if (!$coupon->isValid()) {
            $this->couponMessage = __('This coupon has expired or is no longer valid');
            $this->couponError = true;
            return;
        }

        if ($this->subtotal < $coupon->min_order_amount) {
            $this->couponMessage = __('Minimum order amount is PKR') . ' ' . number_format($coupon->min_order_amount, 0);
            $this->couponError = true;
            return;
        }

        $discount = $coupon->calculateDiscount($this->subtotal);

        $this->appliedCoupon = [
            'id' => $coupon->id,
            'code' => $coupon->code,
            'type' => $coupon->type,
            'discount_value' => $coupon->discount_value,
        ];

        session(['applied_coupon' => $this->appliedCoupon]);

        $this->discount = $discount;
        $this->total = $this->subtotal + $this->shipping - $this->discount;
        $this->couponMessage = __('Coupon applied! You save PKR') . ' ' . number_format($discount, 0);
        $this->couponError = false;
    }

    public function removeCoupon()
    {
        $this->appliedCoupon = null;
        $this->couponCode = '';
        $this->discount = 0;
        $this->couponMessage = '';
        $this->couponError = false;
        session()->forget('applied_coupon');
        $this->calculateTotals();
    }

    protected function calculateTotals()
    {
        if ($this->cart) {
            $this->subtotal = $this->cart->items->sum(function ($item) {
                return $item->quantity * $item->product->pricing->getCurrentPrice();
            });

            // Re-apply coupon discount if one is applied
            if ($this->appliedCoupon) {
                $coupon = Coupon::find($this->appliedCoupon['id']);
                if ($coupon && $coupon->isValid()) {
                    $this->discount = $coupon->calculateDiscount($this->subtotal);
                } else {
                    $this->appliedCoupon = null;
                    $this->discount = 0;
                    session()->forget('applied_coupon');
                }
            }

            $this->total = $this->subtotal + $this->shipping - $this->discount;
        } else {
            $this->subtotal = 0;
            $this->discount = 0;
            $this->total = 0;
        }
    }

    public function render()
    {
        return view('livewire.cart-summary');
    }
}
