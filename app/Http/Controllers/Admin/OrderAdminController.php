<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderStatusHistory;
use App\Services\WhatsAppService;
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
        $order->load(['user', 'items.product.translations', 'statusHistory.changedBy', 'whatsappMessages']);

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
            'notes' => $request->input('notes', 'Status changed by admin'),
            'changed_by' => auth()->id(),
        ]);

        // Send WhatsApp notification to customer
        $whatsappSent = false;
        try {
            $order->load('items');
            $whatsapp = new WhatsAppService();

            if ($validated['status'] === 'delivered') {
                $whatsappSent = $whatsapp->sendDeliveryNotification($order);
            } else {
                $whatsappSent = $whatsapp->sendStatusUpdate($order, $validated['status']);
            }
        } catch (\Exception $e) {
            \Log::error('WhatsApp status notification failed: ' . $e->getMessage());
        }

        $message = 'Order status updated to ' . ucfirst($validated['status']) . '!';
        if ($whatsappSent) {
            $message .= ' WhatsApp notification sent to customer.';
        }

        return back()->with('success', $message);
    }
}
