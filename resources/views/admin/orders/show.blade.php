@extends('admin.layout')

@section('title', 'Order Details')
@section('page-title', 'Order #' . $order->order_number)
@section('page-description', 'View complete order information')

@section('content')
<div class="animate-slide-in">
    <!-- Back Button -->
    <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-semibold mb-6">
        <i class="fas fa-arrow-left mr-2"></i>Back to Orders
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Order Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Order Items -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-shopping-cart text-blue-500 mr-3"></i>
                    Order Items
                </h3>

                <div class="space-y-4">
                    @foreach($order->items as $item)
                        @php
                            $translation = $item->product->translations->where('locale', 'en')->first();
                        @endphp
                        <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl">
                            <div class="w-16 h-16 rounded-lg flex items-center justify-center" style="background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);">
                                <i class="fas fa-box text-2xl text-indigo-400"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-bold text-gray-900">{{ $translation->name ?? 'N/A' }}</h4>
                                <p class="text-sm text-gray-600">SKU: {{ $item->product->sku }}</p>
                                <p class="text-sm text-gray-600">Quantity: {{ $item->quantity }} × PKR {{ number_format($item->unit_price, 0) }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-bold text-green-600">PKR {{ number_format($item->subtotal, 0) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Order Total -->
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <div class="space-y-2">
                        <div class="flex justify-between text-gray-600">
                            <span>Subtotal:</span>
                            <span class="font-semibold">PKR {{ number_format($order->items->sum('subtotal'), 0) }}</span>
                        </div>
                        @if($order->shipping_cost > 0)
                        <div class="flex justify-between text-gray-600">
                            <span>Shipping:</span>
                            <span class="font-semibold">PKR {{ number_format($order->shipping_cost, 0) }}</span>
                        </div>
                        @endif
                        @if($order->discount_amount > 0)
                        <div class="flex justify-between text-green-600">
                            <span>Discount:</span>
                            <span class="font-semibold">- PKR {{ number_format($order->discount_amount, 0) }}</span>
                        </div>
                        @endif
                        <div class="flex justify-between text-xl font-bold text-gray-900 pt-2 border-t border-gray-200">
                            <span>Total:</span>
                            <span class="text-green-600">PKR {{ number_format($order->total_amount, 0) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Shipping Address -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-map-marker-alt text-red-500 mr-3"></i>
                    Shipping Address
                </h3>

                <div class="bg-gray-50 rounded-xl p-4">
                    @php
                        $shipping = is_array($order->shipping_address) ? $order->shipping_address : json_decode($order->shipping_address, true);
                    @endphp
                    <p class="font-semibold text-gray-900">{{ $shipping['name'] ?? 'N/A' }}</p>
                    <p class="text-gray-600 mt-1"><i class="fas fa-phone mr-2"></i>{{ $shipping['phone'] ?? 'N/A' }}</p>
                    <p class="text-gray-600 mt-2"><i class="fas fa-map-marker-alt mr-2"></i>{{ $shipping['address'] ?? 'N/A' }}</p>
                    <p class="text-gray-600">{{ $shipping['city'] ?? 'N/A' }}, {{ $shipping['postal_code'] ?? 'N/A' }}</p>
                </div>
            </div>

            <!-- Status History -->
            @if($order->statusHistory && $order->statusHistory->count() > 0)
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-history text-purple-500 mr-3"></i>
                    Status History
                </h3>

                <div class="space-y-4">
                    @foreach($order->statusHistory as $history)
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0" style="background: linear-gradient(135deg, #a855f7 0%, #9333ea 100%);">
                                <i class="fas fa-check text-white"></i>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-bold">
                                        {{ ucfirst($history->status) }}
                                    </span>
                                    <span class="text-sm text-gray-500">{{ $history->created_at->format('d M, Y h:i A') }}</span>
                                </div>
                                @if($history->notes)
                                    <p class="text-sm text-gray-600 mt-1">{{ $history->notes }}</p>
                                @endif
                                @if($history->changedBy)
                                    <p class="text-xs text-gray-500 mt-1">By: {{ $history->changedBy->name }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Order Status -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-info-circle text-blue-500 mr-3"></i>
                    Order Status
                </h3>

                <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Update Status</label>
                        <select name="status" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ $order->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="packed" {{ $order->status === 'packed' ? 'selected' : '' }}>Packed</option>
                            <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>

                    <button type="submit" class="w-full px-4 py-3 rounded-xl text-white font-bold shadow-lg hover-lift" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
                        <i class="fas fa-sync mr-2"></i>Update Status
                    </button>
                </form>
            </div>

            <!-- Customer Info -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-user text-green-500 mr-3"></i>
                    Customer Info
                </h3>

                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-600">Name</p>
                        <p class="font-semibold text-gray-900">{{ $order->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Email</p>
                        <p class="font-semibold text-gray-900">{{ $order->user->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Phone</p>
                        <p class="font-semibold text-gray-900">{{ $order->user->phone ?? 'N/A' }}</p>
                    </div>
                </div>

                <div class="mt-4 pt-4 border-t border-gray-200">
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->user->phone ?? '') }}" target="_blank" class="block w-full px-4 py-3 bg-green-500 hover:bg-green-600 text-white text-center font-semibold rounded-lg transition">
                        <i class="fab fa-whatsapp mr-2"></i>WhatsApp Customer
                    </a>
                </div>
            </div>

            <!-- Payment Info -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-credit-card text-orange-500 mr-3"></i>
                    Payment Info
                </h3>

                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Method:</span>
                        <span class="px-3 py-1 rounded-full text-xs font-bold {{ $order->payment_method === 'cod' ? 'bg-orange-100 text-orange-700' : 'bg-green-100 text-green-700' }}">
                            {{ strtoupper($order->payment_method) }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Payment Status:</span>
                        <span class="px-3 py-1 rounded-full text-xs font-bold {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                            {{ ucfirst($order->payment_status ?? 'Pending') }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-bolt text-yellow-500 mr-3"></i>
                    Quick Actions
                </h3>

                <div class="space-y-3">
                    <button onclick="window.print()" class="w-full px-4 py-3 bg-purple-500 hover:bg-purple-600 text-white font-semibold rounded-lg transition">
                        <i class="fas fa-print mr-2"></i>Print Invoice
                    </button>
                    <button class="w-full px-4 py-3 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-lg transition">
                        <i class="fas fa-envelope mr-2"></i>Email Customer
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
