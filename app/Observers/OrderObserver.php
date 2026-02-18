<?php

namespace App\Observers;

use App\Models\Order;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     */
    public function created(Order $order): void
    {
        // Send WhatsApp confirmation when order is created
        $whatsappService = app(\App\Services\WhatsAppService::class);
        $whatsappService->sendOrderConfirmation($order);
    }

    /**
     * Handle the Order "updated" event.
     */
    public function updated(Order $order): void
    {
        // Check if status changed
        if ($order->wasChanged('status')) {
            $whatsappService = app(\App\Services\WhatsAppService::class);
            $whatsappService->sendStatusUpdate($order, $order->status);

            // Send delivery notification specifically
            if ($order->status === 'delivered') {
                $whatsappService->sendDeliveryNotification($order);
            }
        }
    }

    /**
     * Handle the Order "deleted" event.
     */
    public function deleted(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "restored" event.
     */
    public function restored(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     */
    public function forceDeleted(Order $order): void
    {
        //
    }
}
