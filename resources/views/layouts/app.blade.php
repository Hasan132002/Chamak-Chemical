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
    @php
        $sitePhone = \App\Models\SiteSetting::get('site_phone', '+92-300-1234567');
        $siteEmail = \App\Models\SiteSetting::get('site_email', 'info@chamakchemical.com');
        $siteAddress = \App\Models\SiteSetting::get('site_address', 'Karachi, Pakistan');
        $siteLogo = \App\Models\SiteSetting::get('site_logo');
        $whatsappNumber = \App\Models\SiteSetting::get('whatsapp_number', '+923001234567');
        $whatsappClean = preg_replace('/[^0-9]/', '', $whatsappNumber);
        $facebookUrl = \App\Models\SiteSetting::get('facebook_url', '');
        $instagramUrl = \App\Models\SiteSetting::get('instagram_url', '');
        $twitterUrl = \App\Models\SiteSetting::get('twitter_url', '');
        // Menu & Footer visibility
        $menuHome = \App\Models\SiteSetting::get('menu_show_home', true);
        $menuProducts = \App\Models\SiteSetting::get('menu_show_products', true);
        $menuCategories = \App\Models\SiteSetting::get('menu_show_categories', true);
        $menuDeals = \App\Models\SiteSetting::get('menu_show_deals', true);
        $menuWholesale = \App\Models\SiteSetting::get('menu_show_wholesale', true);
        $menuBlog = \App\Models\SiteSetting::get('menu_show_blog', true);
        $menuContact = \App\Models\SiteSetting::get('menu_show_contact', true);
        $footerProducts = \App\Models\SiteSetting::get('footer_show_products', true);
        $footerCategories = \App\Models\SiteSetting::get('footer_show_categories', true);
        $footerDeals = \App\Models\SiteSetting::get('footer_show_deals', true);
        $footerWholesale = \App\Models\SiteSetting::get('footer_show_wholesale', true);
        $footerBlog = \App\Models\SiteSetting::get('footer_show_blog', true);
        $footerAbout = \App\Models\SiteSetting::get('footer_show_about', true);
        $footerContact = \App\Models\SiteSetting::get('footer_show_contact', true);
        $megaCategories = \App\Models\Category::where('is_active', true)
            ->with(['translations', 'products' => function($q) {
                $q->where('is_active', true)->with(['translations', 'pricing'])->take(4);
            }])
            ->orderBy('sort_order')
            ->take(6)
            ->get();
    @endphp
    <!-- Top Announcement Bar - Marquee -->
    <div class="gradient-secondary text-black py-2 overflow-hidden">
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

    <!-- Header + Mega Menu Wrapper (shared Alpine state) -->
    <div x-data="{
            mobileMenuOpen: false,
            megaOpen: false,
            headerH: 0,
            megaTimer: null,
            openMega() { clearTimeout(this.megaTimer); this.megaOpen = true; },
            closeMega() { this.megaTimer = setTimeout(() => { this.megaOpen = false; }, 250); }
         }"
         x-init="$nextTick(() => headerH = $refs.mainHeader.offsetHeight)"
         @resize.window="headerH = $refs.mainHeader.offsetHeight">

    <!-- Header -->
    <header x-ref="mainHeader" class="bg-white shadow-lg sticky top-0 z-50 border-b-4 border-primary-500">
        <div class="container mx-auto px-4">
            <!-- Top Bar - Hidden on mobile -->
            <div class="hidden md:block border-b border-gray-100 py-3">
                <div class="flex justify-between items-center text-sm">
                    <div class="flex items-center space-x-6">
                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $sitePhone) }}" class="text-gray-600 hover:text-primary-500 transition flex items-center">
                            <i class="fas fa-phone-alt mr-2"></i>
                            <span>{{ $sitePhone }}</span>
                        </a>
                        <a href="mailto:{{ $siteEmail }}" class="text-gray-600 hover:text-primary-500 transition flex items-center">
                            <i class="fas fa-envelope mr-2"></i>
                            <span>{{ $siteEmail }}</span>
                        </a>
                    </div>
                    <div class="flex items-center space-x-4">
                        <!-- Social Icons -->
                        <div class="flex items-center space-x-2 mr-2 border-r border-gray-200 pr-4">
                            @if($facebookUrl)
                            <a href="{{ $facebookUrl }}" target="_blank" class="w-8 h-8 bg-blue-600 hover:bg-blue-700 text-white rounded-full flex items-center justify-center transition text-xs">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            @endif
                            @if($instagramUrl)
                            <a href="{{ $instagramUrl }}" target="_blank" class="w-8 h-8 bg-gradient-to-br from-purple-500 via-pink-500 to-orange-400 hover:opacity-80 text-white rounded-full flex items-center justify-center transition text-xs">
                                <i class="fab fa-instagram"></i>
                            </a>
                            @endif
                            <a href="https://wa.me/{{ $whatsappClean }}" target="_blank" class="w-8 h-8 bg-green-500 hover:bg-green-600 text-white rounded-full flex items-center justify-center transition text-xs">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                        </div>

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
            <nav class="py-3 md:py-4">
                <div class="flex justify-between items-center">
                    <!-- Logo -->
                    <a href="{{ route('home') }}" class="flex items-center space-x-2 sm:space-x-3 group">
                        @if($siteLogo)
                            <img src="{{ asset('storage/' . $siteLogo) }}" alt="Chamak Chemicals" class="h-10 sm:h-12 object-contain group-hover:scale-110 transition">
                        @else
                            <div class="w-10 h-10 sm:w-12 sm:h-12 gradient-primary rounded-xl flex items-center justify-center text-white text-xl sm:text-2xl font-bold shadow-lg group-hover:scale-110 transition">
                                <i class="fas fa-flask"></i>
                            </div>
                        @endif
                        <div>
                            <div class="text-lg sm:text-2xl font-bold text-primary-500">Chamak Chemicals</div>
                            <div class="text-xs text-gray-500 hidden sm:block">Premium Quality Since 2020</div>
                        </div>
                    </a>

                    <!-- Desktop Navigation Links -->
                    <div class="hidden lg:flex items-center space-x-6">
                        @if($menuHome)
                        <a href="{{ route('home') }}" class="text-gray-700 hover:text-primary-500 font-semibold transition relative group flex items-center gap-1.5">
                            <i class="fas fa-home text-xs"></i>{{ __('Home') }}
                            <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary-500 group-hover:w-full transition-all duration-300"></span>
                        </a>
                        @endif

                        @if($menuProducts)
                        <a href="{{ route('products.index') }}" class="text-gray-700 hover:text-primary-500 font-semibold transition relative group flex items-center gap-1.5">
                            <i class="fas fa-box text-xs"></i>{{ __('Products') }}
                            <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary-500 group-hover:w-full transition-all duration-300"></span>
                        </a>
                        @endif

                        @if($menuCategories)
                        <a href="{{ route('categories.index') }}" class="text-gray-700 hover:text-primary-500 font-semibold transition relative group flex items-center gap-1.5">
                            <i class="fas fa-th-large text-xs"></i>{{ __('Categories') }}
                            <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary-500 group-hover:w-full transition-all duration-300"></span>
                        </a>
                        @endif
                        @if($menuDeals)
                        <a href="{{ route('deals.index') }}" class="text-gray-700 hover:text-red-500 font-semibold transition relative group flex items-center gap-1.5">
                            <i class="fas fa-fire text-xs text-red-400"></i>{{ __('Deals') }}
                            <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-red-500 group-hover:w-full transition-all duration-300"></span>
                        </a>
                        @endif
                        @if($menuWholesale)
                        <a href="{{ route('wholesale.info') }}" class="text-gray-700 hover:text-primary-500 font-semibold transition relative group flex items-center gap-1.5">
                            <i class="fas fa-handshake text-xs"></i>{{ __('Wholesale') }}
                            <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary-500 group-hover:w-full transition-all duration-300"></span>
                        </a>
                        @endif
                        @if($menuBlog)
                        <a href="{{ route('blog.index') }}" class="text-gray-700 hover:text-primary-500 font-semibold transition relative group flex items-center gap-1.5">
                            <i class="fas fa-blog text-xs"></i>{{ __('Blog') }}
                            <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary-500 group-hover:w-full transition-all duration-300"></span>
                        </a>
                        @endif
                        @if($menuContact)
                        <a href="{{ route('contact') }}" class="text-gray-700 hover:text-primary-500 font-semibold transition relative group flex items-center gap-1.5">
                            <i class="fas fa-envelope text-xs"></i>{{ __('Contact') }}
                            <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary-500 group-hover:w-full transition-all duration-300"></span>
                        </a>
                        @endif
                    </div>

                    <!-- Cart, Auth & Hamburger -->
                    <div class="flex items-center space-x-2 sm:space-x-4">
                        <livewire:cart-icon />
                        @auth
                            @if(auth()->user()->hasAnyRole(['super_admin', 'manager', 'sales_staff', 'inventory_staff']))
                                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-2 px-3 sm:px-4 py-2 bg-gray-100 rounded-full hover:bg-primary-500 hover:text-white transition">
                                    <i class="fas fa-user-shield"></i>
                                    <span class="hidden md:inline">{{ auth()->user()->name }}</span>
                                </a>
                            @else
                                <a href="{{ route('account.dashboard') }}" class="flex items-center space-x-2 px-3 sm:px-4 py-2 bg-gray-100 rounded-full hover:bg-primary-500 hover:text-white transition">
                                    <i class="fas fa-user"></i>
                                    <span class="hidden md:inline">{{ auth()->user()->name }}</span>
                                </a>
                            @endif
                        @else
                            @if(\App\Models\SiteSetting::get('public_login_enabled', false))
                                <a href="{{ route('login') }}" class="hidden sm:inline-flex px-6 py-2 bg-primary-500 text-white rounded-full font-semibold hover:bg-primary-600 transition shadow-md hover:shadow-lg">
                                    <i class="fas fa-sign-in-alt mr-2"></i>{{ __('Login') }}
                                </a>
                                <a href="{{ route('login') }}" class="sm:hidden p-2 text-primary-500">
                                    <i class="fas fa-sign-in-alt text-xl"></i>
                                </a>
                            @endif
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

        <!-- Mobile Menu Panel (stays inside header for sticky context) -->
        <div x-show="mobileMenuOpen" x-cloak
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="lg:hidden bg-white border-t border-gray-100 shadow-lg max-h-[80vh] overflow-y-auto">
            <div class="container mx-auto px-4 py-4">
                <div class="space-y-1">
                    @if($menuHome)
                    <a href="{{ route('home') }}" class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-primary-50 hover:text-primary-500 font-semibold transition">
                        <i class="fas fa-home mr-3 w-5"></i>{{ __('Home') }}
                    </a>
                    @endif

                    @if($menuProducts)
                    <div x-data="{ productsOpen: false }">
                        <div class="flex items-center">
                            <a href="{{ route('products.index') }}" class="flex-1 block px-4 py-3 rounded-lg text-gray-700 hover:bg-primary-50 hover:text-primary-500 font-semibold transition">
                                <i class="fas fa-box mr-3 w-5"></i>{{ __('Products') }}
                            </a>
                            <button @click="productsOpen = !productsOpen" class="px-3 py-3 text-gray-500 hover:text-primary-500 transition">
                                <i class="fas fa-chevron-down text-xs transition-transform duration-200" :class="productsOpen ? 'rotate-180' : ''"></i>
                            </button>
                        </div>
                        <div x-show="productsOpen" x-cloak
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0"
                             x-transition:enter-end="opacity-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100"
                             x-transition:leave-end="opacity-0"
                             class="ml-8 space-y-1 pb-2">
                            @foreach($megaCategories as $mobileCat)
                                <a href="{{ route('categories.show', $mobileCat->slug) }}" class="flex items-center gap-2 px-3 py-2.5 rounded-lg text-gray-600 hover:bg-primary-50 hover:text-primary-500 text-sm transition">
                                    @if($mobileCat->icon)
                                        <i class="{{ $mobileCat->icon }} text-primary-400 text-xs w-4"></i>
                                    @else
                                        <i class="fas fa-folder text-primary-400 text-xs w-4"></i>
                                    @endif
                                    {{ $mobileCat->translate(app()->getLocale())->name }}
                                </a>
                            @endforeach
                            <a href="{{ route('products.index') }}" class="flex items-center gap-1 px-3 py-2.5 rounded-lg text-primary-500 hover:bg-primary-50 text-sm font-semibold transition">
                                {{ __('View All') }} <i class="fas fa-arrow-right text-xs ml-1"></i>
                            </a>
                        </div>
                    </div>
                    @endif

                    @if($menuCategories)
                    <a href="{{ route('categories.index') }}" class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-primary-50 hover:text-primary-500 font-semibold transition">
                        <i class="fas fa-th-large mr-3 w-5"></i>{{ __('Categories') }}
                    </a>
                    @endif
                    @if($menuDeals)
                    <a href="{{ route('deals.index') }}" class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-red-50 hover:text-red-500 font-semibold transition">
                        <i class="fas fa-fire mr-3 w-5"></i>{{ __('Deals') }}
                    </a>
                    @endif
                    @if($menuWholesale)
                    <a href="{{ route('wholesale.info') }}" class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-primary-50 hover:text-primary-500 font-semibold transition">
                        <i class="fas fa-handshake mr-3 w-5"></i>{{ __('Wholesale') }}
                    </a>
                    @endif
                    @if($menuBlog)
                    <a href="{{ route('blog.index') }}" class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-primary-50 hover:text-primary-500 font-semibold transition">
                        <i class="fas fa-blog mr-3 w-5"></i>{{ __('Blog') }}
                    </a>
                    @endif
                    @if($menuContact)
                    <a href="{{ route('contact') }}" class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-primary-50 hover:text-primary-500 font-semibold transition">
                        <i class="fas fa-envelope mr-3 w-5"></i>{{ __('Contact') }}
                    </a>
                    @endif
                </div>

                <div class="mt-4 pt-4 border-t border-gray-100">
                    <div class="flex items-center space-x-4 mb-3 px-4">
                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $sitePhone) }}" class="text-gray-600 hover:text-primary-500 transition flex items-center text-sm">
                            <i class="fas fa-phone-alt mr-2"></i>{{ $sitePhone }}
                        </a>
                    </div>
                    <div class="flex items-center space-x-3 px-4 mb-3">
                        <a href="{{ route('locale.switch', 'en') }}" class="px-3 py-1 rounded-full text-sm transition {{ app()->getLocale() === 'en' ? 'bg-primary-500 text-white' : 'text-gray-600 bg-gray-100' }}">
                            English
                        </a>
                        <a href="{{ route('locale.switch', 'ur') }}" class="px-3 py-1 rounded-full text-sm transition {{ app()->getLocale() === 'ur' ? 'bg-primary-500 text-white' : 'text-gray-600 bg-gray-100' }}">
                            اردو
                        </a>
                    </div>
                    <!-- Social Icons (Mobile) -->
                    <div class="flex items-center space-x-3 px-4">
                        @if($facebookUrl)
                        <a href="{{ $facebookUrl }}" target="_blank" class="w-9 h-9 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        @endif
                        @if($instagramUrl)
                        <a href="{{ $instagramUrl }}" target="_blank" class="w-9 h-9 bg-gradient-to-br from-purple-500 via-pink-500 to-orange-400 text-white rounded-full flex items-center justify-center text-sm">
                            <i class="fab fa-instagram"></i>
                        </a>
                        @endif
                        <a href="https://wa.me/{{ $whatsappClean }}" target="_blank" class="w-9 h-9 bg-green-500 text-white rounded-full flex items-center justify-center text-sm">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    {{-- Mega Menu commented out for now
    <!-- Mega Menu Backdrop -->
    <div x-show="megaOpen" x-cloak @click="megaOpen = false"
         class="hidden lg:block fixed inset-0 bg-black/20"
         style="z-index: 9998;"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"></div>

    <!-- Desktop Mega Menu Panel -->
    <div x-show="megaOpen" x-cloak
         @mouseenter="openMega()"
         @mouseleave="closeMega()"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-1"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-1"
         class="hidden lg:block fixed left-0 right-0 bg-white shadow-2xl border-t border-gray-100 max-h-[70vh] overflow-y-auto"
         :style="'z-index: 9999; top: ' + headerH + 'px;'">
        <div class="container mx-auto px-4 py-6">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-6">
                @foreach($megaCategories as $megaCat)
                    <div>
                        <a href="{{ route('categories.show', $megaCat->slug) }}" class="flex items-center gap-2 mb-3 group/cat">
                            <div class="w-9 h-9 bg-primary-50 rounded-lg flex items-center justify-center text-primary-500 group-hover/cat:bg-primary-500 group-hover/cat:text-white transition">
                                <i class="{{ $megaCat->icon ?: 'fas fa-folder' }} text-sm"></i>
                            </div>
                            <span class="font-bold text-gray-900 group-hover/cat:text-primary-500 transition text-sm">
                                {{ $megaCat->translate(app()->getLocale())->name }}
                            </span>
                        </a>
                        <ul class="space-y-2">
                            @foreach($megaCat->products as $megaProduct)
                                <li>
                                    <a href="{{ route('products.show', $megaProduct->slug) }}" class="text-gray-500 hover:text-primary-500 text-xs transition flex items-center gap-1.5">
                                        <span class="w-1 h-1 bg-gray-300 rounded-full flex-shrink-0"></span>
                                        {{ Str::limit($megaProduct->translate(app()->getLocale())->name, 30) }}
                                        @if($megaProduct->pricing && $megaProduct->pricing->isSaleActive())
                                            <span class="bg-red-100 text-red-600 px-1.5 py-0.5 rounded text-[10px] font-bold flex-shrink-0">SALE</span>
                                        @endif
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
            <div class="mt-5 pt-4 border-t border-gray-100 flex items-center justify-between">
                <a href="{{ route('products.index') }}" class="text-primary-500 hover:text-primary-600 font-semibold text-sm flex items-center gap-2 transition">
                    <i class="fas fa-th-large"></i>{{ __('View All Products') }}
                    <i class="fas fa-arrow-right text-xs"></i>
                </a>
                <a href="{{ route('categories.index') }}" class="text-gray-500 hover:text-primary-500 font-semibold text-sm flex items-center gap-2 transition">
                    <i class="fas fa-list"></i>{{ __('All Categories') }}
                    <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>
        </div>
    </div>
    --}}

    </div><!-- End Header + Mega Menu Wrapper -->

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
                        <div class="w-10 h-10 gradient-primary rounded-lg flex items-center justify-center">
                            <i class="fas fa-flask text-white text-xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold">Chamak</h3>
                    </div>
                    <p class="text-gray-400 leading-relaxed">{{ __('Your trusted partner for premium chemical products. Quality guaranteed since 2020.') }}</p>
                    <div class="flex space-x-3">
                        @if($facebookUrl)
                        <a href="{{ $facebookUrl }}" target="_blank" class="w-10 h-10 bg-white/10 hover:bg-primary-500 rounded-full flex items-center justify-center transition">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        @endif
                        @if($instagramUrl)
                        <a href="{{ $instagramUrl }}" target="_blank" class="w-10 h-10 bg-white/10 hover:bg-primary-500 rounded-full flex items-center justify-center transition">
                            <i class="fab fa-instagram"></i>
                        </a>
                        @endif
                        @if($twitterUrl)
                        <a href="{{ $twitterUrl }}" target="_blank" class="w-10 h-10 bg-white/10 hover:bg-primary-500 rounded-full flex items-center justify-center transition">
                            <i class="fab fa-twitter"></i>
                        </a>
                        @endif
                        <a href="https://wa.me/{{ $whatsappClean }}" target="_blank" class="w-10 h-10 bg-green-500 hover:bg-green-600 rounded-full flex items-center justify-center transition">
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
                        @if($footerProducts)
                        <li><a href="{{ route('products.index') }}" class="text-gray-400 hover:text-white hover:translate-x-2 inline-block transition"><i class="fas fa-chevron-right mr-2 text-xs"></i>{{ __('Products') }}</a></li>
                        @endif
                        @if($footerCategories)
                        <li><a href="{{ route('categories.index') }}" class="text-gray-400 hover:text-white hover:translate-x-2 inline-block transition"><i class="fas fa-chevron-right mr-2 text-xs"></i>{{ __('Categories') }}</a></li>
                        @endif
                        @if($footerDeals)
                        <li><a href="{{ route('deals.index') }}" class="text-gray-400 hover:text-white hover:translate-x-2 inline-block transition"><i class="fas fa-chevron-right mr-2 text-xs"></i>{{ __('Deals') }}</a></li>
                        @endif
                        @if($footerWholesale)
                        <li><a href="{{ route('wholesale.info') }}" class="text-gray-400 hover:text-white hover:translate-x-2 inline-block transition"><i class="fas fa-chevron-right mr-2 text-xs"></i>{{ __('Wholesale') }}</a></li>
                        @endif
                        @if($footerBlog)
                        <li><a href="{{ route('blog.index') }}" class="text-gray-400 hover:text-white hover:translate-x-2 inline-block transition"><i class="fas fa-chevron-right mr-2 text-xs"></i>{{ __('Blog') }}</a></li>
                        @endif
                        @if($footerAbout)
                        <li><a href="{{ route('about') }}" class="text-gray-400 hover:text-white hover:translate-x-2 inline-block transition"><i class="fas fa-chevron-right mr-2 text-xs"></i>{{ __('About Us') }}</a></li>
                        @endif
                        @if($footerContact)
                        <li><a href="{{ route('contact') }}" class="text-gray-400 hover:text-white hover:translate-x-2 inline-block transition"><i class="fas fa-chevron-right mr-2 text-xs"></i>{{ __('Contact') }}</a></li>
                        @endif
                    </ul>
                </div>

                <!-- Categories -->
                <div>
                    <h4 class="text-lg font-bold mb-6 flex items-center">
                        <i class="fas fa-th-large mr-2 text-secondary-500"></i>
                        {{ __('Categories') }}
                    </h4>
                    @php $footerCatItems = \App\Models\Category::where('is_active', true)->orderBy('sort_order')->take(6)->get(); @endphp
                    <ul class="space-y-3">
                        @foreach($footerCatItems as $footerCat)
                            <li><a href="{{ route('categories.show', $footerCat->slug) }}" class="text-gray-400 hover:text-white hover:translate-x-2 inline-block transition"><i class="fas fa-chevron-right mr-2 text-xs"></i>{{ $footerCat->translate(app()->getLocale())->name }}</a></li>
                        @endforeach
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
                        <button type="submit" class="gradient-secondary hover:opacity-90 px-6 py-3 rounded-r-lg font-semibold transition">
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
                        <a href="{{ route('privacy-policy') }}" class="hover:text-white transition">{{ __('Privacy Policy') }}</a>
                        <a href="{{ route('terms-of-service') }}" class="hover:text-white transition">{{ __('Terms of Service') }}</a>
                        <a href="{{ route('refund-policy') }}" class="hover:text-white transition">{{ __('Refund Policy') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- WhatsApp Float Button -->
    <a href="https://wa.me/{{ $whatsappClean }}" target="_blank"
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
