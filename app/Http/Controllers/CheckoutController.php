<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatusHistory;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        // Get cart for authenticated or guest user
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

        if (!$cart || $cart->items->count() === 0) {
            return redirect()->route('cart.index')->with('error', __('Your cart is empty'));
        }

        return view('checkout.index', compact('cart'));
    }

    public function process(Request $request)
    {
        $validated = $request->validate([
            'shipping_name' => 'required|string|max:255',
            'shipping_email' => 'required|email|max:255',
            'shipping_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string',
            'shipping_city' => 'required|string|max:100',
            'shipping_postal_code' => 'nullable|string|max:20',
            'payment_method' => 'required|in:cod,bank_transfer',
            'notes' => 'nullable|string',
        ]);

        // Get cart for authenticated or guest user
        if (auth()->check()) {
            $cart = Cart::where('user_id', auth()->id())
                ->with(['items.product.pricing'])
                ->first();
            $userId = auth()->id();
        } else {
            $sessionId = session()->getId();
            $cart = Cart::where('session_id', $sessionId)
                ->with(['items.product.pricing'])
                ->first();

            // Create guest user account
            $user = \App\Models\User::firstOrCreate(
                ['email' => $validated['shipping_email']],
                [
                    'name' => $validated['shipping_name'],
                    'password' => \Hash::make(\Str::random(16)),
                    'phone' => $validated['shipping_phone'],
                    'is_active' => true,
                ]
            );
            $user->assignRole('customer');
            $userId = $user->id;
        }

        if (!$cart || $cart->items->count() === 0) {
            return redirect()->route('cart.index')->with('error', __('Your cart is empty'));
        }

        DB::beginTransaction();
        try {
            // Calculate totals
            $subtotal = $cart->getTotal();
            $shippingAmount = 200; // Fixed for now
            $taxAmount = 0;
            $discountAmount = 0;
            $totalAmount = $subtotal + $shippingAmount + $taxAmount - $discountAmount;

            // Create order
            $order = Order::create([
                'user_id' => $userId,
                'order_type' => 'retail',
                'status' => 'pending',
                'payment_method' => $validated['payment_method'],
                'payment_status' => 'pending',
                'subtotal' => $subtotal,
                'discount_amount' => $discountAmount,
                'tax_amount' => $taxAmount,
                'shipping_amount' => $shippingAmount,
                'total_amount' => $totalAmount,
                'currency' => 'PKR',
                'shipping_address' => [
                    'name' => $validated['shipping_name'],
                    'email' => $validated['shipping_email'],
                    'phone' => $validated['shipping_phone'],
                    'address' => $validated['shipping_address'],
                    'city' => $validated['shipping_city'],
                    'postal_code' => $validated['shipping_postal_code'] ?? '',
                ],
                'billing_address' => [
                    'name' => $validated['shipping_name'],
                    'email' => $validated['shipping_email'],
                    'phone' => $validated['shipping_phone'],
                    'address' => $validated['shipping_address'],
                    'city' => $validated['shipping_city'],
                    'postal_code' => $validated['shipping_postal_code'] ?? '',
                ],
                'notes' => $validated['notes'],
            ]);

            // Create order items
            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_name_snapshot' => $item->product->translate('en')->name,
                    'sku_snapshot' => $item->product->sku,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->product->pricing->getCurrentPrice(),
                    'subtotal' => $item->product->pricing->getCurrentPrice() * $item->quantity,
                ]);

                // Update stock
                $item->product->decrement('stock_quantity', $item->quantity);
            }

            // Create status history
            OrderStatusHistory::create([
                'order_id' => $order->id,
                'status' => 'pending',
                'notes' => 'Order created',
                'changed_by' => $userId,
            ]);

            // Clear cart
            $cart->items()->delete();
            $cart->delete();

            DB::commit();

            // Send WhatsApp notifications (after commit, so order is saved)
            try {
                $order->load('items');
                $whatsapp = new WhatsAppService();

                // Send confirmation to customer
                $whatsapp->sendOrderConfirmation($order);

                // Send notification to admin
                $whatsapp->sendAdminNewOrderNotification($order);
            } catch (\Exception $e) {
                \Log::error('WhatsApp notification failed: ' . $e->getMessage());
            }

            return redirect()->route('checkout.success', $order->id)->with('success', __('Order placed successfully!'));
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Checkout Error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()
                ->with('error', __('Error processing order') . ': ' . $e->getMessage())
                ->withInput();
        }
    }

    public function success(Order $order)
    {
        // Allow viewing if user owns the order or if it's in session (guest order)
        if (auth()->check() && $order->user_id !== auth()->id()) {
            abort(403);
        }

        return view('checkout.success', compact('order'));
    }
}
