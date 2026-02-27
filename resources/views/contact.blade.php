@extends('layouts.app')

@section('title', __('Contact Us'))

@section('content')
    @php
        $sitePhone = \App\Models\SiteSetting::get('site_phone', '+92-300-1234567');
        $siteEmail = \App\Models\SiteSetting::get('site_email', 'info@chamakchemical.com');
        $siteAddress = \App\Models\SiteSetting::get('site_address', 'Karachi, Pakistan');
        $whatsappNumber = \App\Models\SiteSetting::get('whatsapp_number', '+923001234567');
        $whatsappClean = preg_replace('/[^0-9]/', '', $whatsappNumber);
    @endphp

    <div class="bg-gradient-to-r from-primary-500 to-blue-600 text-white py-10 sm:py-16">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-3xl sm:text-5xl font-extrabold mb-3 sm:mb-4"><i class="fas fa-phone-alt mr-2 sm:mr-3"></i>{{ __('Contact Us') }}</h1>
            <p class="text-base sm:text-xl text-blue-100">{{ __('Get in touch with us') }}</p>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8 sm:py-16">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 max-w-6xl mx-auto">
            <!-- Contact Info -->
            <div class="space-y-8">
                <div>
                    <h2 class="text-3xl font-bold mb-6">{{ __('Get In Touch') }}</h2>
                    <p class="text-gray-600 text-lg mb-8">{{ __('We are here to help! Contact us via phone, email, or visit our office.') }}</p>
                </div>

                <div class="space-y-6">
                    <div class="flex items-start gap-4">
                        <div class="w-14 h-14 gradient-primary rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-phone-alt text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-lg mb-1">{{ __('Phone') }}</h3>
                            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $sitePhone) }}" class="text-gray-600 hover:text-primary-500">{{ $sitePhone }}</a>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-14 h-14 gradient-secondary rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-envelope text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-lg mb-1">{{ __('Email') }}</h3>
                            <a href="mailto:{{ $siteEmail }}" class="text-gray-600 hover:text-primary-500">{{ $siteEmail }}</a>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-14 h-14 bg-green-500 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fab fa-whatsapp text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-lg mb-1">{{ __('WhatsApp') }}</h3>
                            <a href="https://wa.me/{{ $whatsappClean }}" class="text-gray-600 hover:text-green-500">{{ $whatsappNumber }}</a>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-map-marker-alt text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-lg mb-1">{{ __('Address') }}</h3>
                            <p class="text-gray-600">{{ $siteAddress }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="bg-white rounded-2xl shadow-lg p-5 sm:p-8">
                <h3 class="text-2xl font-bold mb-6">{{ __('Send us a Message') }}</h3>

                @if(session('success'))
                    <div class="mb-6 bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-lg">
                        <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('contact.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium mb-2">{{ __('Name') }} <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                            class="w-full px-4 py-3 border-2 rounded-xl focus:outline-none focus:border-primary-500 @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">{{ __('Email') }} <span class="text-red-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="w-full px-4 py-3 border-2 rounded-xl focus:outline-none focus:border-primary-500 @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">{{ __('Phone') }}</label>
                        <input type="text" name="phone" value="{{ old('phone') }}"
                            class="w-full px-4 py-3 border-2 rounded-xl focus:outline-none focus:border-primary-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">{{ __('Message') }} <span class="text-red-500">*</span></label>
                        <textarea name="message" rows="5" required
                            class="w-full px-4 py-3 border-2 rounded-xl focus:outline-none focus:border-primary-500 @error('message') border-red-500 @enderror">{{ old('message') }}</textarea>
                        @error('message')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="w-full bg-gradient-to-r from-primary-500 to-blue-600 text-white font-bold py-4 rounded-xl hover:shadow-xl transition">
                        <i class="fas fa-paper-plane mr-2"></i>{{ __('Send Message') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
