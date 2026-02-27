@extends('layouts.app')

@section('title', $product->translate(app()->getLocale())->name)

@section('content')
    <!-- Breadcrumb -->
    <div class="bg-gray-100 py-4">
        <div class="container mx-auto px-4">
            <nav class="text-sm">
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-primary-500">{{ __('Home') }}</a>
                <span class="mx-2">/</span>
                <a href="{{ route('products.index') }}" class="text-gray-600 hover:text-primary-500">{{ __('Products') }}</a>
                <span class="mx-2">/</span>
                <a href="{{ route('categories.show', $product->category->slug) }}" class="text-gray-600 hover:text-primary-500">
                    {{ $product->category->translate(app()->getLocale())->name }}
                </a>
                <span class="mx-2">/</span>
                <span class="text-gray-900">{{ $product->translate(app()->getLocale())->name }}</span>
            </nav>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Product Images - Auto Slider -->
            <div x-data="{
                currentSlide: 0,
                images: [
                    @if($product->featured_image)
                        '{{ asset('storage/' . $product->featured_image) }}',
                    @endif
                    @if($product->gallery_images && count($product->gallery_images) > 0)
                        @foreach($product->gallery_images as $image)
                            '{{ asset('storage/' . $image) }}',
                        @endforeach
                    @endif
                ],
                autoplayInterval: null,
                startAutoplay() {
                    this.autoplayInterval = setInterval(() => { this.next() }, 3000);
                },
                stopAutoplay() {
                    clearInterval(this.autoplayInterval);
                },
                next() {
                    this.currentSlide = (this.currentSlide + 1) % this.images.length;
                },
                prev() {
                    this.currentSlide = (this.currentSlide - 1 + this.images.length) % this.images.length;
                },
                goTo(index) {
                    this.currentSlide = index;
                    this.stopAutoplay();
                    this.startAutoplay();
                }
            }" x-init="if(images.length > 1) startAutoplay()" @mouseenter="stopAutoplay()" @mouseleave="if(images.length > 1) startAutoplay()">
                <div class="bg-white rounded-2xl shadow-md overflow-hidden mb-4 relative group">
                    <template x-if="images.length > 0">
                        <div class="relative">
                            <img :src="images[currentSlide]"
                                 alt="{{ $product->translate(app()->getLocale())->name }}"
                                 class="w-full h-[400px] sm:h-[500px] object-contain bg-gray-50 transition-opacity duration-500">

                            <!-- Prev/Next Buttons -->
                            <template x-if="images.length > 1">
                                <div>
                                    <button @click="prev(); stopAutoplay(); startAutoplay();"
                                            class="absolute left-3 top-1/2 -translate-y-1/2 w-10 h-10 bg-white/80 hover:bg-white rounded-full shadow-lg flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                        <i class="fas fa-chevron-left text-gray-700"></i>
                                    </button>
                                    <button @click="next(); stopAutoplay(); startAutoplay();"
                                            class="absolute right-3 top-1/2 -translate-y-1/2 w-10 h-10 bg-white/80 hover:bg-white rounded-full shadow-lg flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                        <i class="fas fa-chevron-right text-gray-700"></i>
                                    </button>
                                </div>
                            </template>

                            <!-- Slide Counter -->
                            <template x-if="images.length > 1">
                                <div class="absolute bottom-3 right-3 bg-black/50 text-white text-xs px-3 py-1 rounded-full">
                                    <span x-text="(currentSlide + 1) + ' / ' + images.length"></span>
                                </div>
                            </template>
                        </div>
                    </template>

                    <template x-if="images.length === 0">
                        @php
                            $gradients = [
                                'from-blue-500 via-indigo-600 to-purple-700',
                                'from-purple-500 via-pink-600 to-red-600',
                                'from-green-500 via-teal-600 to-blue-700',
                                'from-orange-500 via-red-600 to-pink-700',
                                'from-cyan-500 via-blue-600 to-indigo-700',
                            ];
                            $gradient = $gradients[$product->id % count($gradients)];
                        @endphp
                        <div class="w-full h-96 bg-gradient-to-br {{ $gradient }} flex items-center justify-center">
                            <i class="fas fa-flask text-white text-9xl opacity-30"></i>
                        </div>
                    </template>
                </div>

                <!-- Thumbnails -->
                <template x-if="images.length > 1">
                    <div class="grid gap-2" :style="'grid-template-columns: repeat(' + Math.min(images.length, 5) + ', 1fr)'">
                        <template x-for="(img, index) in images" :key="index">
                            <img :src="img" @click="goTo(index)"
                                 :class="currentSlide === index ? 'ring-2 ring-primary-500 opacity-100' : 'opacity-60 hover:opacity-100'"
                                 class="w-full h-20 sm:h-24 object-cover rounded-lg cursor-pointer transition-all">
                        </template>
                    </div>
                </template>
            </div>

            <!-- Product Details -->
            <div>
                <h1 class="text-2xl sm:text-4xl font-bold mb-4">{{ $product->translate(app()->getLocale())->name }}</h1>

                <div class="flex items-center gap-4 mb-6">
                    <span class="text-xs text-gray-500">{{ __('SKU') }}: {{ $product->sku }}</span>
                    <span class="text-xs px-3 py-1 rounded-full {{ $product->isOutOfStock() ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                        {{ $product->isOutOfStock() ? __('Out of Stock') : __('In Stock') }} ({{ $product->stock_quantity }})
                    </span>
                </div>

                <!-- Price -->
                <div class="mb-6 sm:mb-8">
                    @if($product->pricing->isSaleActive())
                        <div class="flex flex-wrap items-baseline gap-2 sm:gap-3">
                            <span class="text-2xl sm:text-4xl font-bold text-primary-500">PKR {{ number_format($product->pricing->sale_price, 0) }}</span>
                            <span class="text-lg sm:text-2xl text-gray-400 line-through">PKR {{ number_format($product->pricing->retail_price, 0) }}</span>
                            <span class="bg-secondary-500 text-white px-3 py-1 rounded-full text-xs sm:text-sm font-bold">
                                {{ number_format((($product->pricing->retail_price - $product->pricing->sale_price) / $product->pricing->retail_price) * 100, 0) }}% OFF
                            </span>
                        </div>
                    @else
                        <span class="text-2xl sm:text-4xl font-bold text-primary-500">PKR {{ number_format($product->pricing->retail_price, 0) }}</span>
                    @endif
                </div>

                <!-- Short Description -->
                <div class="mb-8">
                    <p class="text-gray-700 leading-relaxed">
                        {{ $product->translate(app()->getLocale())->short_description }}
                    </p>
                </div>

                <!-- MOQ & Wholesale Info -->
                @if($product->moq && $product->moq > 1)
                <div class="mb-6 bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded-lg">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-info-circle text-yellow-600"></i>
                        <div>
                            <p class="font-semibold text-gray-900">{{ __('Minimum Order Quantity') }}: {{ $product->moq }} {{ __('units') }}</p>
                            <p class="text-sm text-gray-600">{{ __('Wholesale orders require minimum') }} {{ $product->moq }} {{ __('units') }}</p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Wholesale Pricing Box -->
                @if($product->pricing->wholesale_price && $product->pricing->wholesale_price < $product->pricing->retail_price)
                <div class="mb-6 bg-gradient-to-r from-blue-50 to-indigo-50 border-2 border-blue-200 rounded-xl p-4 sm:p-6">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-3 gap-2">
                        <h3 class="font-bold text-base sm:text-lg text-gray-900 flex items-center">
                            <i class="fas fa-handshake text-blue-600 mr-2"></i>
                            {{ __('Wholesale Price') }} (B2B)
                        </h3>
                        <span class="px-3 py-1 bg-blue-600 text-white rounded-full text-sm font-bold">
                            {{ number_format((($product->pricing->retail_price - $product->pricing->wholesale_price) / $product->pricing->retail_price) * 100, 0) }}% OFF
                        </span>
                    </div>
                    <div class="flex flex-wrap items-baseline gap-2 mb-2">
                        <span class="text-2xl sm:text-3xl font-extrabold text-blue-600">PKR {{ number_format($product->pricing->wholesale_price, 0) }}</span>
                        <span class="text-sm text-gray-500 line-through">PKR {{ number_format($product->pricing->retail_price, 0) }}</span>
                    </div>
                    <p class="text-sm text-gray-600 mb-3">
                        <i class="fas fa-box-open mr-1"></i>{{ __('For orders of') }} {{ $product->moq ?? 1 }}+ {{ __('units') }}
                    </p>
                    @guest
                    <a href="{{ route('wholesale.register') }}" class="block text-center bg-blue-600 hover:bg-blue-700 text-white py-3 px-6 rounded-lg font-semibold transition">
                        <i class="fas fa-user-tie mr-2"></i>{{ __('Register as Dealer for Wholesale Pricing') }}
                    </a>
                    @endguest
                </div>
                @endif

                <!-- Low Stock Alert -->
                @if($product->isLowStock() && !$product->isOutOfStock())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg animate-pulse">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                        <div>
                            <p class="font-semibold text-red-900">{{ __('Low Stock Alert!') }}</p>
                            <p class="text-sm text-red-700">{{ __('Only') }} {{ $product->stock_quantity }} {{ __('units left. Order now!') }}</p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Add to Cart -->
                @livewire('add-to-cart', ['productId' => $product->id])

                <!-- Wholesale Pricing -->
                @if($product->wholesalePricing->count() > 0)
                    <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-4 sm:p-6">
                        <h3 class="font-bold text-base sm:text-lg mb-3 text-primary-500">{{ __('Wholesale Pricing') }}</h3>
                        <div class="space-y-2">
                            @foreach($product->wholesalePricing->sortBy('min_quantity') as $pricing)
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-700">
                                        {{ ucfirst($pricing->dealer_tier) }} ({{ $pricing->min_quantity }}+ units)
                                    </span>
                                    <span class="font-bold text-primary-500">PKR {{ number_format($pricing->unit_price, 0) }}</span>
                                </div>
                            @endforeach
                        </div>
                        <a href="{{ route('wholesale.register') }}" class="block mt-4 text-center bg-secondary-500 text-white py-2 rounded-lg hover:bg-secondary-600">
                            {{ __('Become a Dealer') }}
                        </a>
                    </div>
                @endif

                <!-- Share -->
                <div class="mt-6 flex gap-3">
                    <a href="https://wa.me/?text={{ urlencode(route('products.show', $product->slug)) }}"
                       target="_blank"
                       class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">
                        {{ __('Share on WhatsApp') }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Product Description -->
        <div class="mt-12">
            <div class="bg-white rounded-lg shadow-md p-4 sm:p-8">
                <h2 class="text-xl sm:text-2xl font-bold mb-4 sm:mb-6">{{ __('Product Description') }}</h2>
                <div class="prose max-w-none text-gray-700">
                    {!! nl2br(e($product->translate(app()->getLocale())->long_description)) !!}
                </div>
            </div>
        </div>

        <!-- Current Deals -->
        @if(isset($deals) && $deals->count() > 0)
            <div class="mt-12">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-3">
                    <h2 class="text-2xl font-bold flex items-center">
                        <i class="fas fa-fire text-red-500 mr-2"></i>{{ __('Current Deals') }}
                    </h2>
                    <a href="{{ route('deals.index') }}" class="text-red-500 hover:text-red-600 font-semibold text-sm">
                        {{ __('View All Deals') }} <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    @foreach($deals as $deal)
                        @php $dealTranslation = $deal->translate(app()->getLocale()); @endphp
                        <div class="bg-white rounded-xl shadow-md overflow-hidden hover-lift border-2 border-transparent hover:border-red-400 transition-all">
                            <div class="relative">
                                @if($deal->image)
                                    <img src="{{ asset('storage/' . $deal->image) }}" alt="{{ $dealTranslation->title ?? '' }}" class="w-full h-32 object-cover">
                                @else
                                    <div class="w-full h-32 bg-gradient-to-br from-red-400 to-orange-500 flex items-center justify-center">
                                        <i class="fas fa-fire text-white text-3xl opacity-50"></i>
                                    </div>
                                @endif
                                @if($deal->discount_percentage)
                                    <span class="absolute top-2 right-2 bg-red-600 text-white px-2 py-1 rounded-full text-xs font-bold">
                                        {{ number_format($deal->discount_percentage, 0) }}% {{ __('OFF') }}
                                    </span>
                                @endif
                            </div>
                            <div class="p-3">
                                <h3 class="font-bold text-gray-900 text-sm mb-1">{{ $dealTranslation->title ?? '' }}</h3>
                                @if($deal->url)
                                    <a href="{{ $deal->url }}" class="text-red-500 text-xs font-semibold hover:text-red-600">
                                        {{ __('Shop Now') }} <i class="fas fa-arrow-right ml-1"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
            <div class="mt-12">
                <h2 class="text-2xl font-bold mb-6">{{ __('Related Products') }}</h2>
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                    @foreach($relatedProducts as $relatedProduct)
                        <div class="product-card">
                            <div class="relative">
                                @if($relatedProduct->pricing->isSaleActive())
                                    <span class="absolute top-2 right-2 bg-secondary-500 text-white px-2 py-1 rounded-full text-xs font-bold z-10">
                                        {{ number_format((($relatedProduct->pricing->retail_price - $relatedProduct->pricing->sale_price) / $relatedProduct->pricing->retail_price) * 100, 0) }}% {{ __('OFF') }}
                                    </span>
                                @endif
                                <a href="{{ route('products.show', $relatedProduct->slug) }}">
                                    @if($relatedProduct->featured_image)
                                        <img src="{{ asset('storage/' . $relatedProduct->featured_image) }}"
                                             alt="{{ $relatedProduct->translate(app()->getLocale())->name }}"
                                             class="w-full h-48 object-cover">
                                    @else
                                        <div class="w-full h-48 bg-gradient-to-br from-blue-400 to-purple-600 flex items-center justify-center">
                                            <i class="fas fa-flask text-white text-6xl opacity-30"></i>
                                        </div>
                                    @endif
                                </a>
                            </div>
                            <div class="p-3 sm:p-4">
                                <h3 class="font-semibold text-gray-800 mb-2 text-sm sm:text-base">
                                    {{ $relatedProduct->translate(app()->getLocale())->name }}
                                </h3>
                                <div>
                                    @if($relatedProduct->pricing->isSaleActive())
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="text-gray-400 line-through text-xs sm:text-sm">PKR {{ number_format($relatedProduct->pricing->retail_price, 0) }}</span>
                                            <span class="bg-red-100 text-red-600 px-1.5 py-0.5 rounded text-xs font-bold">-{{ number_format((($relatedProduct->pricing->retail_price - $relatedProduct->pricing->sale_price) / $relatedProduct->pricing->retail_price) * 100, 0) }}%</span>
                                        </div>
                                        <div class="text-primary-500 font-bold text-sm sm:text-base">PKR {{ number_format($relatedProduct->pricing->sale_price, 0) }}</div>
                                    @else
                                        <div class="text-primary-500 font-bold text-sm sm:text-base">PKR {{ number_format($relatedProduct->pricing->retail_price, 0) }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection
