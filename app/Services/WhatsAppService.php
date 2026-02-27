<?php

namespace App\Services;

use App\Models\Order;
use App\Models\SiteSetting;
use App\Models\WhatsAppMessage;

class WhatsAppService
{
    protected $apiUrl;
    protected $apiToken;
    protected $phoneNumberId;
    protected $adminPhone;

    public function __construct()
    {
        $this->apiUrl = env('WHATSAPP_API_URL', 'https://graph.facebook.com/v17.0');
        $this->apiToken = env('WHATSAPP_API_TOKEN', '');
        $this->phoneNumberId = env('WHATSAPP_PHONE_NUMBER_ID', '');
        $this->adminPhone = env('WHATSAPP_ADMIN_PHONE', '');
    }

    /**
     * Send order confirmation to customer
     */
    public function sendOrderConfirmation(Order $order): bool
    {
        $phone = $order->shipping_address['phone'];
        $message = $this->generateOrderConfirmationMessage($order);

        return $this->sendMessage($phone, $message, 'order_confirmation', $order->id);
    }

    /**
     * Send new order notification to admin
     */
    public function sendAdminNewOrderNotification(Order $order): bool
    {
        $adminPhone = $this->adminPhone ?: preg_replace('/[^0-9]/', '', SiteSetting::get('whatsapp_number', '') ?? '');

        if (empty($adminPhone)) {
            \Log::warning('WhatsApp admin phone not configured, skipping admin notification');
            return false;
        }

        $message = $this->generateAdminNewOrderMessage($order);

        return $this->sendMessage($adminPhone, $message, 'admin_new_order', $order->id);
    }

    /**
     * Send status update to customer
     */
    public function sendStatusUpdate(Order $order, string $status): bool
    {
        $phone = $order->shipping_address['phone'];
        $message = $this->generateStatusUpdateMessage($order, $status);

        return $this->sendMessage($phone, $message, 'status_update', $order->id);
    }

    /**
     * Send delivery notification to customer
     */
    public function sendDeliveryNotification(Order $order): bool
    {
        $phone = $order->shipping_address['phone'];
        $message = $this->generateDeliveryMessage($order);

        return $this->sendMessage($phone, $message, 'delivery', $order->id);
    }

    protected function sendMessage(string $phone, string $message, string $type, ?int $orderId = null): bool
    {
        // For development, just log the message
        if (env('APP_ENV') === 'local' || empty($this->apiToken)) {
            \Log::info("WhatsApp Message: {$type} to {$phone}", ['message' => $message]);

            WhatsAppMessage::create([
                'order_id' => $orderId,
                'phone_number' => $phone,
                'message_type' => $type,
                'message_text' => $message,
                'status' => 'sent',
                'sent_at' => now(),
            ]);

            return true;
        }

        // Production WhatsApp API call
        try {
            $response = \Http::withToken($this->apiToken)
                ->post("{$this->apiUrl}/{$this->phoneNumberId}/messages", [
                    'messaging_product' => 'whatsapp',
                    'to' => $this->formatPhoneNumber($phone),
                    'type' => 'text',
                    'text' => ['body' => $message],
                ]);

            $success = $response->successful();

            WhatsAppMessage::create([
                'order_id' => $orderId,
                'phone_number' => $phone,
                'message_type' => $type,
                'message_text' => $message,
                'status' => $success ? 'sent' : 'failed',
                'api_response' => $response->json(),
                'sent_at' => $success ? now() : null,
            ]);

            return $success;
        } catch (\Exception $e) {
            \Log::error('WhatsApp API Error: ' . $e->getMessage());

            WhatsAppMessage::create([
                'order_id' => $orderId,
                'phone_number' => $phone,
                'message_type' => $type,
                'message_text' => $message,
                'status' => 'failed',
                'api_response' => ['error' => $e->getMessage()],
            ]);

            return false;
        }
    }

    protected function generateOrderConfirmationMessage(Order $order): string
    {
        $itemsList = $order->items->map(function ($item) {
            return "• {$item->product_name_snapshot} x{$item->quantity} - PKR " . number_format($item->subtotal, 0);
        })->join("\n");

        return "🎉 *Order Confirmed!*\n\n"
            . "Order #: *{$order->order_number}*\n"
            . "Date: " . $order->created_at->format('d M, Y h:i A') . "\n\n"
            . "📦 *Items:*\n{$itemsList}\n\n"
            . "💰 *Total: PKR " . number_format($order->total_amount, 0) . "*\n"
            . "💳 Payment: " . ucfirst(str_replace('_', ' ', $order->payment_method)) . "\n\n"
            . "We will process your order shortly.\n"
            . "Thank you for shopping with *Chamak Chemicals*! 🧪";
    }

    protected function generateAdminNewOrderMessage(Order $order): string
    {
        $shipping = $order->shipping_address;
        $itemsList = $order->items->map(function ($item) {
            return "• {$item->product_name_snapshot} x{$item->quantity}";
        })->join("\n");

        return "🔔 *New Order Received!*\n\n"
            . "Order #: *{$order->order_number}*\n"
            . "Date: " . $order->created_at->format('d M, Y h:i A') . "\n\n"
            . "👤 *Customer:*\n"
            . "Name: {$shipping['name']}\n"
            . "Phone: {$shipping['phone']}\n"
            . "City: {$shipping['city']}\n\n"
            . "📦 *Items:*\n{$itemsList}\n\n"
            . "💰 *Total: PKR " . number_format($order->total_amount, 0) . "*\n"
            . "💳 Payment: " . ucfirst(str_replace('_', ' ', $order->payment_method)) . "\n\n"
            . "📍 *Delivery Address:*\n{$shipping['address']}, {$shipping['city']}\n\n"
            . "⚡ Login to admin panel to process this order.";
    }

    protected function generateStatusUpdateMessage(Order $order, string $status): string
    {
        $statusMessages = [
            'confirmed' => '✅ Your order has been confirmed and is being prepared.',
            'processing' => '📦 Your order is being processed.',
            'packed' => '📦 Your order has been packed and ready for shipment.',
            'shipped' => '🚚 Your order has been shipped! It will reach you soon.',
            'delivered' => '✅ Your order has been delivered. Thank you!',
            'cancelled' => '❌ Your order has been cancelled. If you have questions, contact us.',
        ];

        $statusMessage = $statusMessages[$status] ?? 'Order status updated.';

        return "📋 *Order Update*\n\n"
            . "Order #: *{$order->order_number}*\n\n"
            . "{$statusMessage}\n\n"
            . "💰 Total: PKR " . number_format($order->total_amount, 0) . "\n\n"
            . "📞 Contact us: " . SiteSetting::get('contact_phone', '+92-300-1234567') . "\n"
            . "🧪 *Chamak Chemicals*";
    }

    protected function generateDeliveryMessage(Order $order): string
    {
        return "🎉 *Delivered!*\n\n"
            . "Your order *#{$order->order_number}* has been successfully delivered.\n\n"
            . "We hope you're satisfied with our products!\n"
            . "Please rate your experience and share feedback.\n\n"
            . "🛒 Shop again: " . route('products.index') . "\n"
            . "🧪 *Chamak Chemicals* - Quality Guaranteed";
    }

    protected function formatPhoneNumber(string $phone): string
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);

        if (!str_starts_with($phone, '92')) {
            if (str_starts_with($phone, '0')) {
                $phone = '92' . substr($phone, 1);
            } else {
                $phone = '92' . $phone;
            }
        }

        return $phone;
    }
}
