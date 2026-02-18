@extends('layouts.app')

@section('title', __('Shopping Cart'))

@section('content')
    <!-- Breadcrumb -->
    <div class="bg-gray-100 py-4">
        <div class="container mx-auto px-4">
            <nav class="text-sm">
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-primary-500">{{ __('Home') }}</a>
                <span class="mx-2">/</span>
                <span class="text-gray-900">{{ __('Shopping Cart') }}</span>
            </nav>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-8">{{ __('Shopping Cart') }}</h1>

        @if($cart && $cart->items->count() > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Cart Items -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-md">
                        @foreach($cart->items as $item)
                            <div class="flex items-center gap-4 p-6 border-b last:border-b-0" wire:key="cart-item-{{ $item->id }}">
                                @if($item->product->featured_image)
                                    <img src="{{ asset('storage/' . $item->product->featured_image) }}"
                                         alt="{{ $item->product->translate(app()->getLocale())->name }}"
                                         class="w-24 h-24 object-cover rounded-lg">
                                @else
                                    <div class="w-24 h-24 bg-gradient-to-br from-blue-400 to-purple-600 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-box text-white text-3xl opacity-50"></i>
                                    </div>
                                @endif

                                <div class="flex-1">
                                    <h3 class="font-semibold text-lg mb-1">
                                        <a href="{{ route('products.show', $item->product->slug) }}" class="hover:text-primary-500">
                                            {{ $item->product->translate(app()->getLocale())->name }}
                                        </a>
                                    </h3>
                                    <p class="text-sm text-gray-600 mb-2">{{ __('SKU') }}: {{ $item->product->sku }}</p>
                                    <div class="text-primary-500 font-bold">
                                        PKR {{ number_format($item->product->pricing->getCurrentPrice(), 0) }}
                                    </div>
                                </div>

                                <!-- Quantity -->
                                <div class="flex items-center gap-2">
                                    <livewire:cart-item-quantity :cartItemId="$item->id" :key="'cart-qty-'.$item->id" />
                                </div>

                                <!-- Total -->
                                <div class="text-right">
                                    <div class="font-bold text-lg">
                                        PKR {{ number_format($item->product->pricing->getCurrentPrice() * $item->quantity, 0) }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Cart Summary - Livewire Component for Real-Time Updates -->
                <div class="lg:col-span-1">
                    <livewire:cart-summary />
                </div>
            </div>
        @else
            <!-- Empty Cart -->
            <div class="text-center py-16">
                <div class="text-8xl mb-6">🛒</div>
                <h2 class="text-3xl font-bold mb-4">{{ __('Your cart is empty') }}</h2>
                <p class="text-gray-600 mb-8">{{ __('Add some products to your cart and they will appear here.') }}</p>
                <a href="{{ route('products.index') }}" class="inline-block bg-primary-500 hover:bg-primary-600 text-white font-semibold py-3 px-8 rounded-lg transition">
                    {{ __('Browse Products') }}
                </a>
            </div>
        @endif
    </div>
@endsection
