@extends('layouts.app')

@section('title', __('Terms of Service'))

@section('content')
    <div class="bg-gray-100 py-4">
        <div class="container mx-auto px-4">
            <nav class="text-sm">
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-primary-500">{{ __('Home') }}</a>
                <span class="mx-2">/</span>
                <span class="text-gray-900">{{ __('Terms of Service') }}</span>
            </nav>
        </div>
    </div>

    <div class="container mx-auto px-4 py-10">
        <div class="bg-white rounded-2xl shadow-lg p-6 sm:p-12 max-w-4xl mx-auto">
            <h1 class="text-3xl sm:text-4xl font-bold mb-8 text-gray-900">{{ __('Terms of Service') }}</h1>

            <div class="prose max-w-none text-gray-700 space-y-6">
                <p>{{ __('Last updated') }}: {{ date('F d, Y') }}</p>

                <h2 class="text-xl font-bold text-gray-900">{{ __('Acceptance of Terms') }}</h2>
                <p>{{ __('By accessing and using the Chamak Chemicals website, you accept and agree to be bound by these Terms of Service. If you do not agree with any part of these terms, you may not use our services.') }}</p>

                <h2 class="text-xl font-bold text-gray-900">{{ __('Products and Orders') }}</h2>
                <p>{{ __('All products are subject to availability. We reserve the right to limit quantities, refuse orders, or cancel orders at our discretion. Prices are subject to change without notice.') }}</p>

                <h2 class="text-xl font-bold text-gray-900">{{ __('Payment') }}</h2>
                <p>{{ __('We accept cash on delivery (COD), bank transfer, and other payment methods as displayed during checkout. All payments must be made in Pakistani Rupees (PKR).') }}</p>

                <h2 class="text-xl font-bold text-gray-900">{{ __('Shipping and Delivery') }}</h2>
                <p>{{ __('We deliver across Pakistan within 2-3 business days. Free shipping is available on orders above PKR 5,000. Delivery times may vary based on location and product availability.') }}</p>

                <h2 class="text-xl font-bold text-gray-900">{{ __('Contact Us') }}</h2>
                <p>{{ __('For any questions regarding these Terms of Service, please contact us at') }} <a href="mailto:info@chamakchemical.com" class="text-primary-500 hover:underline">info@chamakchemical.com</a></p>
            </div>
        </div>
    </div>
@endsection
