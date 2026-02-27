@extends('layouts.app')

@section('title', __('Track Your Order'))

@section('content')
    <div class="bg-gradient-to-r from-primary-500 to-blue-600 text-white py-16">
        <div class="container mx-auto px-4 text-center">
            <div class="text-6xl mb-6"><i class="fas fa-map-marked-alt"></i></div>
            <h1 class="text-5xl font-extrabold mb-4">{{ __('Track Your Order') }}</h1>
            <p class="text-xl text-blue-100">{{ __('Enter your order details to check status') }}</p>
        </div>
    </div>

    <div class="container mx-auto px-4 py-16">
        <div class="max-w-2xl mx-auto">
            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 px-6 py-4 rounded-lg mb-6 animate__animated animate__fadeIn">
                    <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-2xl p-10">
                <div class="text-center mb-8">
                    <div class="w-20 h-20 gradient-primary rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-search text-white text-3xl"></i>
                    </div>
                    <h2 class="text-3xl font-bold mb-2">{{ __('Find Your Order') }}</h2>
                    <p class="text-gray-600">{{ __('Enter your order number and email to track') }}</p>
                </div>

                <form action="{{ route('orders.track.search') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">
                            <i class="fas fa-hashtag mr-2 text-primary-500"></i>{{ __('Order Number') }} *
                        </label>
                        <input type="text"
                               name="order_number"
                               value="{{ old('order_number') }}"
                               placeholder="ORD-XXXXXXXXX"
                               required
                               class="w-full px-6 py-4 border-2 border-gray-300 rounded-xl text-lg focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-200">
                        @error('order_number')
                            <span class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">
                            <i class="fas fa-envelope mr-2 text-primary-500"></i>{{ __('Email Address') }} *
                        </label>
                        <input type="email"
                               name="email"
                               value="{{ old('email') }}"
                               placeholder="your@email.com"
                               required
                               class="w-full px-6 py-4 border-2 border-gray-300 rounded-xl text-lg focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-200">
                        @error('email')
                            <span class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="w-full bg-gradient-to-r from-primary-500 to-blue-600 hover:from-primary-600 hover:to-blue-700 text-white font-bold py-4 rounded-xl transition shadow-lg hover:shadow-xl text-lg">
                        <i class="fas fa-search mr-2"></i>{{ __('Track Order') }}
                    </button>
                </form>

                <div class="mt-8 pt-8 border-t border-gray-200 text-center">
                    <p class="text-sm text-gray-600 mb-4">{{ __('You can find your order number in:') }}</p>
                    <div class="flex justify-center gap-6 text-sm">
                        <span class="flex items-center text-gray-700"><i class="fas fa-envelope text-primary-500 mr-2"></i>{{ __('Confirmation Email') }}</span>
                        <span class="flex items-center text-gray-700"><i class="fab fa-whatsapp text-green-500 mr-2"></i>{{ __('WhatsApp Message') }}</span>
                    </div>
                </div>
            </div>

            <!-- Info Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-12">
                <div class="bg-white rounded-xl p-6 text-center shadow-lg">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-truck text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="font-bold mb-2">{{ __('Fast Delivery') }}</h3>
                    <p class="text-sm text-gray-600">{{ __('2-3 days across Pakistan') }}</p>
                </div>
                <div class="bg-white rounded-xl p-6 text-center shadow-lg">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-headset text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="font-bold mb-2">{{ __('24/7 Support') }}</h3>
                    <p class="text-sm text-gray-600">{{ __('Contact us anytime') }}</p>
                </div>
                <div class="bg-white rounded-xl p-6 text-center shadow-lg">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-shield-alt text-purple-600 text-2xl"></i>
                    </div>
                    <h3 class="font-bold mb-2">{{ __('Secure') }}</h3>
                    <p class="text-sm text-gray-600">{{ __('Safe and reliable') }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
