@extends('layouts.app')

@section('title', __('Contact Us'))

@section('content')
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
                        <div class="w-14 h-14 bg-gradient-primary rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-phone-alt text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-lg mb-1">{{ __('Phone') }}</h3>
                            <a href="tel:+923001234567" class="text-gray-600 hover:text-primary-500">+92-300-1234567</a>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-14 h-14 bg-gradient-secondary rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-envelope text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-lg mb-1">{{ __('Email') }}</h3>
                            <a href="mailto:info@chamakchemical.com" class="text-gray-600 hover:text-primary-500">info@chamakchemical.com</a>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-14 h-14 bg-green-500 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fab fa-whatsapp text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-lg mb-1">{{ __('WhatsApp') }}</h3>
                            <a href="https://wa.me/923001234567" class="text-gray-600 hover:text-green-500">+92-300-1234567</a>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-map-marker-alt text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-lg mb-1">{{ __('Address') }}</h3>
                            <p class="text-gray-600">Karachi, Pakistan</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="bg-white rounded-2xl shadow-lg p-5 sm:p-8">
                <h3 class="text-2xl font-bold mb-6">{{ __('Send us a Message') }}</h3>
                <form class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">{{ __('Name') }}</label>
                        <input type="text" class="w-full px-4 py-3 border-2 rounded-xl focus:outline-none focus:border-primary-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">{{ __('Email') }}</label>
                        <input type="email" class="w-full px-4 py-3 border-2 rounded-xl focus:outline-none focus:border-primary-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">{{ __('Message') }}</label>
                        <textarea rows="5" class="w-full px-4 py-3 border-2 rounded-xl focus:outline-none focus:border-primary-500"></textarea>
                    </div>
                    <button type="submit" class="w-full bg-gradient-to-r from-primary-500 to-blue-600 text-white font-bold py-4 rounded-xl hover:shadow-xl transition">
                        <i class="fas fa-paper-plane mr-2"></i>{{ __('Send Message') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
