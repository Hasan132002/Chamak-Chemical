@extends('layouts.app')

@section('title', __('Checkout'))

@section('content')
    <div class="bg-gray-100 py-4">
        <div class="container mx-auto px-4">
            <nav class="text-sm">
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-primary-500">{{ __('Home') }}</a>
                <span class="mx-2">/</span>
                <a href="{{ route('cart.index') }}" class="text-gray-600 hover:text-primary-500">{{ __('Cart') }}</a>
                <span class="mx-2">/</span>
                <span class="text-gray-900">{{ __('Checkout') }}</span>
            </nav>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-8">{{ __('Checkout') }}</h1>

        <!-- Error/Success Messages -->
        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 px-6 py-4 rounded-lg mb-6 animate__animated animate__fadeIn">
                <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 px-6 py-4 rounded-lg mb-6">
                <div class="font-bold mb-2"><i class="fas fa-exclamation-triangle mr-2"></i>{{ __('Please fix the following errors:') }}</div>
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Checkout Form -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Shipping Information -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-bold mb-6">{{ __('Shipping Information') }}</h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium mb-2">{{ __('Full Name') }} *</label>
                                <input type="text" name="shipping_name" value="{{ old('shipping_name', auth()->user()->name ?? '') }}" required
                                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                                @error('shipping_name')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium mb-2">{{ __('Email Address') }} *</label>
                                <input type="email" name="shipping_email" value="{{ old('shipping_email', auth()->user()->email ?? '') }}" required
                                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                                @error('shipping_email')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-2">{{ __('Phone Number') }} *</label>
                                <input type="tel" name="shipping_phone" value="{{ old('shipping_phone', auth()->user()->phone ?? '') }}" required
                                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                                @error('shipping_phone')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-2">{{ __('City') }} *</label>
                                <input type="text" name="shipping_city" value="{{ old('shipping_city') }}" required
                                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                                @error('shipping_city')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium mb-2">{{ __('Address') }} *</label>
                                <textarea name="shipping_address" rows="3" required
                                          class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">{{ old('shipping_address') }}</textarea>
                                @error('shipping_address')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-2">{{ __('Postal Code') }}</label>
                                <input type="text" name="shipping_postal_code" value="{{ old('shipping_postal_code') }}"
                                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-bold mb-6">{{ __('Payment Method') }}</h2>

                        <div class="space-y-4">
                            <label class="flex items-start gap-3 p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-primary-500">
                                <input type="radio" name="payment_method" value="cod" checked class="mt-1">
                                <div>
                                    <div class="font-semibold">{{ __('Cash on Delivery (COD)') }}</div>
                                    <div class="text-sm text-gray-600">{{ __('Pay when you receive the product') }}</div>
                                </div>
                            </label>

                            <label class="flex items-start gap-3 p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-primary-500">
                                <input type="radio" name="payment_method" value="bank_transfer" class="mt-1">
                                <div>
                                    <div class="font-semibold">{{ __('Bank Transfer') }}</div>
                                    <div class="text-sm text-gray-600">{{ __('Transfer to our bank account') }}</div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Order Notes -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <label class="block text-sm font-medium mb-2">{{ __('Order Notes') }} ({{ __('Optional') }})</label>
                        <textarea name="notes" rows="3" placeholder="{{ __('Any special instructions...') }}"
                                  class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">{{ old('notes') }}</textarea>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-md p-6 sticky top-20">
                        <h3 class="font-bold text-lg mb-4">{{ __('Order Summary') }}</h3>

                        <!-- Cart Items -->
                        <div class="space-y-3 mb-6 max-h-64 overflow-y-auto">
                            @foreach($cart->items as $item)
                                <div class="flex justify-between items-start text-sm">
                                    <div class="flex-1">
                                        <div class="font-medium">{{ $item->product->translate(app()->getLocale())->name }}</div>
                                        <div class="text-gray-500">Qty: {{ $item->quantity }}</div>
                                    </div>
                                    <div class="font-semibold">PKR {{ number_format($item->product->pricing->getCurrentPrice() * $item->quantity, 0) }}</div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Totals -->
                        <div class="border-t pt-4 space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">{{ __('Subtotal') }}</span>
                                <span class="font-semibold">PKR {{ number_format($cart->getTotal(), 0) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">{{ __('Shipping') }}</span>
                                <span class="font-semibold">PKR 200</span>
                            </div>
                            <div class="border-t pt-2">
                                <div class="flex justify-between text-lg font-bold">
                                    <span>{{ __('Total') }}</span>
                                    <span class="text-primary-500">PKR {{ number_format($cart->getTotal() + 200, 0) }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Place Order Button -->
                        <button type="submit" class="w-full mt-6 bg-secondary-500 hover:bg-secondary-600 text-white font-semibold py-3 rounded-lg transition">
                            {{ __('Place Order') }}
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
