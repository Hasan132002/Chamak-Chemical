<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderStatusHistory;
use Illuminate\Http\Request;

class OrderAdminController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'items'])
            ->latest()
            ->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.product.translations', 'statusHistory.changedBy']);

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,processing,packed,shipped,delivered,cancelled',
        ]);

        $order->update(['status' => $validated['status']]);

        OrderStatusHistory::create([
            'order_id' => $order->id,
            'status' => $validated['status'],
            'notes' => 'Status changed by admin',
            'changed_by' => auth()->id(),
        ]);

        return back()->with('success', 'Order status updated! WhatsApp notification sent.');
    }
}
