@extends('layouts.app')

@section('title', __('About Us'))

@section('content')
    <div class="bg-gradient-to-r from-primary-500 to-blue-600 text-white py-8 sm:py-12">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-2xl sm:text-3xl font-extrabold mb-2 sm:mb-3"><i class="fas fa-info-circle mr-2"></i>{{ __('About Us') }}</h1>
            <p class="text-sm sm:text-base text-blue-100">{{ __('Learn more about Chamak Chemicals') }}</p>
        </div>
    </div>

    <div class="container mx-auto px-4 py-6 sm:py-10">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-xl shadow-lg p-5 sm:p-8">
                <div class="text-center mb-8">
                    <div class="w-16 h-16 gradient-primary rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-flask text-3xl text-white"></i>
                    </div>
                    <h2 class="text-xl sm:text-2xl font-bold mb-2">Chamak Chemicals</h2>
                    <p class="text-base text-gray-600">{{ __('Premium Quality Since 2020') }}</p>
                </div>

                <div class="prose max-w-none">
                    <p class="text-base text-gray-700 leading-relaxed mb-4">
                        {{ __('Chamak Chemicals is your trusted partner for premium chemical products. We specialize in high-quality cleaning and industrial chemicals for both retail and dealer customers across Pakistan.') }}
                    </p>

                    <h3 class="text-lg font-bold mb-3 text-primary-500"><i class="fas fa-bullseye mr-2"></i>{{ __('Our Mission') }}</h3>
                    <p class="text-gray-700 mb-6">
                        {{ __('To provide the highest quality chemical products at competitive prices, with exceptional customer service and reliable delivery.') }}
                    </p>

                    <h3 class="text-lg font-bold mb-3 text-primary-500"><i class="fas fa-award mr-2"></i>{{ __('Why Choose Us?') }}</h3>
                    <ul class="list-none space-y-3 mb-6">
                        <li class="flex items-start"><i class="fas fa-check-circle text-green-500 mr-3 mt-1"></i><span>{{ __('Lab-tested and certified products') }}</span></li>
                        <li class="flex items-start"><i class="fas fa-check-circle text-green-500 mr-3 mt-1"></i><span>{{ __('Fast and reliable delivery across Pakistan') }}</span></li>
                        <li class="flex items-start"><i class="fas fa-check-circle text-green-500 mr-3 mt-1"></i><span>{{ __('Competitive dealer pricing') }}</span></li>
                        <li class="flex items-start"><i class="fas fa-check-circle text-green-500 mr-3 mt-1"></i><span>{{ __('24/7 customer support') }}</span></li>
                    </ul>
                </div>

                <div class="text-center mt-8">
                    <a href="{{ route('contact') }}" class="inline-block bg-gradient-to-r from-primary-500 to-blue-600 text-white px-6 py-3 rounded-full font-bold hover:shadow-xl transition text-sm">
                        <i class="fas fa-phone mr-2"></i>{{ __('Contact Us') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
