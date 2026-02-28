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

    <!-- Hot Deals Section - Grid like Featured Products -->
    @if($deals->count() > 0)
    <section class="py-8 sm:py-14 bg-gradient-to-r from-red-50 to-orange-50">
        <div class="container mx-auto px-4">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 sm:mb-8 gap-3">
                <div>
                    <h2 class="text-2xl sm:text-4xl font-extrabold mb-1 bg-gradient-to-r from-red-500 to-orange-600 bg-clip-text text-transparent">
                        <i class="fas fa-fire text-red-500"></i> {{ __('Hot Deals') }}
                    </h2>
                    <p class="text-gray-600 text-xs sm:text-sm">{{ __('Don\'t miss our amazing deals and promotions!') }}</p>
                </div>
                <a href="{{ route('deals.index') }}" class="px-4 py-2 bg-red-500 text-white rounded-full font-semibold hover:bg-red-600 transition shadow-lg text-xs sm:text-sm">
                    {{ __('View All Deals') }} <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>

            <!-- Deals Grid - Same layout as Featured Products -->
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-3 sm:gap-4">
                @foreach($deals as $deal)
                    @php $translation = $deal->translate(app()->getLocale()); @endphp
                    <a href="{{ $deal->url ?? '#' }}" class="group">
                        <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 hover:border-red-400 hover:shadow-lg transition-all h-full">
                            <div class="relative overflow-hidden">
                                @if($deal->image)
                                    <img src="{{ asset('storage/' . $deal->image) }}" alt="{{ $translation->title ?? '' }}" class="w-full h-28 sm:h-36 object-cover group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <div class="w-full h-28 sm:h-36 bg-gradient-to-br from-red-400 to-orange-500 flex items-center justify-center">
                                        <i class="fas fa-fire text-white text-3xl opacity-50"></i>
                                    </div>
                                @endif
                                @if($deal->discount_percentage)
                                    <span class="absolute top-1.5 right-1.5 z-10 bg-red-600 text-white px-1.5 py-0.5 rounded text-[10px] font-bold">
                                        {{ number_format($deal->discount_percentage, 0) }}% {{ __('OFF') }}
                                    </span>
                                @endif
                                @if($deal->ends_at)
                                    <span class="absolute bottom-1.5 left-1.5 bg-black/60 text-white px-1.5 py-0.5 rounded text-[10px]">
                                        <i class="fas fa-clock mr-0.5"></i>{{ $deal->ends_at->format('d M') }}
                                    </span>
                                @endif
                            </div>
                            <div class="p-2.5 sm:p-3">
                                <h3 class="font-bold text-gray-900 group-hover:text-red-500 mb-1 text-xs sm:text-sm leading-tight line-clamp-2 transition">{{ $translation->title ?? '' }}</h3>
                                <span class="inline-flex items-center text-red-500 font-semibold text-xs">
                                    {{ __('Shop Now') }} <i class="fas fa-arrow-right ml-1"></i>
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Featured Categories - Modern Cards -->
    <section class="py-8 sm:py-14 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-6 sm:mb-10">
                <h2 class="text-2xl sm:text-4xl font-extrabold mb-1 sm:mb-2 bg-gradient-to-r from-primary-500 to-blue-600 bg-clip-text text-transparent">
                    {{ __('Product Categories') }}
                </h2>
                <p class="text-gray-600 text-xs sm:text-sm">{{ __('Explore our wide range of chemical products') }}</p>
            </div>
            @php
                $fallbackIcons = ['fas fa-flask', 'fas fa-spray-can', 'fas fa-vial', 'fas fa-broom', 'fas fa-pump-soap', 'fas fa-tint', 'fas fa-fill-drip', 'fas fa-hand-sparkles'];
                $iconColors = ['text-blue-500', 'text-purple-500', 'text-green-500', 'text-orange-500', 'text-pink-500', 'text-cyan-500', 'text-indigo-500', 'text-red-500'];
            @endphp
            <div class="grid grid-cols-3 sm:grid-cols-4 lg:grid-cols-6 gap-2 sm:gap-4">
                @foreach($categories as $index => $category)
                    <a href="{{ route('categories.show', $category->slug) }}" class="group">
                        <div class="bg-white rounded-xl shadow-md p-3 sm:p-5 text-center hover-lift border border-gray-100 hover:border-primary-500 transition-all">
                            <div class="text-2xl sm:text-3xl mb-2 sm:mb-3 transform group-hover:scale-110 transition-transform">
                                <i class="{{ $category->icon ?: $fallbackIcons[$index % count($fallbackIcons)] }} {{ $iconColors[$index % count($iconColors)] }}"></i>
                            </div>
                            <h3 class="font-bold text-xs sm:text-sm text-gray-800 group-hover:text-primary-500 transition leading-tight">
                                {{ $category->translate(app()->getLocale())->name }}
                            </h3>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Featured Products - Compact Grid -->
    <section class="py-8 sm:py-14 bg-white">
        <div class="container mx-auto px-4">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 sm:mb-8 gap-3">
                <div>
                    <h2 class="text-2xl sm:text-4xl font-extrabold mb-1 bg-gradient-to-r from-primary-500 to-blue-600 bg-clip-text text-transparent">
                        {{ __('Featured Products') }}
                    </h2>
                    <p class="text-gray-600 text-xs sm:text-sm">{{ __('Handpicked bestsellers just for you') }}</p>
                </div>
                <a href="{{ route('products.index') }}" class="px-4 py-2 bg-primary-500 text-white rounded-full font-semibold hover:bg-primary-600 transition shadow-lg text-xs sm:text-sm">
                    {{ __('View All') }} <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-3 sm:gap-4">
                @foreach($featuredProducts as $index => $product)
                    <a href="{{ route('products.show', $product->slug) }}" class="group">
                        <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 hover:border-primary-500 hover:shadow-lg transition-all h-full">
                            <div class="relative overflow-hidden">
                                @if($product->pricing->isSaleActive())
                                    <span class="absolute top-1.5 right-1.5 z-10 bg-red-500 text-white px-1.5 py-0.5 rounded text-[10px] font-bold">
                                        -{{ number_format((($product->pricing->retail_price - $product->pricing->sale_price) / $product->pricing->retail_price) * 100, 0) }}%
                                    </span>
                                @endif
                                @if($product->featured_image)
                                    <img src="{{ asset('storage/' . $product->featured_image) }}"
                                         alt="{{ $product->translate(app()->getLocale())->name }}"
                                         class="w-full h-28 sm:h-36 object-cover group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <div class="w-full h-28 sm:h-36 bg-gradient-to-br from-primary-400 via-blue-500 to-purple-500 flex items-center justify-center">
                                        <i class="fas fa-flask text-white text-3xl opacity-50"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="p-2.5 sm:p-3">
                                <p class="text-[10px] text-gray-400 font-semibold uppercase tracking-wide mb-0.5">
                                    {{ $product->category->translate(app()->getLocale())->name }}
                                </p>
                                <h3 class="font-bold text-xs sm:text-sm text-gray-900 group-hover:text-primary-500 transition line-clamp-2 mb-1.5 leading-tight">
                                    {{ $product->translate(app()->getLocale())->name }}
                                </h3>
                                <div>
                                    @if($product->pricing->isSaleActive())
                                        <span class="text-gray-400 line-through text-[10px]">PKR {{ number_format($product->pricing->retail_price, 0) }}</span>
                                        <div class="text-primary-500 font-bold text-sm">PKR {{ number_format($product->pricing->sale_price, 0) }}</div>
                                    @else
                                        <div class="text-primary-500 font-bold text-sm">PKR {{ number_format($product->pricing->retail_price, 0) }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- New Arrivals -->
    @if($newArrivals->count() > 0)
    <section class="py-8 sm:py-14 bg-gradient-to-r from-blue-50 to-indigo-50">
        <div class="container mx-auto px-4">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 sm:mb-8 gap-3">
                <div>
                    <h2 class="text-2xl sm:text-4xl font-extrabold mb-1 bg-gradient-to-r from-indigo-500 to-purple-600 bg-clip-text text-transparent">
                        <i class="fas fa-star text-indigo-500"></i> {{ __('New Arrivals') }}
                    </h2>
                    <p class="text-gray-600 text-xs sm:text-sm">{{ __('Check out our latest products') }}</p>
                </div>
                <a href="{{ route('products.index') }}" class="px-4 py-2 bg-indigo-500 text-white rounded-full font-semibold hover:bg-indigo-600 transition shadow-lg text-xs sm:text-sm">
                    {{ __('View All') }} <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-3 sm:gap-4">
                @foreach($newArrivals as $product)
                    <a href="{{ route('products.show', $product->slug) }}" class="group">
                        <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 hover:border-indigo-400 hover:shadow-lg transition-all h-full">
                            <div class="relative overflow-hidden">
                                <span class="absolute top-1.5 left-1.5 z-10 bg-indigo-500 text-white px-1.5 py-0.5 rounded text-[10px] font-bold">
                                    {{ __('NEW') }}
                                </span>
                                @if($product->pricing->isSaleActive())
                                    <span class="absolute top-1.5 right-1.5 z-10 bg-red-500 text-white px-1.5 py-0.5 rounded text-[10px] font-bold">
                                        -{{ number_format((($product->pricing->retail_price - $product->pricing->sale_price) / $product->pricing->retail_price) * 100, 0) }}%
                                    </span>
                                @endif
                                @if($product->featured_image)
                                    <img src="{{ asset('storage/' . $product->featured_image) }}"
                                         alt="{{ $product->translate(app()->getLocale())->name }}"
                                         class="w-full h-28 sm:h-36 object-cover group-hover:scale-105 transition-transform duration-300">
                                @else
                                    @php
                                        $naGradients = ['from-indigo-400 via-purple-500 to-pink-500','from-blue-400 via-cyan-500 to-teal-500','from-green-400 via-emerald-500 to-teal-600'];
                                        $naGradient = $naGradients[$product->id % count($naGradients)];
                                    @endphp
                                    <div class="w-full h-28 sm:h-36 bg-gradient-to-br {{ $naGradient }} flex items-center justify-center">
                                        <i class="fas fa-flask text-white text-3xl opacity-50"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="p-2.5 sm:p-3">
                                <p class="text-[10px] text-gray-400 font-semibold uppercase tracking-wide mb-0.5">
                                    {{ $product->category->translate(app()->getLocale())->name }}
                                </p>
                                <h3 class="font-bold text-xs sm:text-sm text-gray-900 group-hover:text-indigo-500 transition line-clamp-2 mb-1.5 leading-tight">
                                    {{ $product->translate(app()->getLocale())->name }}
                                </h3>
                                <div>
                                    @if($product->pricing->isSaleActive())
                                        <span class="text-gray-400 line-through text-[10px]">PKR {{ number_format($product->pricing->retail_price, 0) }}</span>
                                        <div class="text-indigo-500 font-bold text-sm">PKR {{ number_format($product->pricing->sale_price, 0) }}</div>
                                    @else
                                        <div class="text-indigo-500 font-bold text-sm">PKR {{ number_format($product->pricing->retail_price, 0) }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Stats Counter -->
    <section class="py-8 sm:py-12 bg-gradient-to-r from-primary-600 via-blue-600 to-primary-700 text-white">
        <div class="container mx-auto px-4">
            @php
                $statProducts = \App\Models\Product::where('is_active', true)->count();
                $statCustomers = \App\Models\User::count();
                $statOrders = \App\Models\Order::count();
            @endphp
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-8 text-center"
                 x-data="{
                     products: 0, customers: 0, orders: 0, cities: 0,
                     targetProducts: {{ $statProducts }},
                     targetCustomers: {{ $statCustomers }},
                     targetOrders: {{ $statOrders }},
                     targetCities: 50,
                     animateCount(prop, target) {
                         let steps = 40;
                         let step = Math.max(Math.ceil(target / steps), 1);
                         let interval = setInterval(() => {
                             this[prop] = Math.min(this[prop] + step, target);
                             if (this[prop] >= target) clearInterval(interval);
                         }, 30);
                     }
                 }"
                 x-intersect.once="animateCount('products', targetProducts); animateCount('customers', targetCustomers); animateCount('orders', targetOrders); animateCount('cities', targetCities)">
                <div>
                    <div class="w-12 h-12 sm:w-14 sm:h-14 bg-white/20 rounded-xl flex items-center justify-center mx-auto mb-2 sm:mb-3">
                        <i class="fas fa-box text-xl sm:text-2xl"></i>
                    </div>
                    <div class="text-2xl sm:text-4xl font-extrabold mb-1" x-text="products + '+'"></div>
                    <div class="text-blue-200 text-xs sm:text-sm font-semibold">{{ __('Products') }}</div>
                </div>
                <div>
                    <div class="w-12 h-12 sm:w-14 sm:h-14 bg-white/20 rounded-xl flex items-center justify-center mx-auto mb-2 sm:mb-3">
                        <i class="fas fa-users text-xl sm:text-2xl"></i>
                    </div>
                    <div class="text-2xl sm:text-4xl font-extrabold mb-1" x-text="customers + '+'"></div>
                    <div class="text-blue-200 text-xs sm:text-sm font-semibold">{{ __('Happy Customers') }}</div>
                </div>
                <div>
                    <div class="w-12 h-12 sm:w-14 sm:h-14 bg-white/20 rounded-xl flex items-center justify-center mx-auto mb-2 sm:mb-3">
                        <i class="fas fa-shopping-bag text-xl sm:text-2xl"></i>
                    </div>
                    <div class="text-2xl sm:text-4xl font-extrabold mb-1" x-text="orders + '+'"></div>
                    <div class="text-blue-200 text-xs sm:text-sm font-semibold">{{ __('Orders Delivered') }}</div>
                </div>
                <div>
                    <div class="w-12 h-12 sm:w-14 sm:h-14 bg-white/20 rounded-xl flex items-center justify-center mx-auto mb-2 sm:mb-3">
                        <i class="fas fa-map-marker-alt text-xl sm:text-2xl"></i>
                    </div>
                    <div class="text-2xl sm:text-4xl font-extrabold mb-1" x-text="cities + '+'"></div>
                    <div class="text-blue-200 text-xs sm:text-sm font-semibold">{{ __('Cities Covered') }}</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="py-8 sm:py-14 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-6 sm:mb-10">
                <h2 class="text-2xl sm:text-4xl font-extrabold mb-1 sm:mb-2 bg-gradient-to-r from-primary-500 to-blue-600 bg-clip-text text-transparent">
                    {{ __('Why Choose Chamak Chemicals?') }}
                </h2>
                <p class="text-gray-600 text-xs sm:text-sm">{{ __('Excellence in every aspect of our service') }}</p>
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

    <!-- Trust Badges - 6 items with auto-sliding -->
    <section class="py-6 sm:py-10 bg-white border-y border-gray-200 overflow-hidden" x-data="{
        badges: 6,
        init() {
            // Auto scroll animation handled by CSS
        }
    }">
        <div class="container mx-auto px-4">
            <div class="trust-badges-track flex items-center gap-6 sm:gap-10">
                <!-- First set -->
                <div class="trust-badge-item flex-shrink-0 flex flex-col items-center gap-2 min-w-[120px] sm:min-w-[150px] bg-gray-50 rounded-xl py-4 px-3 sm:px-5 border border-gray-100">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-shield-alt text-lg sm:text-xl text-green-600"></i>
                    </div>
                    <span class="font-bold text-xs sm:text-sm text-gray-800 text-center">{{ __('100% Authentic') }}</span>
                </div>
                <div class="trust-badge-item flex-shrink-0 flex flex-col items-center gap-2 min-w-[120px] sm:min-w-[150px] bg-gray-50 rounded-xl py-4 px-3 sm:px-5 border border-gray-100">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-lock text-lg sm:text-xl text-blue-600"></i>
                    </div>
                    <span class="font-bold text-xs sm:text-sm text-gray-800 text-center">{{ __('Secure Payment') }}</span>
                </div>
                <div class="trust-badge-item flex-shrink-0 flex flex-col items-center gap-2 min-w-[120px] sm:min-w-[150px] bg-gray-50 rounded-xl py-4 px-3 sm:px-5 border border-gray-100">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-orange-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-undo text-lg sm:text-xl text-orange-600"></i>
                    </div>
                    <span class="font-bold text-xs sm:text-sm text-gray-800 text-center">{{ __('Easy Returns') }}</span>
                </div>
                <div class="trust-badge-item flex-shrink-0 flex flex-col items-center gap-2 min-w-[120px] sm:min-w-[150px] bg-gray-50 rounded-xl py-4 px-3 sm:px-5 border border-gray-100">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-purple-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-truck text-lg sm:text-xl text-purple-600"></i>
                    </div>
                    <span class="font-bold text-xs sm:text-sm text-gray-800 text-center">{{ __('Free Shipping 5000+') }}</span>
                </div>
                <div class="trust-badge-item flex-shrink-0 flex flex-col items-center gap-2 min-w-[120px] sm:min-w-[150px] bg-gray-50 rounded-xl py-4 px-3 sm:px-5 border border-gray-100">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-teal-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-award text-lg sm:text-xl text-teal-600"></i>
                    </div>
                    <span class="font-bold text-xs sm:text-sm text-gray-800 text-center">{{ __('Trusted Brand') }}</span>
                </div>
                <div class="trust-badge-item flex-shrink-0 flex flex-col items-center gap-2 min-w-[120px] sm:min-w-[150px] bg-gray-50 rounded-xl py-4 px-3 sm:px-5 border border-gray-100">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-red-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-headset text-lg sm:text-xl text-red-600"></i>
                    </div>
                    <span class="font-bold text-xs sm:text-sm text-gray-800 text-center">{{ __('24/7 Support') }}</span>
                </div>
                <!-- Duplicate set for seamless loop -->
                <div class="trust-badge-item flex-shrink-0 flex flex-col items-center gap-2 min-w-[120px] sm:min-w-[150px] bg-gray-50 rounded-xl py-4 px-3 sm:px-5 border border-gray-100">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-shield-alt text-lg sm:text-xl text-green-600"></i>
                    </div>
                    <span class="font-bold text-xs sm:text-sm text-gray-800 text-center">{{ __('100% Authentic') }}</span>
                </div>
                <div class="trust-badge-item flex-shrink-0 flex flex-col items-center gap-2 min-w-[120px] sm:min-w-[150px] bg-gray-50 rounded-xl py-4 px-3 sm:px-5 border border-gray-100">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-lock text-lg sm:text-xl text-blue-600"></i>
                    </div>
                    <span class="font-bold text-xs sm:text-sm text-gray-800 text-center">{{ __('Secure Payment') }}</span>
                </div>
                <div class="trust-badge-item flex-shrink-0 flex flex-col items-center gap-2 min-w-[120px] sm:min-w-[150px] bg-gray-50 rounded-xl py-4 px-3 sm:px-5 border border-gray-100">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-orange-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-undo text-lg sm:text-xl text-orange-600"></i>
                    </div>
                    <span class="font-bold text-xs sm:text-sm text-gray-800 text-center">{{ __('Easy Returns') }}</span>
                </div>
                <div class="trust-badge-item flex-shrink-0 flex flex-col items-center gap-2 min-w-[120px] sm:min-w-[150px] bg-gray-50 rounded-xl py-4 px-3 sm:px-5 border border-gray-100">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-purple-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-truck text-lg sm:text-xl text-purple-600"></i>
                    </div>
                    <span class="font-bold text-xs sm:text-sm text-gray-800 text-center">{{ __('Free Shipping 5000+') }}</span>
                </div>
                <div class="trust-badge-item flex-shrink-0 flex flex-col items-center gap-2 min-w-[120px] sm:min-w-[150px] bg-gray-50 rounded-xl py-4 px-3 sm:px-5 border border-gray-100">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-teal-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-award text-lg sm:text-xl text-teal-600"></i>
                    </div>
                    <span class="font-bold text-xs sm:text-sm text-gray-800 text-center">{{ __('Trusted Brand') }}</span>
                </div>
                <div class="trust-badge-item flex-shrink-0 flex flex-col items-center gap-2 min-w-[120px] sm:min-w-[150px] bg-gray-50 rounded-xl py-4 px-3 sm:px-5 border border-gray-100">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-red-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-headset text-lg sm:text-xl text-red-600"></i>
                    </div>
                    <span class="font-bold text-xs sm:text-sm text-gray-800 text-center">{{ __('24/7 Support') }}</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Wholesale Banner - Compact, right before footer -->
    <section class="relative py-8 sm:py-12 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-secondary-500 via-orange-500 to-secondary-600"></div>
        <div class="container mx-auto px-4 relative z-10">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-3 sm:gap-4 text-white">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 bg-white/20 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-warehouse text-xl sm:text-2xl text-white"></i>
                    </div>
                    <div>
                        <h2 class="text-xl sm:text-2xl font-extrabold text-white">
                            {{ __('Looking for Wholesale?') }}
                        </h2>
                        <p class="text-xs sm:text-sm text-orange-100">
                            {{ __('Get special pricing on bulk orders. Register as a dealer today!') }}
                        </p>
                    </div>
                </div>
                <a href="{{ route('wholesale.register') }}" class="flex-shrink-0 bg-white text-secondary-500 hover:bg-gray-100 font-bold py-2.5 px-6 sm:py-3 sm:px-8 rounded-full text-sm transition shadow-xl">
                    <i class="fas fa-user-plus mr-2"></i>{{ __('Become a Dealer') }}
                    <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Welcome Popup -->
    <div x-data="{ showPopup: false }"
         x-init="setTimeout(() => { if(!sessionStorage.getItem('popupClosed')) { showPopup = true } }, 2000)"
         x-show="showPopup"
         x-cloak
         class="fixed inset-0 z-[100] flex items-center justify-center p-4"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-black/60" @click="showPopup = false; sessionStorage.setItem('popupClosed', '1')"></div>
        <!-- Popup Content -->
        <div class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full overflow-hidden"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-90"
             x-transition:enter-end="opacity-100 scale-100">
            <!-- Close Button -->
            <button @click="showPopup = false; sessionStorage.setItem('popupClosed', '1')"
                    class="absolute top-3 right-3 z-10 w-8 h-8 bg-white/90 hover:bg-white rounded-full flex items-center justify-center shadow-lg text-gray-600 hover:text-gray-900 transition">
                <i class="fas fa-times"></i>
            </button>
            <!-- Top Banner -->
            <div class="gradient-primary p-6 text-center text-white">
                <i class="fas fa-gift text-4xl mb-3"></i>
                <h3 class="text-2xl font-bold mb-1">{{ __('Welcome to Chamak Chemicals!') }}</h3>
                <p class="text-blue-100 text-sm">{{ __('Pakistan\'s Trusted Chemical Supplier') }}</p>
            </div>
            <!-- Body -->
            <div class="p-6 text-center">
                <div class="bg-orange-50 border-2 border-dashed border-orange-300 rounded-xl p-4 mb-4">
                    <p class="text-orange-600 font-bold text-lg mb-1"><i class="fas fa-truck mr-2"></i>{{ __('FREE SHIPPING') }}</p>
                    <p class="text-gray-700 text-sm">{{ __('On all orders above PKR 5,000') }}</p>
                </div>
                <div class="space-y-3 text-sm text-gray-600 mb-5">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-check-circle text-green-500"></i>
                        <span>{{ __('Lab-tested & certified products') }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-check-circle text-green-500"></i>
                        <span>{{ __('Delivery in 2-3 days across Pakistan') }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-check-circle text-green-500"></i>
                        <span>{{ __('Wholesale & bulk order discounts') }}</span>
                    </div>
                </div>
                <a href="{{ route('products.index') }}"
                   @click="sessionStorage.setItem('popupClosed', '1')"
                   class="inline-block w-full gradient-secondary text-white font-bold py-3 px-6 rounded-xl hover:opacity-90 transition">
                    <i class="fas fa-shopping-bag mr-2"></i>{{ __('Shop Now') }}
                </a>
            </div>
        </div>
    </div>

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
        /* Trust badges auto-sliding */
        .trust-badges-track {
            animation: trustBadgesScroll 20s linear infinite;
            width: max-content;
        }
        .trust-badges-track:hover {
            animation-play-state: paused;
        }
        @keyframes trustBadgesScroll {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        .banner-slider-aspect { aspect-ratio: 16/9; }
        @media (min-width: 640px) { .banner-slider-aspect { aspect-ratio: 16/7; } }
        @media (min-width: 1024px) { .banner-slider-aspect { aspect-ratio: 16/6; } }
    </style>
@endsection
