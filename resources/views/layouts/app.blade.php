<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ur' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Chamak Chemicals - Premium Chemical Products')</title>

    <!-- Google Fonts - Modern & Beautiful -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <!-- Animate.css for animations -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <!-- Custom Styles -->
    <style>
        * {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Poppins', sans-serif;
        }
        .gradient-primary {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        }
        .gradient-secondary {
            background: linear-gradient(135deg, #f97316 0%, #fb923c 100%);
        }
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
        /* Mobile menu overlay */
        .mobile-menu-overlay {
            transition: opacity 0.3s ease;
        }
        .mobile-menu-panel {
            transition: transform 0.3s ease;
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>[x-cloak] { display: none !important; }</style>
</head>
<body class="antialiased bg-gray-50">
    <!-- Top Announcement Bar - Marquee -->
    <div class="bg-gradient-secondary text-white py-2 overflow-hidden">
        <div class="marquee-wrap">
            <div class="marquee-track">
                @php $bannerText = \App\Models\SiteSetting::get('delivery_banner_text', __('Special Offer: Free Shipping on Orders Above PKR 5,000!')); @endphp
                <span class="marquee-item"><i class="fas fa-gift mr-2"></i>{{ $bannerText }}<i class="fas fa-truck mx-4"></i></span>
                <span class="marquee-item"><i class="fas fa-gift mr-2"></i>{{ $bannerText }}<i class="fas fa-truck mx-4"></i></span>
                <span class="marquee-item"><i class="fas fa-gift mr-2"></i>{{ $bannerText }}<i class="fas fa-truck mx-4"></i></span>
            </div>
        </div>
    </div>
    <style>
        .marquee-wrap { width: 100%; overflow: hidden; }
        .marquee-track { display: inline-flex; white-space: nowrap; animation: marqueeScroll 18s linear infinite; }
        .marquee-item { display: inline-flex; align-items: center; font-size: 0.8rem; font-weight: 500; padding: 0 1rem; }
        @media (min-width: 640px) { .marquee-item { font-size: 0.875rem; } }
        @keyframes marqueeScroll { 0% { transform: translateX(0); } 100% { transform: translateX(-33.33%); } }
        .marquee-wrap:hover .marquee-track { animation-play-state: paused; }
    </style>

    <!-- Header -->
    <header class="bg-white shadow-lg sticky top-0 z-50 border-b-4 border-primary-500" x-data="{ mobileMenuOpen: false }">
        <div class="container mx-auto px-4">
            <!-- Top Bar - Hidden on mobile -->
            <div class="hidden md:block border-b border-gray-100 py-3">
                <div class="flex justify-between items-center text-sm">
                    <div class="flex items-center space-x-6">
                        <a href="tel:+923001234567" class="text-gray-600 hover:text-primary-500 transition flex items-center">
                            <i class="fas fa-phone-alt mr-2"></i>
                            <span>+92-300-1234567</span>
                        </a>
                        <a href="mailto:info@chamakchemical.com" class="text-gray-600 hover:text-primary-500 transition flex items-center">
                            <i class="fas fa-envelope mr-2"></i>
                            <span>info@chamakchemical.com</span>
                        </a>
                    </div>
                    <div class="flex items-center space-x-4">
                        <!-- Language Switcher -->
                        <a href="{{ route('locale.switch', 'en') }}" class="px-3 py-1 rounded-full transition {{ app()->getLocale() === 'en' ? 'bg-primary-500 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                            <i class="fas fa-globe mr-1"></i> English
                        </a>
                        <a href="{{ route('locale.switch', 'ur') }}" class="px-3 py-1 rounded-full transition {{ app()->getLocale() === 'ur' ? 'bg-primary-500 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                            <i class="fas fa-globe mr-1"></i> اردو
                        </a>
                    </div>
                </div>
            </div>

            <!-- Main Navigation -->
            <nav class="py-3 md:py-5">
                <div class="flex justify-between items-center">
                    <!-- Logo -->
                    <a href="{{ route('home') }}" class="flex items-center space-x-2 sm:space-x-3 group">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-primary rounded-xl flex items-center justify-center text-white text-xl sm:text-2xl font-bold shadow-lg group-hover:scale-110 transition">
                            <i class="fas fa-flask"></i>
                        </div>
                        <div>
                            <div class="text-lg sm:text-2xl font-bold text-primary-500">Chamak Chemicals</div>
                            <div class="text-xs text-gray-500 hidden sm:block">Premium Quality Since 2020</div>
                        </div>
                    </a>

                    <!-- Desktop Navigation Links -->
                    <div class="hidden lg:flex items-center space-x-8">
                        <a href="{{ route('home') }}" class="text-gray-700 hover:text-primary-500 font-semibold transition relative group">
                            {{ __('Home') }}
                            <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary-500 group-hover:w-full transition-all duration-300"></span>
                        </a>
                        <a href="{{ route('products.index') }}" class="text-gray-700 hover:text-primary-500 font-semibold transition relative group">
                            {{ __('Products') }}
                            <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary-500 group-hover:w-full transition-all duration-300"></span>
                        </a>
                        <a href="{{ route('categories.index') }}" class="text-gray-700 hover:text-primary-500 font-semibold transition relative group">
                            {{ __('Categories') }}
                            <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary-500 group-hover:w-full transition-all duration-300"></span>
                        </a>
                        <a href="{{ route('deals.index') }}" class="text-gray-700 hover:text-primary-500 font-semibold transition relative group">
                            {{ __('Deals') }}
                            <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-red-500 group-hover:w-full transition-all duration-300"></span>
                        </a>
                        <a href="{{ route('wholesale.info') }}" class="text-gray-700 hover:text-primary-500 font-semibold transition relative group">
                            {{ __('Wholesale') }}
                            <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary-500 group-hover:w-full transition-all duration-300"></span>
                        </a>
                        <a href="{{ route('blog.index') }}" class="text-gray-700 hover:text-primary-500 font-semibold transition relative group">
                            {{ __('Blog') }}
                            <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary-500 group-hover:w-full transition-all duration-300"></span>
                        </a>
                        <a href="{{ route('contact') }}" class="text-gray-700 hover:text-primary-500 font-semibold transition relative group">
                            {{ __('Contact') }}
                            <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary-500 group-hover:w-full transition-all duration-300"></span>
                        </a>
                    </div>

                    <!-- Cart, Auth & Hamburger -->
                    <div class="flex items-center space-x-2 sm:space-x-4">
                        <livewire:cart-icon />
                        @auth
                            <a href="{{ route('account.dashboard') }}" class="flex items-center space-x-2 px-3 sm:px-4 py-2 bg-gray-100 rounded-full hover:bg-primary-500 hover:text-white transition">
                                <i class="fas fa-user"></i>
                                <span class="hidden md:inline">{{ auth()->user()->name }}</span>
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="hidden sm:inline-flex px-6 py-2 bg-primary-500 text-white rounded-full font-semibold hover:bg-primary-600 transition shadow-md hover:shadow-lg">
                                <i class="fas fa-sign-in-alt mr-2"></i>{{ __('Login') }}
                            </a>
                            <a href="{{ route('login') }}" class="sm:hidden p-2 text-primary-500">
                                <i class="fas fa-sign-in-alt text-xl"></i>
                            </a>
                        @endauth

                        <!-- Hamburger Menu Button -->
                        <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden p-2 rounded-lg hover:bg-gray-100 transition focus:outline-none" aria-label="Toggle menu">
                            <svg x-show="!mobileMenuOpen" class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                            <svg x-show="mobileMenuOpen" x-cloak class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </nav>
        </div>

        <!-- Mobile Menu Panel -->
        <div x-show="mobileMenuOpen" x-cloak
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="lg:hidden bg-white border-t border-gray-100 shadow-lg">
            <div class="container mx-auto px-4 py-4">
                <!-- Mobile Nav Links -->
                <div class="space-y-1">
                    <a href="{{ route('home') }}" class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-primary-50 hover:text-primary-500 font-semibold transition">
                        <i class="fas fa-home mr-3 w-5"></i>{{ __('Home') }}
                    </a>
                    <a href="{{ route('products.index') }}" class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-primary-50 hover:text-primary-500 font-semibold transition">
                        <i class="fas fa-box mr-3 w-5"></i>{{ __('Products') }}
                    </a>
                    <a href="{{ route('categories.index') }}" class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-primary-50 hover:text-primary-500 font-semibold transition">
                        <i class="fas fa-th-large mr-3 w-5"></i>{{ __('Categories') }}
                    </a>
                    <a href="{{ route('deals.index') }}" class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-red-50 hover:text-red-500 font-semibold transition">
                        <i class="fas fa-fire mr-3 w-5"></i>{{ __('Deals') }}
                    </a>
                    <a href="{{ route('wholesale.info') }}" class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-primary-50 hover:text-primary-500 font-semibold transition">
                        <i class="fas fa-handshake mr-3 w-5"></i>{{ __('Wholesale') }}
                    </a>
                    <a href="{{ route('blog.index') }}" class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-primary-50 hover:text-primary-500 font-semibold transition">
                        <i class="fas fa-blog mr-3 w-5"></i>{{ __('Blog') }}
                    </a>
                    <a href="{{ route('contact') }}" class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-primary-50 hover:text-primary-500 font-semibold transition">
                        <i class="fas fa-envelope mr-3 w-5"></i>{{ __('Contact') }}
                    </a>
                </div>

                <!-- Mobile Contact & Language -->
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <div class="flex items-center space-x-4 mb-3 px-4">
                        <a href="tel:+923001234567" class="text-gray-600 hover:text-primary-500 transition flex items-center text-sm">
                            <i class="fas fa-phone-alt mr-2"></i>+92-300-1234567
                        </a>
                    </div>
                    <div class="flex items-center space-x-3 px-4">
                        <a href="{{ route('locale.switch', 'en') }}" class="px-3 py-1 rounded-full text-sm transition {{ app()->getLocale() === 'en' ? 'bg-primary-500 text-white' : 'text-gray-600 bg-gray-100' }}">
                            English
                        </a>
                        <a href="{{ route('locale.switch', 'ur') }}" class="px-3 py-1 rounded-full text-sm transition {{ app()->getLocale() === 'ur' ? 'bg-primary-500 text-white' : 'text-gray-600 bg-gray-100' }}">
                            اردو
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-white mt-10 sm:mt-20">
        <div class="container mx-auto px-4 py-10 sm:py-16">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <!-- About -->
                <div class="space-y-4">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-10 h-10 bg-gradient-primary rounded-lg flex items-center justify-center">
                            <i class="fas fa-flask text-white text-xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold">Chamak</h3>
                    </div>
                    <p class="text-gray-400 leading-relaxed">{{ __('Your trusted partner for premium chemical products. Quality guaranteed since 2020.') }}</p>
                    <div class="flex space-x-3">
                        <a href="#" class="w-10 h-10 bg-white/10 hover:bg-primary-500 rounded-full flex items-center justify-center transition">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-white/10 hover:bg-primary-500 rounded-full flex items-center justify-center transition">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-white/10 hover:bg-primary-500 rounded-full flex items-center justify-center transition">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="https://wa.me/923001234567" class="w-10 h-10 bg-green-500 hover:bg-green-600 rounded-full flex items-center justify-center transition">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-lg font-bold mb-6 flex items-center">
                        <i class="fas fa-link mr-2 text-primary-500"></i>
                        {{ __('Quick Links') }}
                    </h4>
                    <ul class="space-y-3">
                        <li><a href="{{ route('products.index') }}" class="text-gray-400 hover:text-white hover:translate-x-2 inline-block transition"><i class="fas fa-chevron-right mr-2 text-xs"></i>{{ __('Products') }}</a></li>
                        <li><a href="{{ route('categories.index') }}" class="text-gray-400 hover:text-white hover:translate-x-2 inline-block transition"><i class="fas fa-chevron-right mr-2 text-xs"></i>{{ __('Categories') }}</a></li>
                        <li><a href="{{ route('wholesale.info') }}" class="text-gray-400 hover:text-white hover:translate-x-2 inline-block transition"><i class="fas fa-chevron-right mr-2 text-xs"></i>{{ __('Wholesale') }}</a></li>
                        <li><a href="{{ route('about') }}" class="text-gray-400 hover:text-white hover:translate-x-2 inline-block transition"><i class="fas fa-chevron-right mr-2 text-xs"></i>{{ __('About Us') }}</a></li>
                    </ul>
                </div>

                <!-- Categories -->
                <div>
                    <h4 class="text-lg font-bold mb-6 flex items-center">
                        <i class="fas fa-th-large mr-2 text-secondary-500"></i>
                        {{ __('Categories') }}
                    </h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-400 hover:text-white hover:translate-x-2 inline-block transition"><i class="fas fa-chevron-right mr-2 text-xs"></i>{{ __('Washing Powder') }}</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white hover:translate-x-2 inline-block transition"><i class="fas fa-chevron-right mr-2 text-xs"></i>{{ __('Dish Wash') }}</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white hover:translate-x-2 inline-block transition"><i class="fas fa-chevron-right mr-2 text-xs"></i>{{ __('Glass Cleaner') }}</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white hover:translate-x-2 inline-block transition"><i class="fas fa-chevron-right mr-2 text-xs"></i>{{ __('Hospital Chemicals') }}</a></li>
                    </ul>
                </div>

                <!-- Newsletter -->
                <div>
                    <h4 class="text-lg font-bold mb-6 flex items-center">
                        <i class="fas fa-envelope-open-text mr-2 text-secondary-500"></i>
                        {{ __('Newsletter') }}
                    </h4>
                    <p class="text-gray-400 mb-4 text-sm">{{ __('Subscribe for exclusive offers and updates') }}</p>
                    <form action="{{ route('newsletter.subscribe') }}" method="POST" class="flex">
                        @csrf
                        <input type="email" name="email" placeholder="{{ __('Your email') }}" required
                               class="flex-1 px-4 py-3 rounded-l-lg bg-white/10 border border-white/20 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-secondary-500">
                        <button type="submit" class="bg-gradient-secondary hover:opacity-90 px-6 py-3 rounded-r-lg font-semibold transition">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div class="border-t border-gray-700 pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <p class="text-gray-400 text-sm mb-4 md:mb-0">
                        &copy; {{ date('Y') }} Chamak Chemicals. {{ __('All rights reserved.') }}
                    </p>
                    <div class="flex space-x-6 text-sm text-gray-400">
                        <a href="#" class="hover:text-white transition">{{ __('Privacy Policy') }}</a>
                        <a href="#" class="hover:text-white transition">{{ __('Terms of Service') }}</a>
                        <a href="#" class="hover:text-white transition">{{ __('Refund Policy') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- WhatsApp Float Button - Modern Design -->
    <a href="https://wa.me/923001234567" target="_blank"
       class="fixed bottom-6 right-6 bg-gradient-to-r from-green-400 to-green-600 text-white w-16 h-16 rounded-full shadow-2xl hover:scale-110 transition flex items-center justify-center z-50 animate__animated animate__pulse animate__infinite">
        <i class="fab fa-whatsapp text-3xl"></i>
    </a>

    <!-- Back to Top Button -->
    <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})"
            class="fixed bottom-24 right-6 bg-primary-500 text-white w-12 h-12 rounded-full shadow-lg hover:bg-primary-600 transition opacity-0 hover:opacity-100 z-40">
        <i class="fas fa-arrow-up"></i>
    </button>

    @livewireScripts
</body>
</html>
