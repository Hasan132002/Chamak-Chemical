@extends('layouts.app')

@section('title', __('Refund Policy'))

@section('content')
    <div class="bg-gray-100 py-4">
        <div class="container mx-auto px-4">
            <nav class="text-sm">
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-primary-500">{{ __('Home') }}</a>
                <span class="mx-2">/</span>
                <span class="text-gray-900">{{ __('Refund Policy') }}</span>
            </nav>
        </div>
    </div>

    <div class="container mx-auto px-4 py-10">
        <div class="bg-white rounded-2xl shadow-lg p-6 sm:p-12 max-w-4xl mx-auto">
            <h1 class="text-3xl sm:text-4xl font-bold mb-8 text-gray-900">{{ __('Refund Policy') }}</h1>

            <div class="prose max-w-none text-gray-700 space-y-6">
                <p>{{ __('Last updated') }}: {{ date('F d, Y') }}</p>

                <h2 class="text-xl font-bold text-gray-900">{{ __('Return Eligibility') }}</h2>
                <p>{{ __('Products may be returned within 7 days of delivery if they are damaged, defective, or incorrect. The product must be unused and in its original packaging.') }}</p>

                <h2 class="text-xl font-bold text-gray-900">{{ __('How to Request a Refund') }}</h2>
                <p>{{ __('To request a refund, please contact our customer support via WhatsApp at +92-300-1234567 or email us at info@chamakchemical.com with your order number and reason for return.') }}</p>

                <h2 class="text-xl font-bold text-gray-900">{{ __('Refund Process') }}</h2>
                <p>{{ __('Once your return is received and inspected, we will notify you of the approval or rejection of your refund. If approved, your refund will be processed within 5-7 business days.') }}</p>

                <h2 class="text-xl font-bold text-gray-900">{{ __('Non-Refundable Items') }}</h2>
                <p>{{ __('Opened chemical products, custom orders, and products damaged due to customer misuse are not eligible for refund.') }}</p>

                <h2 class="text-xl font-bold text-gray-900">{{ __('Contact Us') }}</h2>
                <p>{{ __('For any questions regarding refunds, please contact us at') }} <a href="mailto:info@chamakchemical.com" class="text-primary-500 hover:underline">info@chamakchemical.com</a></p>
            </div>
        </div>
    </div>
@endsection
