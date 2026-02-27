@extends('layouts.app')

@section('title', __('Privacy Policy'))

@section('content')
    <div class="bg-gray-100 py-4">
        <div class="container mx-auto px-4">
            <nav class="text-sm">
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-primary-500">{{ __('Home') }}</a>
                <span class="mx-2">/</span>
                <span class="text-gray-900">{{ __('Privacy Policy') }}</span>
            </nav>
        </div>
    </div>

    <div class="container mx-auto px-4 py-10">
        <div class="bg-white rounded-2xl shadow-lg p-6 sm:p-12 max-w-4xl mx-auto">
            <h1 class="text-3xl sm:text-4xl font-bold mb-8 text-gray-900">{{ __('Privacy Policy') }}</h1>

            <div class="prose max-w-none text-gray-700 space-y-6">
                <p>{{ __('Last updated') }}: {{ date('F d, Y') }}</p>

                <h2 class="text-xl font-bold text-gray-900">{{ __('Information We Collect') }}</h2>
                <p>{{ __('We collect information you provide directly to us, such as when you create an account, place an order, subscribe to our newsletter, or contact us. This information may include your name, email address, phone number, shipping address, and payment information.') }}</p>

                <h2 class="text-xl font-bold text-gray-900">{{ __('How We Use Your Information') }}</h2>
                <p>{{ __('We use the information we collect to process your orders, communicate with you about your orders, send promotional communications (with your consent), improve our services, and comply with legal obligations.') }}</p>

                <h2 class="text-xl font-bold text-gray-900">{{ __('Information Sharing') }}</h2>
                <p>{{ __('We do not sell, trade, or rent your personal information to third parties. We may share your information with trusted service providers who assist us in operating our website, conducting our business, or serving our users.') }}</p>

                <h2 class="text-xl font-bold text-gray-900">{{ __('Data Security') }}</h2>
                <p>{{ __('We implement appropriate security measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction.') }}</p>

                <h2 class="text-xl font-bold text-gray-900">{{ __('Contact Us') }}</h2>
                <p>{{ __('If you have any questions about this Privacy Policy, please contact us at') }} <a href="mailto:info@chamakchemical.com" class="text-primary-500 hover:underline">info@chamakchemical.com</a></p>
            </div>
        </div>
    </div>
@endsection
