<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderTrackingController extends Controller
{
    public function index()
    {
        return view('orders.track');
    }

    public function track(Request $request)
    {
        $request->validate([
            'order_number' => 'required|string',
            'email' => 'required|email',
        ]);

        $order = Order::where('order_number', $request->order_number)
            ->with(['items.product.translations', 'statusHistory.changedBy'])
            ->first();

        if (!$order) {
            return back()->with('error', __('Order not found. Please check your order number.'));
        }

        // Verify email matches
        $orderEmail = $order->shipping_address['email'] ?? $order->user->email ?? null;

        if ($orderEmail !== $request->email) {
            return back()->with('error', __('Email does not match order records.'));
        }

        return view('orders.status', compact('order'));
    }
}
