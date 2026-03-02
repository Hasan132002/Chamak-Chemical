@extends('layouts.app')

@section('title', __('Partner Information'))

@section('content')
    <div class="bg-gradient-to-r from-secondary-500 to-orange-600 text-white py-8 sm:py-12">
        <div class="container mx-auto px-4 text-center">
            <div class="text-3xl sm:text-5xl mb-3 sm:mb-4"><i class="fas fa-warehouse"></i></div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold mb-3 sm:mb-4">{{ __('Partner Program') }}</h1>
            <p class="text-sm sm:text-base md:text-lg text-orange-100 max-w-2xl mx-auto mb-4 sm:mb-6">{{ __('Special pricing for bulk orders. Join our dealer network today!') }}</p>
            <a href="{{ route('wholesale.register') }}" class="inline-block bg-white text-secondary-500 hover:bg-gray-100 font-bold py-2.5 sm:py-3 px-6 sm:px-8 rounded-full text-sm sm:text-base transition shadow-2xl">
                <i class="fas fa-user-plus mr-2"></i>{{ __('Register as Dealer') }}
            </a>
        </div>
    </div>

    <div class="container mx-auto px-4 py-6 sm:py-10">
        <!-- Benefits -->
        <h2 class="text-xl sm:text-2xl font-extrabold text-center mb-5 sm:mb-8 bg-gradient-to-r from-primary-500 to-blue-600 bg-clip-text text-transparent">
            {{ __('Partner Benefits') }}
        </h2>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-5 mb-8 sm:mb-10">
            <div class="bg-white rounded-xl p-3 sm:p-5 text-center hover-lift shadow-lg">
                <div class="w-14 h-14 bg-gradient-to-br from-amber-400 to-orange-600 rounded-xl flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-percentage text-white text-xl"></i>
                </div>
                <h3 class="font-bold text-base mb-1">{{ __('10% Discount') }}</h3>
                <p class="text-gray-600">{{ __('Bronze Tier - 50+ units') }}</p>
            </div>
            <div class="bg-white rounded-xl p-3 sm:p-5 text-center hover-lift shadow-lg">
                <div class="w-14 h-14 bg-gradient-to-br from-gray-400 to-gray-600 rounded-xl flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-percentage text-white text-xl"></i>
                </div>
                <h3 class="font-bold text-base mb-1">{{ __('15% Discount') }}</h3>
                <p class="text-gray-600">{{ __('Silver Tier - 100+ units') }}</p>
            </div>
            <div class="bg-white rounded-xl p-3 sm:p-5 text-center hover-lift shadow-lg">
                <div class="w-14 h-14 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-xl flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-percentage text-white text-xl"></i>
                </div>
                <h3 class="font-bold text-base mb-1">{{ __('20% Discount') }}</h3>
                <p class="text-gray-600">{{ __('Gold Tier - 200+ units') }}</p>
            </div>
            <div class="bg-white rounded-xl p-3 sm:p-5 text-center hover-lift shadow-lg">
                <div class="w-14 h-14 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-percentage text-white text-xl"></i>
                </div>
                <h3 class="font-bold text-base mb-1">{{ __('25% Discount') }}</h3>
                <p class="text-gray-600">{{ __('Platinum Tier - 500+ units') }}</p>
            </div>
        </div>

        <!-- CTA -->
        <div class="text-center bg-gradient-to-r from-primary-500 to-blue-600 rounded-xl p-5 sm:p-8 text-white">
            <h2 class="text-xl sm:text-2xl font-bold mb-2 sm:mb-3">{{ __('Ready to Get Started?') }}</h2>
            <p class="text-sm sm:text-base mb-4 sm:mb-6 text-blue-100">{{ __('Register now and start saving on bulk orders') }}</p>
            <a href="{{ route('wholesale.register') }}" class="inline-block bg-white text-primary-500 hover:bg-gray-100 font-bold py-3 px-8 rounded-full text-base transition shadow-2xl">
                <i class="fas fa-arrow-right mr-2"></i>{{ __('Register Now') }}
            </a>
        </div>
    </div>
@endsection
