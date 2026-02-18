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
            <!-- Product Images -->
            <div>
                <div class="bg-white rounded-lg shadow-md overflow-hidden mb-4">
                    @if($product->featured_image)
                        <img src="{{ asset('storage/' . $product->featured_image) }}"
                             alt="{{ $product->translate(app()->getLocale())->name }}"
                             class="w-full h-auto">
                    @else
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
                    @endif
                </div>

                @if($product->gallery_images && count($product->gallery_images) > 0)
                    <div class="grid grid-cols-4 gap-2">
                        @foreach($product->gallery_images as $image)
                            <img src="{{ asset('storage/' . $image) }}" alt="Gallery image" class="w-full h-24 object-cover rounded-lg cursor-pointer hover:opacity-75">
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Product Details -->
            <div>
                <h1 class="text-4xl font-bold mb-4">{{ $product->translate(app()->getLocale())->name }}</h1>

                <div class="flex items-center gap-4 mb-6">
                    <span class="text-xs text-gray-500">{{ __('SKU') }}: {{ $product->sku }}</span>
                    <span class="text-xs px-3 py-1 rounded-full {{ $product->isOutOfStock() ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                        {{ $product->isOutOfStock() ? __('Out of Stock') : __('In Stock') }} ({{ $product->stock_quantity }})
                    </span>
                </div>

                <!-- Price -->
                <div class="mb-8">
                    @if($product->pricing->isSaleActive())
                        <div class="flex items-baseline gap-3">
                            <span class="text-4xl font-bold text-primary-500">PKR {{ number_format($product->pricing->sale_price, 0) }}</span>
                            <span class="text-2xl text-gray-400 line-through">PKR {{ number_format($product->pricing->retail_price, 0) }}</span>
                            <span class="bg-secondary-500 text-white px-3 py-1 rounded-full text-sm font-bold">
                                {{ number_format((($product->pricing->retail_price - $product->pricing->sale_price) / $product->pricing->retail_price) * 100, 0) }}% OFF
                            </span>
                        </div>
                    @else
                        <span class="text-4xl font-bold text-primary-500">PKR {{ number_format($product->pricing->retail_price, 0) }}</span>
                    @endif
                </div>

                <!-- Short Description -->
                <div class="mb-8">
                    <p class="text-gray-700 leading-relaxed">
                        {{ $product->translate(app()->getLocale())->short_description }}
                    </p>
                </div>

                <!-- Add to Cart -->
                @livewire('add-to-cart', ['productId' => $product->id])

                <!-- Wholesale Pricing -->
                @if($product->wholesalePricing->count() > 0)
                    <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
                        <h3 class="font-bold text-lg mb-3 text-primary-500">{{ __('Wholesale Pricing') }}</h3>
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
            <div class="bg-white rounded-lg shadow-md p-8">
                <h2 class="text-2xl font-bold mb-6">{{ __('Product Description') }}</h2>
                <div class="prose max-w-none text-gray-700">
                    {!! nl2br(e($product->translate(app()->getLocale())->long_description)) !!}
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
            <div class="mt-12">
                <h2 class="text-2xl font-bold mb-6">{{ __('Related Products') }}</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($relatedProducts as $relatedProduct)
                        <div class="product-card">
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
                            <div class="p-4">
                                <h3 class="font-semibold text-gray-800 mb-2">
                                    {{ $relatedProduct->translate(app()->getLocale())->name }}
                                </h3>
                                <div class="text-primary-500 font-bold">
                                    PKR {{ number_format($relatedProduct->pricing->getCurrentPrice(), 0) }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection
