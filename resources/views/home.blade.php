@extends('layouts.app')

@section('title', __('Home'))

@section('content')
    <!-- Hero Section - Modern & Eye-catching -->
    <section class="relative overflow-hidden bg-gradient-to-br from-primary-500 via-blue-600 to-primary-700 text-white py-24">
        <!-- Animated Background Shapes -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-20 left-10 w-72 h-72 bg-white rounded-full mix-blend-multiply filter blur-xl animate-blob"></div>
            <div class="absolute top-40 right-10 w-72 h-72 bg-secondary-500 rounded-full mix-blend-multiply filter blur-xl animate-blob animation-delay-2000"></div>
            <div class="absolute bottom-20 left-1/2 w-72 h-72 bg-blue-400 rounded-full mix-blend-multiply filter blur-xl animate-blob animation-delay-4000"></div>
        </div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-4xl mx-auto text-center">
                <div class="animate__animated animate__fadeInDown mb-6">
                    <span class="inline-block px-6 py-2 bg-white/20 glass-effect rounded-full text-sm font-semibold mb-6">
                        <i class="fas fa-award mr-2"></i>{{ __('Trusted by 1000+ Businesses') }}
                    </span>
                </div>
                <h1 class="text-6xl md:text-7xl font-extrabold mb-6 animate__animated animate__fadeInUp leading-tight">
                    {{ __('Premium Chemical Products for Every Need') }}
                </h1>
                <p class="text-2xl mb-10 text-blue-100 animate__animated animate__fadeInUp animate__delay-1s">
                    {{ __('High-quality cleaning and industrial chemicals. Retail and wholesale available.') }}
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-4 animate__animated animate__fadeInUp animate__delay-2s">
                    <a href="{{ route('products.index') }}" class="group px-8 py-4 bg-white text-primary-500 hover:bg-gray-100 font-bold rounded-xl transition shadow-2xl hover-lift text-lg">
                        <i class="fas fa-shopping-bag mr-2 group-hover:scale-110 inline-block transition"></i>{{ __('Shop Now') }}
                        <i class="fas fa-arrow-right ml-2 group-hover:translate-x-2 inline-block transition"></i>
                    </a>
                    <a href="{{ route('wholesale.register') }}" class="px-8 py-4 bg-gradient-secondary text-white font-bold rounded-xl transition shadow-2xl hover-lift text-lg">
                        <i class="fas fa-handshake mr-2"></i>{{ __('Wholesale Inquiry') }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Wave SVG Separator -->
        <div class="absolute bottom-0 left-0 w-full">
            <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 120L60 110C120 100 240 80 360 70C480 60 600 60 720 65C840 70 960 80 1080 85C1200 90 1320 90 1380 90L1440 90V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="#F9FAFB"/>
            </svg>
        </div>
    </section>

    <!-- Featured Categories - Modern Cards -->
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16 animate__animated animate__fadeIn">
                <h2 class="text-5xl font-extrabold mb-4 bg-gradient-to-r from-primary-500 to-blue-600 bg-clip-text text-transparent">
                    {{ __('Product Categories') }}
                </h2>
                <p class="text-gray-600 text-lg">{{ __('Explore our wide range of chemical products') }}</p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
                @foreach($categories as $index => $category)
                    <a href="{{ route('categories.show', $category->slug) }}" class="group animate__animated animate__fadeInUp" style="animation-delay: {{ $index * 100 }}ms">
                        <div class="bg-white rounded-2xl shadow-lg p-8 text-center hover-lift border-2 border-transparent hover:border-primary-500 transition-all">
                            <div class="text-5xl mb-4 transform group-hover:scale-125 transition-transform">
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
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center mb-12">
                <div>
                    <h2 class="text-5xl font-extrabold mb-2 bg-gradient-to-r from-primary-500 to-blue-600 bg-clip-text text-transparent">
                        {{ __('Featured Products') }}
                    </h2>
                    <p class="text-gray-600">{{ __('Handpicked bestsellers just for you') }}</p>
                </div>
                <a href="{{ route('products.index') }}" class="px-6 py-3 bg-primary-500 text-white rounded-full font-semibold hover:bg-primary-600 transition shadow-lg hover-lift">
                    {{ __('View All') }} <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($featuredProducts as $index => $product)
                    <div class="group animate__animated animate__fadeInUp hover-lift" style="animation-delay: {{ $index * 100 }}ms">
                        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border-2 border-transparent hover:border-primary-500 transition-all">
                            <div class="relative overflow-hidden">
                                @if($product->pricing->isSaleActive())
                                    <div class="absolute top-3 right-3 z-10">
                                        <span class="bg-gradient-secondary text-white px-4 py-2 rounded-full text-sm font-bold shadow-lg animate-pulse">
                                            <i class="fas fa-fire mr-1"></i>{{ __('Sale') }}
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
                            <div class="p-6">
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
                                            <div class="text-gray-400 line-through text-sm">PKR {{ number_format($product->pricing->retail_price, 0) }}</div>
                                            <div class="text-primary-500 font-bold text-xl">PKR {{ number_format($product->pricing->sale_price, 0) }}</div>
                                        @else
                                            <div class="text-primary-500 font-bold text-xl">PKR {{ number_format($product->pricing->retail_price, 0) }}</div>
                                        @endif
                                    </div>
                                    <a href="{{ route('products.show', $product->slug) }}" class="bg-gradient-primary text-white px-5 py-2.5 rounded-lg font-semibold hover:shadow-lg transition group">
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
    <section class="relative py-24 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-secondary-500 via-orange-500 to-secondary-600"></div>
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-0 w-96 h-96 bg-white rounded-full filter blur-3xl"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-yellow-300 rounded-full filter blur-3xl"></div>
        </div>
        <div class="container mx-auto px-4 text-center relative z-10">
            <div class="animate__animated animate__fadeIn">
                <div class="text-7xl mb-6"><i class="fas fa-warehouse text-white/80"></i></div>
                <h2 class="text-5xl md:text-6xl font-extrabold mb-6 text-white">
                    {{ __('Looking for Wholesale?') }}
                </h2>
                <p class="text-2xl mb-10 text-orange-100 max-w-2xl mx-auto">
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
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-5xl font-extrabold mb-4 bg-gradient-to-r from-primary-500 to-blue-600 bg-clip-text text-transparent">
                    {{ __('Why Choose Chamak Chemicals?') }}
                </h2>
                <p class="text-gray-600 text-lg">{{ __('Excellence in every aspect of our service') }}</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="bg-white rounded-2xl p-8 text-center hover-lift shadow-lg group">
                    <div class="w-20 h-20 bg-gradient-primary rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 group-hover:rotate-6 transition-all shadow-xl">
                        <i class="fas fa-certificate text-3xl text-white"></i>
                    </div>
                    <h3 class="font-bold text-xl mb-3 text-gray-900">{{ __('Quality Products') }}</h3>
                    <p class="text-gray-600 leading-relaxed">{{ __('Lab-tested and certified chemicals meeting international standards') }}</p>
                </div>
                <div class="bg-white rounded-2xl p-8 text-center hover-lift shadow-lg group">
                    <div class="w-20 h-20 bg-gradient-secondary rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 group-hover:rotate-6 transition-all shadow-xl">
                        <i class="fas fa-shipping-fast text-3xl text-white"></i>
                    </div>
                    <h3 class="font-bold text-xl mb-3 text-gray-900">{{ __('Fast Delivery') }}</h3>
                    <p class="text-gray-600 leading-relaxed">{{ __('Quick and reliable shipping across Pakistan within 2-3 days') }}</p>
                </div>
                <div class="bg-white rounded-2xl p-8 text-center hover-lift shadow-lg group">
                    <div class="w-20 h-20 bg-gradient-to-br from-green-400 to-green-600 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 group-hover:rotate-6 transition-all shadow-xl">
                        <i class="fas fa-tags text-3xl text-white"></i>
                    </div>
                    <h3 class="font-bold text-xl mb-3 text-gray-900">{{ __('Best Prices') }}</h3>
                    <p class="text-gray-600 leading-relaxed">{{ __('Competitive pricing for retail & wholesale with bulk discounts') }}</p>
                </div>
                <div class="bg-white rounded-2xl p-8 text-center hover-lift shadow-lg group">
                    <div class="w-20 h-20 bg-gradient-to-br from-purple-400 to-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 group-hover:rotate-6 transition-all shadow-xl">
                        <i class="fas fa-headset text-3xl text-white"></i>
                    </div>
                    <h3 class="font-bold text-xl mb-3 text-gray-900">{{ __('24/7 Support') }}</h3>
                    <p class="text-gray-600 leading-relaxed">{{ __('Customer support via WhatsApp, email, and phone') }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Trust Badges -->
    <section class="py-12 bg-white border-y border-gray-200">
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap justify-center items-center gap-12 opacity-60">
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
    </style>
@endsection
