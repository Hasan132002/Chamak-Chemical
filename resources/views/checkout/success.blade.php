@extends('layouts.app')

@section('title', __('Order Confirmation'))

@section('content')
    <div class="container mx-auto px-4 py-16">
        <div class="max-w-2xl mx-auto text-center">
            <!-- Success Icon -->
            <div class="mb-8">
                <div class="inline-block bg-green-100 rounded-full p-6">
                    <svg class="w-16 h-16 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
            </div>

            <h1 class="text-4xl font-bold mb-4">{{ __('Order Placed Successfully!') }}</h1>
            <p class="text-xl text-gray-600 mb-8">{{ __('Thank you for your order. We will contact you shortly.') }}</p>

            <!-- Order Details Card -->
            <div class="bg-white rounded-lg shadow-md p-8 text-left mb-8">
                <h2 class="text-2xl font-bold mb-6 text-center">{{ __('Order Details') }}</h2>

                <div class="space-y-4">
                    <div class="flex justify-between border-b pb-3">
                        <span class="text-gray-600">{{ __('Order Number') }}</span>
                        <span class="font-bold text-primary-500">{{ $order->order_number }}</span>
                    </div>

                    <div class="flex justify-between border-b pb-3">
                        <span class="text-gray-600">{{ __('Date') }}</span>
                        <span class="font-semibold">{{ $order->created_at->format('d M, Y h:i A') }}</span>
                    </div>

                    <div class="flex justify-between border-b pb-3">
                        <span class="text-gray-600">{{ __('Payment Method') }}</span>
                        <span class="font-semibold">{{ $order->payment_method === 'cod' ? __('Cash on Delivery') : __('Bank Transfer') }}</span>
                    </div>

                    <div class="flex justify-between border-b pb-3">
                        <span class="text-gray-600">{{ __('Total Amount') }}</span>
                        <span class="font-bold text-2xl text-primary-500">PKR {{ number_format($order->total_amount, 0) }}</span>
                    </div>

                    <div class="border-b pb-3">
                        <span class="text-gray-600 block mb-2">{{ __('Shipping Address') }}</span>
                        <div class="font-semibold">
                            {{ $order->shipping_address['name'] }}<br>
                            {{ $order->shipping_address['phone'] }}<br>
                            {{ $order->shipping_address['address'] }}<br>
                            {{ $order->shipping_address['city'] }}
                            @if($order->shipping_address['postal_code'])
                                - {{ $order->shipping_address['postal_code'] }}
                            @endif
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div>
                        <span class="text-gray-600 block mb-3">{{ __('Order Items') }}</span>
                        <div class="space-y-2">
                            @foreach($order->items as $item)
                                <div class="flex justify-between text-sm">
                                    <span>{{ $item->product_name_snapshot }} × {{ $item->quantity }}</span>
                                    <span class="font-semibold">PKR {{ number_format($item->subtotal, 0) }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('products.index') }}" class="bg-primary-500 hover:bg-primary-600 text-white font-semibold py-3 px-8 rounded-lg transition">
                    {{ __('Continue Shopping') }}
                </a>
                <a href="{{ route('account.dashboard') }}" class="border-2 border-primary-500 text-primary-500 hover:bg-primary-500 hover:text-white font-semibold py-3 px-8 rounded-lg transition">
                    {{ __('View My Orders') }}
                </a>
            </div>

            <!-- WhatsApp Notification -->
            <div class="mt-8 bg-green-50 border border-green-200 rounded-lg p-6">
                <div class="flex items-center gap-3">
                    <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                    </svg>
                    <div>
                        <div class="font-semibold text-green-700">{{ __('WhatsApp Confirmation Sent!') }}</div>
                        <div class="text-sm text-green-600">{{ __('You will receive order updates via WhatsApp') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
