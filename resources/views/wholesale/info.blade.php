@extends('layouts.app')

@section('title', __('Wholesale Information'))

@section('content')
    <div class="bg-gradient-to-r from-secondary-500 to-orange-600 text-white py-12 sm:py-20">
        <div class="container mx-auto px-4 text-center">
            <div class="text-5xl sm:text-7xl mb-4 sm:mb-6"><i class="fas fa-warehouse"></i></div>
            <h1 class="text-3xl sm:text-5xl md:text-6xl font-extrabold mb-4 sm:mb-6">{{ __('Wholesale Program') }}</h1>
            <p class="text-base sm:text-xl md:text-2xl text-orange-100 max-w-2xl mx-auto mb-6 sm:mb-8">{{ __('Special pricing for bulk orders. Join our dealer network today!') }}</p>
            <a href="{{ route('wholesale.register') }}" class="inline-block bg-white text-secondary-500 hover:bg-gray-100 font-bold py-3 sm:py-4 px-8 sm:px-10 rounded-full text-base sm:text-lg transition shadow-2xl">
                <i class="fas fa-user-plus mr-2"></i>{{ __('Register as Dealer') }}
            </a>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8 sm:py-16">
        <!-- Benefits -->
        <h2 class="text-2xl sm:text-4xl font-extrabold text-center mb-8 sm:mb-12 bg-gradient-to-r from-primary-500 to-blue-600 bg-clip-text text-transparent">
            {{ __('Wholesale Benefits') }}
        </h2>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-8 mb-10 sm:mb-16">
            <div class="bg-white rounded-2xl p-4 sm:p-8 text-center hover-lift shadow-lg">
                <div class="w-20 h-20 bg-gradient-to-br from-amber-400 to-orange-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-percentage text-white text-3xl"></i>
                </div>
                <h3 class="font-bold text-xl mb-2">{{ __('10% Discount') }}</h3>
                <p class="text-gray-600">{{ __('Bronze Tier - 50+ units') }}</p>
            </div>
            <div class="bg-white rounded-2xl p-4 sm:p-8 text-center hover-lift shadow-lg">
                <div class="w-20 h-20 bg-gradient-to-br from-gray-400 to-gray-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-percentage text-white text-3xl"></i>
                </div>
                <h3 class="font-bold text-xl mb-2">{{ __('15% Discount') }}</h3>
                <p class="text-gray-600">{{ __('Silver Tier - 100+ units') }}</p>
            </div>
            <div class="bg-white rounded-2xl p-4 sm:p-8 text-center hover-lift shadow-lg">
                <div class="w-20 h-20 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-percentage text-white text-3xl"></i>
                </div>
                <h3 class="font-bold text-xl mb-2">{{ __('20% Discount') }}</h3>
                <p class="text-gray-600">{{ __('Gold Tier - 200+ units') }}</p>
            </div>
            <div class="bg-white rounded-2xl p-4 sm:p-8 text-center hover-lift shadow-lg">
                <div class="w-20 h-20 bg-gradient-to-br from-blue-400 to-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-percentage text-white text-3xl"></i>
                </div>
                <h3 class="font-bold text-xl mb-2">{{ __('25% Discount') }}</h3>
                <p class="text-gray-600">{{ __('Platinum Tier - 500+ units') }}</p>
            </div>
        </div>

        <!-- CTA -->
        <div class="text-center bg-gradient-to-r from-primary-500 to-blue-600 rounded-2xl p-6 sm:p-12 text-white">
            <h2 class="text-2xl sm:text-3xl font-bold mb-3 sm:mb-4">{{ __('Ready to Get Started?') }}</h2>
            <p class="text-base sm:text-xl mb-6 sm:mb-8 text-blue-100">{{ __('Register now and start saving on bulk orders') }}</p>
            <a href="{{ route('wholesale.register') }}" class="inline-block bg-white text-primary-500 hover:bg-gray-100 font-bold py-4 px-10 rounded-full text-lg transition shadow-2xl">
                <i class="fas fa-arrow-right mr-2"></i>{{ __('Register Now') }}
            </a>
        </div>
    </div>
@endsection
