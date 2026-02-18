@extends('layouts.app')

@section('title', __('Order Status') . ' - ' . $order->order_number)

@section('content')
    <div class="bg-gradient-to-r from-primary-500 to-blue-600 text-white py-12">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl font-extrabold mb-2">{{ __('Order') }} #{{ $order->order_number }}</h1>
            <p class="text-blue-100">{{ __('Placed on') }} {{ $order->created_at->format('d M, Y h:i A') }}</p>
        </div>
    </div>

    <div class="container mx-auto px-4 py-12">
        <div class="max-w-5xl mx-auto">
            <!-- Current Status Banner -->
            <div class="bg-gradient-to-r from-{{ $order->status === 'delivered' ? 'green' : ($order->status === 'cancelled' ? 'red' : 'blue') }}-500 to-{{ $order->status === 'delivered' ? 'green' : ($order->status === 'cancelled' ? 'red' : 'blue') }}-600 text-white rounded-2xl p-8 mb-8 text-center">
                <div class="text-6xl mb-4">
                    @if($order->status === 'delivered')
                        <i class="fas fa-check-circle"></i>
                    @elseif($order->status === 'cancelled')
                        <i class="fas fa-times-circle"></i>
                    @else
                        <i class="fas fa-shipping-fast"></i>
                    @endif
                </div>
                <h2 class="text-3xl font-bold mb-2">{{ __('Status') }}: {{ ucfirst($order->status) }}</h2>
                <p class="text-lg opacity-90">
                    @if($order->status === 'delivered')
                        {{ __('Your order has been delivered successfully!') }}
                    @elseif($order->status === 'cancelled')
                        {{ __('This order has been cancelled.') }}
                    @elseif($order->status === 'shipped')
                        {{ __('Your order is on the way!') }}
                    @elseif($order->status === 'processing')
                        {{ __('Your order is being prepared.') }}
                    @else
                        {{ __('Your order is being processed.') }}
                    @endif
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Order Timeline -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
                        <h3 class="text-2xl font-bold mb-6 flex items-center">
                            <i class="fas fa-history mr-3 text-primary-500"></i>{{ __('Order Timeline') }}
                        </h3>

                        <div class="space-y-6">
                            @php
                                $statuses = [
                                    'pending' => ['icon' => 'fa-clock', 'color' => 'yellow'],
                                    'confirmed' => ['icon' => 'fa-check', 'color' => 'blue'],
                                    'processing' => ['icon' => 'fa-cogs', 'color' => 'indigo'],
                                    'packed' => ['icon' => 'fa-box', 'color' => 'purple'],
                                    'shipped' => ['icon' => 'fa-truck', 'color' => 'blue'],
                                    'delivered' => ['icon' => 'fa-check-circle', 'color' => 'green'],
                                ];
                                $currentReached = false;
                            @endphp

                            @foreach($statuses as $statusKey => $statusData)
                                @php
                                    $history = $order->statusHistory->firstWhere('status', $statusKey);
                                    $isActive = $statusKey === $order->status;
                                    $isPast = !$currentReached && !$isActive;
                                    if ($isActive) $currentReached = true;
                                @endphp

                                <div class="flex items-start gap-4 {{ $isPast || $isActive ? '' : 'opacity-30' }}">
                                    <div class="flex-shrink-0">
                                        <div class="w-12 h-12 rounded-full flex items-center justify-center {{ $isPast || $isActive ? 'bg-'.$statusData['color'].'-500' : 'bg-gray-300' }}">
                                            <i class="fas {{ $statusData['icon'] }} text-white text-xl"></i>
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-bold text-lg {{ $isActive ? 'text-'.$statusData['color'].'-600' : '' }}">
                                            {{ ucfirst($statusKey) }}
                                            @if($isActive)
                                                <span class="ml-2 px-3 py-1 bg-{{ $statusData['color'] }}-100 text-{{ $statusData['color'] }}-700 rounded-full text-xs">{{ __('Current') }}</span>
                                            @endif
                                        </h4>
                                        @if($history)
                                            <p class="text-sm text-gray-600">{{ $history->created_at->format('d M, Y h:i A') }}</p>
                                            @if($history->notes)
                                                <p class="text-sm text-gray-500 italic">{{ $history->notes }}</p>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="bg-white rounded-2xl shadow-lg p-8">
                        <h3 class="text-2xl font-bold mb-6 flex items-center">
                            <i class="fas fa-shopping-bag mr-3 text-secondary-500"></i>{{ __('Order Items') }}
                        </h3>

                        <div class="space-y-4">
                            @foreach($order->items as $item)
                                <div class="flex items-center gap-4 pb-4 border-b last:border-b-0">
                                    <div class="flex-1">
                                        <h4 class="font-semibold">{{ $item->product_name_snapshot }}</h4>
                                        <p class="text-sm text-gray-600">{{ __('SKU') }}: {{ $item->sku_snapshot }}</p>
                                        <p class="text-sm text-gray-600">{{ __('Quantity') }}: {{ $item->quantity }}</p>
                                    </div>
                                    <div class="text-right">
                                        <div class="font-bold text-lg">PKR {{ number_format($item->subtotal, 0) }}</div>
                                        <div class="text-sm text-gray-500">PKR {{ number_format($item->unit_price, 0) }} {{ __('each') }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-lg p-8 sticky top-24">
                        <h3 class="text-xl font-bold mb-6 flex items-center">
                            <i class="fas fa-file-invoice mr-2 text-primary-500"></i>{{ __('Order Summary') }}
                        </h3>

                        <div class="space-y-4 mb-6">
                            <div class="flex justify-between pb-3 border-b">
                                <span class="text-gray-600">{{ __('Subtotal') }}</span>
                                <span class="font-bold">PKR {{ number_format($order->subtotal, 0) }}</span>
                            </div>
                            <div class="flex justify-between pb-3 border-b">
                                <span class="text-gray-600">{{ __('Shipping') }}</span>
                                <span class="font-bold">PKR {{ number_format($order->shipping_amount, 0) }}</span>
                            </div>
                            @if($order->discount_amount > 0)
                                <div class="flex justify-between pb-3 border-b text-green-600">
                                    <span>{{ __('Discount') }}</span>
                                    <span class="font-bold">- PKR {{ number_format($order->discount_amount, 0) }}</span>
                                </div>
                            @endif
                            <div class="flex justify-between pt-2">
                                <span class="text-lg font-bold">{{ __('Total') }}</span>
                                <span class="text-2xl font-extrabold text-primary-600">PKR {{ number_format($order->total_amount, 0) }}</span>
                            </div>
                        </div>

                        <!-- Payment Info -->
                        <div class="bg-gray-50 rounded-xl p-4 mb-6">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm text-gray-600">{{ __('Payment Method') }}</span>
                                <span class="font-semibold">{{ $order->payment_method === 'cod' ? __('Cash on Delivery') : __('Bank Transfer') }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">{{ __('Payment Status') }}</span>
                                <span class="px-3 py-1 rounded-full text-xs font-bold {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </div>
                        </div>

                        <!-- Shipping Address -->
                        <div class="bg-blue-50 rounded-xl p-4">
                            <h4 class="font-bold mb-3 flex items-center">
                                <i class="fas fa-map-marker-alt mr-2 text-blue-600"></i>{{ __('Shipping Address') }}
                            </h4>
                            <div class="text-sm text-gray-700">
                                <p class="font-semibold">{{ $order->shipping_address['name'] }}</p>
                                <p>{{ $order->shipping_address['phone'] }}</p>
                                <p>{{ $order->shipping_address['address'] }}</p>
                                <p>{{ $order->shipping_address['city'] }}{{ $order->shipping_address['postal_code'] ? ', ' . $order->shipping_address['postal_code'] : '' }}</p>
                            </div>
                        </div>

                        <div class="mt-6 space-y-3">
                            <a href="{{ route('orders.track') }}" class="block w-full text-center px-6 py-3 border-2 border-primary-500 text-primary-500 hover:bg-primary-500 hover:text-white rounded-xl font-semibold transition">
                                <i class="fas fa-search mr-2"></i>{{ __('Track Another Order') }}
                            </a>
                            <a href="{{ route('home') }}" class="block w-full text-center px-6 py-3 bg-gray-100 hover:bg-gray-200 rounded-xl font-semibold transition">
                                <i class="fas fa-home mr-2"></i>{{ __('Back to Home') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
