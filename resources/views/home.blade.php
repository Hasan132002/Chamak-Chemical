@extends('layouts.app')

@section('title', __('Home'))

@section('content')
    <!-- Banner Slider -->
    @if($banners->count() > 0)
    <section class="relative" x-data="{
        currentSlide: 0,
        totalSlides: {{ $banners->count() }},
        autoplay: null,
        init() {
            this.startAutoplay();
        },
        startAutoplay() {
            this.autoplay = setInterval(() => { this.next(); }, 5000);
        },
        stopAutoplay() {
            clearInterval(this.autoplay);
        },
        next() {
            this.currentSlide = (this.currentSlide + 1) % this.totalSlides;
        },
        prev() {
            this.currentSlide = (this.currentSlide - 1 + this.totalSlides) % this.totalSlides;
        },
        goTo(index) {
            this.currentSlide = index;
            this.stopAutoplay();
            this.startAutoplay();
        }
    }" @mouseenter="stopAutoplay()" @mouseleave="startAutoplay()">
        <div class="relative overflow-hidden banner-slider-aspect">
            @foreach($banners as $index => $banner)
                <div class="absolute inset-0 transition-opacity duration-700 ease-in-out"
                     :class="currentSlide === {{ $index }} ? 'opacity-100 z-10' : 'opacity-0 z-0'">
                    <img src="{{ asset('storage/' . $banner->image) }}" alt="{{ $banner->title ?? 'Banner' }}"
                         class="w-full h-full object-cover">
                    <!-- Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-r from-black/60 via-black/30 to-transparent"></div>
                    <!-- Content -->
                    @if($banner->title || $banner->subtitle || $banner->button_text)
                    <div class="absolute inset-0 flex items-center">
                        <div class="container mx-auto px-4 sm:px-8">
                            <div class="max-w-xl">
                                @if($banner->title)
                                    <h2 class="text-2xl sm:text-4xl md:text-6xl font-extrabold text-white mb-2 sm:mb-4 leading-tight">
                                        {{ $banner->title }}
                                    </h2>
                                @endif
                                @if($banner->subtitle)
                                    <p class="text-sm sm:text-lg md:text-2xl text-white/90 mb-4 sm:mb-6">
                                        {{ $banner->subtitle }}
                                    </p>
                                @endif
                                @if($banner->button_text && $banner->button_url)
                                    <a href="{{ $banner->button_url }}"
                                       class="inline-block bg-white text-primary-500 hover:bg-gray-100 font-bold py-3 px-6 sm:py-4 sm:px-8 rounded-xl text-sm sm:text-lg transition shadow-2xl hover-lift">
                                        {{ $banner->button_text }}
                                        <i class="fas fa-arrow-right ml-2"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            @endforeach
        </div>

        <!-- Arrows -->
        @if($banners->count() > 1)
        <button @click="prev(); stopAutoplay(); startAutoplay();"
                class="absolute left-2 sm:left-4 top-1/2 -translate-y-1/2 z-20 bg-white/30 hover:bg-white/60 backdrop-blur-sm text-white hover:text-gray-900 w-10 h-10 sm:w-12 sm:h-12 rounded-full flex items-center justify-center transition shadow-lg">
            <i class="fas fa-chevron-left text-lg"></i>
        </button>
        <button @click="next(); stopAutoplay(); startAutoplay();"
                class="absolute right-2 sm:right-4 top-1/2 -translate-y-1/2 z-20 bg-white/30 hover:bg-white/60 backdrop-blur-sm text-white hover:text-gray-900 w-10 h-10 sm:w-12 sm:h-12 rounded-full flex items-center justify-center transition shadow-lg">
            <i class="fas fa-chevron-right text-lg"></i>
        </button>

        <!-- Dots -->
        <div class="absolute bottom-3 sm:bottom-6 left-1/2 -translate-x-1/2 z-20 flex items-center gap-2">
            @foreach($banners as $index => $banner)
                <button @click="goTo({{ $index }})"
                        class="w-3 h-3 rounded-full transition-all duration-300"
                        :class="currentSlide === {{ $index }} ? 'bg-white w-8' : 'bg-white/50 hover:bg-white/75'">
                </button>
            @endforeach
        </div>
        @endif
    </section>
    @else
    <!-- Fallback Hero Section -->
    <section class="relative overflow-hidden bg-gradient-to-br from-primary-500 via-blue-600 to-primary-700 text-white py-12 sm:py-24">
        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-3xl sm:text-5xl md:text-7xl font-extrabold mb-4 sm:mb-6 leading-tight">
                    {{ __('Premium Chemical Products for Every Need') }}
                </h1>
                <p class="text-base sm:text-xl md:text-2xl mb-6 sm:mb-10 text-blue-100">
                    {{ __('High-quality cleaning and industrial chemicals. Retail and wholesale available.') }}
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{ route('products.index') }}" class="group px-8 py-4 bg-white text-primary-500 hover:bg-gray-100 font-bold rounded-xl transition shadow-2xl hover-lift text-lg">
                        <i class="fas fa-shopping-bag mr-2"></i>{{ __('Shop Now') }}
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                    <a href="{{ route('wholesale.register') }}" class="px-8 py-4 gradient-secondary text-white font-bold rounded-xl transition shadow-2xl hover-lift text-lg">
                        <i class="fas fa-handshake mr-2"></i>{{ __('Wholesale Inquiry') }}
                    </a>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- Hot Deals Section -->
    @if($deals->count() > 0)
    <section class="py-8 sm:py-14 bg-gradient-to-r from-red-50 to-orange-50">
        <div class="container mx-auto px-4">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 sm:mb-10 gap-4">
                <div>
                    <h2 class="text-3xl sm:text-5xl font-extrabold mb-2 bg-gradient-to-r from-red-500 to-orange-600 bg-clip-text text-transparent">
                        <i class="fas fa-fire text-red-500"></i> {{ __('Hot Deals') }}
                    </h2>
                    <p class="text-gray-600 text-sm sm:text-base">{{ __('Don\'t miss our amazing deals and promotions!') }}</p>
                </div>
                <a href="{{ route('deals.index') }}" class="px-5 sm:px-6 py-2 sm:py-3 bg-red-500 text-white rounded-full font-semibold hover:bg-red-600 transition shadow-lg hover-lift text-sm sm:text-base">
                    {{ __('View All Deals') }} <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>

            <!-- Horizontal Scrollable Deals -->
            <div class="flex gap-4 sm:gap-6 overflow-x-auto pb-4 snap-x snap-mandatory scrollbar-hide" style="-webkit-overflow-scrolling: touch;">
                @foreach($deals as $deal)
                    @php $translation = $deal->translate(app()->getLocale()); @endphp
                    <div class="flex-shrink-0 w-72 sm:w-80 snap-start">
                        <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover-lift border-2 border-transparent hover:border-red-500 transition-all h-full">
                            <div class="relative overflow-hidden">
                                @if($deal->image)
                                    <img src="{{ asset('storage/' . $deal->image) }}" alt="{{ $translation->title ?? '' }}" class="w-full h-40 sm:h-48 object-cover hover:scale-110 transition-transform duration-500">
                                @else
                                    <div class="w-full h-40 sm:h-48 bg-gradient-to-br from-red-400 to-orange-500 flex items-center justify-center">
                                        <i class="fas fa-fire text-white text-5xl opacity-50"></i>
                                    </div>
                                @endif
                                @if($deal->discount_percentage)
                                    <div class="absolute top-3 right-3">
                                        <span class="bg-red-600 text-white px-3 py-1.5 rounded-full text-sm font-bold shadow-lg animate-pulse">
                                            {{ number_format($deal->discount_percentage, 0) }}% {{ __('OFF') }}
                                        </span>
                                    </div>
                                @endif
                                @if($deal->ends_at)
                                    <div class="absolute bottom-3 left-3">
                                        <span class="bg-black/70 text-white px-2 py-1 rounded text-xs font-semibold">
                                            <i class="fas fa-clock mr-1"></i>{{ __('Ends') }}: {{ $deal->ends_at->format('d M') }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                            <div class="p-4 sm:p-5">
                                <h3 class="font-bold text-gray-900 mb-1 text-lg">{{ $translation->title ?? '' }}</h3>
                                @if($translation->description)
                                    <p class="text-gray-600 text-sm line-clamp-2 mb-3">{{ $translation->description }}</p>
                                @endif
                                @if($deal->url)
                                    <a href="{{ $deal->url }}" class="inline-flex items-center text-red-500 font-semibold text-sm hover:text-red-600 transition">
                                        {{ __('Shop Now') }} <i class="fas fa-arrow-right ml-2"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Featured Categories - Modern Cards -->
    <section class="py-10 sm:py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-8 sm:mb-16 animate__animated animate__fadeIn">
                <h2 class="text-3xl sm:text-5xl font-extrabold mb-3 sm:mb-4 bg-gradient-to-r from-primary-500 to-blue-600 bg-clip-text text-transparent">
                    {{ __('Product Categories') }}
                </h2>
                <p class="text-gray-600 text-sm sm:text-lg">{{ __('Explore our wide range of chemical products') }}</p>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-6">
                @foreach($categories as $index => $category)
                    <a href="{{ route('categories.show', $category->slug) }}" class="group animate__animated animate__fadeInUp" style="animation-delay: {{ $index * 100 }}ms">
                        <div class="bg-white rounded-2xl shadow-lg p-4 sm:p-8 text-center hover-lift border-2 border-transparent hover:border-primary-500 transition-all">
                            <div class="text-3xl sm:text-5xl mb-3 sm:mb-4 transform group-hover:scale-125 transition-transform">
                                <i class="fas fa-flask text-primary-500"></i>
                            </div>
                            <h3 class="font-bold text-gray-800 group-hover:text-primary-500 transition">
                                {{ $category->translate(app()->getLocale())->name }}
                            </h3>
                            <div class="mt-3 text-xs text-gray-500 flex items-center justify-center">
                                <span>{{ __('View Products') }}</span>
                                <i class="fas fa-arrow-right ml-2 group-hover:translate-x-2 transition"></i>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Featured Products - Premium Design -->
    <section class="py-10 sm:py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 sm:mb-12 gap-4">
                <div>
                    <h2 class="text-3xl sm:text-5xl font-extrabold mb-2 bg-gradient-to-r from-primary-500 to-blue-600 bg-clip-text text-transparent">
                        {{ __('Featured Products') }}
                    </h2>
                    <p class="text-gray-600 text-sm sm:text-base">{{ __('Handpicked bestsellers just for you') }}</p>
                </div>
                <a href="{{ route('products.index') }}" class="px-5 sm:px-6 py-2 sm:py-3 bg-primary-500 text-white rounded-full font-semibold hover:bg-primary-600 transition shadow-lg hover-lift text-sm sm:text-base">
                    {{ __('View All') }} <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-8">
                @foreach($featuredProducts as $index => $product)
                    <div class="group animate__animated animate__fadeInUp hover-lift" style="animation-delay: {{ $index * 100 }}ms">
                        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border-2 border-transparent hover:border-primary-500 transition-all">
                            <div class="relative overflow-hidden">
                                @if($product->pricing->isSaleActive())
                                    <div class="absolute top-3 right-3 z-10">
                                        <span class="gradient-secondary text-white px-3 sm:px-4 py-1.5 sm:py-2 rounded-full text-xs sm:text-sm font-bold shadow-lg animate-pulse">
                                            {{ number_format((($product->pricing->retail_price - $product->pricing->sale_price) / $product->pricing->retail_price) * 100, 0) }}% {{ __('OFF') }}
                                        </span>
                                    </div>
                                @endif
                                <a href="{{ route('products.show', $product->slug) }}">
                                    @if($product->featured_image)
                                        <img src="{{ asset('storage/' . $product->featured_image) }}"
                                             alt="{{ $product->translate(app()->getLocale())->name }}"
                                             class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-64 bg-gradient-to-br from-primary-400 via-blue-500 to-purple-500 flex items-center justify-center group-hover:scale-110 transition-transform duration-500">
                                            <i class="fas fa-flask text-white text-6xl opacity-50"></i>
                                        </div>
                                    @endif
                                </a>
                                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            </div>
                            <div class="p-3 sm:p-6">
                                <div class="text-xs text-gray-500 mb-2 font-semibold uppercase tracking-wider">
                                    <i class="fas fa-tag mr-1"></i>{{ $product->category->translate(app()->getLocale())->name }}
                                </div>
                                <h3 class="font-bold text-lg text-gray-900 mb-3 group-hover:text-primary-500 transition line-clamp-2">
                                    <a href="{{ route('products.show', $product->slug) }}">
                                        {{ $product->translate(app()->getLocale())->name }}
                                    </a>
                                </h3>
                                <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                    {{ $product->translate(app()->getLocale())->short_description }}
                                </p>
                                <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                                    <div>
                                        @if($product->pricing->isSaleActive())
                                            <div class="flex items-center gap-2 mb-1">
                                                <span class="text-gray-400 line-through text-sm">PKR {{ number_format($product->pricing->retail_price, 0) }}</span>
                                                <span class="bg-red-100 text-red-600 px-2 py-0.5 rounded text-xs font-bold">-{{ number_format((($product->pricing->retail_price - $product->pricing->sale_price) / $product->pricing->retail_price) * 100, 0) }}%</span>
                                            </div>
                                            <div class="text-primary-500 font-bold text-xl">PKR {{ number_format($product->pricing->sale_price, 0) }}</div>
                                        @else
                                            <div class="text-primary-500 font-bold text-xl">PKR {{ number_format($product->pricing->retail_price, 0) }}</div>
                                        @endif
                                    </div>
                                    <a href="{{ route('products.show', $product->slug) }}" class="gradient-primary text-white px-5 py-2.5 rounded-lg font-semibold hover:shadow-lg transition group">
                                        <i class="fas fa-eye mr-2"></i>{{ __('View') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Wholesale Banner - Eye-catching -->
    <section class="relative py-12 sm:py-24 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-secondary-500 via-orange-500 to-secondary-600"></div>
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-0 w-96 h-96 bg-white rounded-full filter blur-3xl"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-yellow-300 rounded-full filter blur-3xl"></div>
        </div>
        <div class="container mx-auto px-4 text-center relative z-10">
            <div class="animate__animated animate__fadeIn">
                <div class="text-5xl sm:text-7xl mb-4 sm:mb-6"><i class="fas fa-warehouse text-white/80"></i></div>
                <h2 class="text-3xl sm:text-5xl md:text-6xl font-extrabold mb-4 sm:mb-6 text-white">
                    {{ __('Looking for Wholesale?') }}
                </h2>
                <p class="text-base sm:text-xl md:text-2xl mb-6 sm:mb-10 text-orange-100 max-w-2xl mx-auto">
                    {{ __('Get special pricing on bulk orders. Register as a dealer today!') }}
                </p>
                <a href="{{ route('wholesale.register') }}" class="inline-block bg-white text-secondary-500 hover:bg-gray-100 font-bold py-4 px-10 rounded-full text-lg transition shadow-2xl hover-lift">
                    <i class="fas fa-user-plus mr-2"></i>{{ __('Become a Dealer') }}
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Why Choose Us - Modern Icon Design -->
    <section class="py-10 sm:py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-8 sm:mb-16">
                <h2 class="text-3xl sm:text-5xl font-extrabold mb-3 sm:mb-4 bg-gradient-to-r from-primary-500 to-blue-600 bg-clip-text text-transparent">
                    {{ __('Why Choose Chamak Chemicals?') }}
                </h2>
                <p class="text-gray-600 text-sm sm:text-lg">{{ __('Excellence in every aspect of our service') }}</p>
            </div>
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-8">
                <div class="bg-white rounded-2xl p-4 sm:p-8 text-center hover-lift shadow-lg group">
                    <div class="w-14 h-14 sm:w-20 sm:h-20 gradient-primary rounded-xl sm:rounded-2xl flex items-center justify-center mx-auto mb-3 sm:mb-6 group-hover:scale-110 group-hover:rotate-6 transition-all shadow-xl">
                        <i class="fas fa-certificate text-xl sm:text-3xl text-white"></i>
                    </div>
                    <h3 class="font-bold text-sm sm:text-xl mb-1 sm:mb-3 text-gray-900">{{ __('Quality Products') }}</h3>
                    <p class="text-gray-600 leading-relaxed text-xs sm:text-base hidden sm:block">{{ __('Lab-tested and certified chemicals meeting international standards') }}</p>
                </div>
                <div class="bg-white rounded-2xl p-4 sm:p-8 text-center hover-lift shadow-lg group">
                    <div class="w-14 h-14 sm:w-20 sm:h-20 gradient-secondary rounded-xl sm:rounded-2xl flex items-center justify-center mx-auto mb-3 sm:mb-6 group-hover:scale-110 group-hover:rotate-6 transition-all shadow-xl">
                        <i class="fas fa-shipping-fast text-xl sm:text-3xl text-white"></i>
                    </div>
                    <h3 class="font-bold text-sm sm:text-xl mb-1 sm:mb-3 text-gray-900">{{ __('Fast Delivery') }}</h3>
                    <p class="text-gray-600 leading-relaxed text-xs sm:text-base hidden sm:block">{{ __('Quick and reliable shipping across Pakistan within 2-3 days') }}</p>
                </div>
                <div class="bg-white rounded-2xl p-4 sm:p-8 text-center hover-lift shadow-lg group">
                    <div class="w-14 h-14 sm:w-20 sm:h-20 bg-gradient-to-br from-green-400 to-green-600 rounded-xl sm:rounded-2xl flex items-center justify-center mx-auto mb-3 sm:mb-6 group-hover:scale-110 group-hover:rotate-6 transition-all shadow-xl">
                        <i class="fas fa-tags text-xl sm:text-3xl text-white"></i>
                    </div>
                    <h3 class="font-bold text-sm sm:text-xl mb-1 sm:mb-3 text-gray-900">{{ __('Best Prices') }}</h3>
                    <p class="text-gray-600 leading-relaxed text-xs sm:text-base hidden sm:block">{{ __('Competitive pricing for retail & wholesale with bulk discounts') }}</p>
                </div>
                <div class="bg-white rounded-2xl p-4 sm:p-8 text-center hover-lift shadow-lg group">
                    <div class="w-14 h-14 sm:w-20 sm:h-20 bg-gradient-to-br from-purple-400 to-purple-600 rounded-xl sm:rounded-2xl flex items-center justify-center mx-auto mb-3 sm:mb-6 group-hover:scale-110 group-hover:rotate-6 transition-all shadow-xl">
                        <i class="fas fa-headset text-xl sm:text-3xl text-white"></i>
                    </div>
                    <h3 class="font-bold text-sm sm:text-xl mb-1 sm:mb-3 text-gray-900">{{ __('24/7 Support') }}</h3>
                    <p class="text-gray-600 leading-relaxed text-xs sm:text-base hidden sm:block">{{ __('Customer support via WhatsApp, email, and phone') }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Trust Badges -->
    <section class="py-12 bg-white border-y border-gray-200">
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap justify-center items-center gap-6 sm:gap-12 opacity-60">
                <div class="flex items-center space-x-2">
                    <i class="fas fa-shield-alt text-2xl text-green-500"></i>
                    <span class="font-semibold">{{ __('100% Authentic') }}</span>
                </div>
                <div class="flex items-center space-x-2">
                    <i class="fas fa-lock text-2xl text-blue-500"></i>
                    <span class="font-semibold">{{ __('Secure Payment') }}</span>
                </div>
                <div class="flex items-center space-x-2">
                    <i class="fas fa-undo text-2xl text-orange-500"></i>
                    <span class="font-semibold">{{ __('Easy Returns') }}</span>
                </div>
                <div class="flex items-center space-x-2">
                    <i class="fas fa-truck text-2xl text-purple-500"></i>
                    <span class="font-semibold">{{ __('Free Shipping 5000+') }}</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Add CSS for animations -->
    <style>
        @keyframes blob {
            0%, 100% { transform: translate(0, 0) scale(1); }
            25% { transform: translate(20px, -50px) scale(1.1); }
            50% { transform: translate(-20px, 20px) scale(0.9); }
            75% { transform: translate(50px, 50px) scale(1.05); }
        }
        .animate-blob {
            animation: blob 7s infinite;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        .animation-delay-4000 {
            animation-delay: 4s;
        }
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
        .banner-slider-aspect { aspect-ratio: 16/9; }
        @media (min-width: 640px) { .banner-slider-aspect { aspect-ratio: 16/7; } }
        @media (min-width: 1024px) { .banner-slider-aspect { aspect-ratio: 16/6; } }
    </style>
@endsection
