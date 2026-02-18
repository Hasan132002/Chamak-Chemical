@extends('layouts.app')

@section('title', __('About Us'))

@section('content')
    <div class="bg-gradient-to-r from-primary-500 to-blue-600 text-white py-16">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-5xl font-extrabold mb-4"><i class="fas fa-info-circle mr-3"></i>{{ __('About Us') }}</h1>
            <p class="text-xl text-blue-100">{{ __('Learn more about Chamak Chemicals') }}</p>
        </div>
    </div>

    <div class="container mx-auto px-4 py-16">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-2xl shadow-lg p-12">
                <div class="text-center mb-12">
                    <div class="w-24 h-24 bg-gradient-primary rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-flask text-5xl text-white"></i>
                    </div>
                    <h2 class="text-4xl font-bold mb-4">Chamak Chemicals</h2>
                    <p class="text-xl text-gray-600">{{ __('Premium Quality Since 2020') }}</p>
                </div>

                <div class="prose max-w-none">
                    <p class="text-lg text-gray-700 leading-relaxed mb-6">
                        {{ __('Chamak Chemicals is your trusted partner for premium chemical products. We specialize in high-quality cleaning and industrial chemicals for both retail and wholesale customers across Pakistan.') }}
                    </p>

                    <h3 class="text-2xl font-bold mb-4 text-primary-500"><i class="fas fa-bullseye mr-2"></i>{{ __('Our Mission') }}</h3>
                    <p class="text-gray-700 mb-6">
                        {{ __('To provide the highest quality chemical products at competitive prices, with exceptional customer service and reliable delivery.') }}
                    </p>

                    <h3 class="text-2xl font-bold mb-4 text-primary-500"><i class="fas fa-award mr-2"></i>{{ __('Why Choose Us?') }}</h3>
                    <ul class="list-none space-y-3 mb-6">
                        <li class="flex items-start"><i class="fas fa-check-circle text-green-500 mr-3 mt-1"></i><span>{{ __('Lab-tested and certified products') }}</span></li>
                        <li class="flex items-start"><i class="fas fa-check-circle text-green-500 mr-3 mt-1"></i><span>{{ __('Fast and reliable delivery across Pakistan') }}</span></li>
                        <li class="flex items-start"><i class="fas fa-check-circle text-green-500 mr-3 mt-1"></i><span>{{ __('Competitive wholesale pricing') }}</span></li>
                        <li class="flex items-start"><i class="fas fa-check-circle text-green-500 mr-3 mt-1"></i><span>{{ __('24/7 customer support') }}</span></li>
                    </ul>
                </div>

                <div class="text-center mt-12">
                    <a href="{{ route('contact') }}" class="inline-block bg-gradient-to-r from-primary-500 to-blue-600 text-white px-8 py-4 rounded-full font-bold hover:shadow-xl transition">
                        <i class="fas fa-phone mr-2"></i>{{ __('Contact Us') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
