@extends('layouts.app')

@section('title', __('Products'))

@section('content')
    <!-- Breadcrumb with Back -->
    <div class="bg-gray-100 py-3">
        <div class="container mx-auto px-4">
            <div class="flex items-center gap-3">
                <a href="javascript:history.back()" class="flex items-center justify-center w-9 h-9 bg-white hover:bg-primary-500 hover:text-white text-gray-600 rounded-full shadow-sm transition">
                    <i class="fas fa-arrow-left text-sm"></i>
                </a>
                <nav class="text-sm">
                    <a href="{{ route('home') }}" class="text-gray-600 hover:text-primary-500">{{ __('Home') }}</a>
                    <span class="mx-2">/</span>
                    <span class="text-gray-900">{{ __('Products') }}</span>
                </nav>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-4 sm:py-6" x-data="{ quickView: null }">
        <!-- Search & Filter Bar (compact, always visible) -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-3 sm:p-4 mb-4 sm:mb-6">
            <div class="flex flex-col sm:flex-row gap-2 sm:gap-3">
                <form method="GET" action="{{ route('products.index') }}" class="flex flex-1 gap-2">
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="{{ __('Search products...') }}"
                           class="flex-1 px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                    <button type="submit" class="bg-primary-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-primary-600 transition">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
                <select onchange="window.location.href=this.value" class="px-3 py-2 border border-gray-200 rounded-lg text-sm">
                    <option value="{{ route('products.index', array_merge(request()->all(), ['sort' => 'name'])) }}" {{ request('sort') === 'name' ? 'selected' : '' }}>{{ __('Name') }}</option>
                    <option value="{{ route('products.index', array_merge(request()->all(), ['sort' => 'price_low'])) }}" {{ request('sort') === 'price_low' ? 'selected' : '' }}>{{ __('Price: Low') }}</option>
                    <option value="{{ route('products.index', array_merge(request()->all(), ['sort' => 'price_high'])) }}" {{ request('sort') === 'price_high' ? 'selected' : '' }}>{{ __('Price: High') }}</option>
                </select>
            </div>
            <!-- Category Pills -->
            <div class="flex flex-wrap gap-1.5 mt-3">
                <a href="{{ route('products.index') }}" class="px-3 py-1 rounded-full text-xs font-semibold transition {{ !request('category') ? 'bg-primary-500 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                    {{ __('All') }}
                </a>
                @foreach($categories as $category)
                    <a href="{{ route('products.index', ['category' => $category->slug]) }}"
                       class="px-3 py-1 rounded-full text-xs font-semibold transition {{ request('category') === $category->slug ? 'bg-primary-500 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        {{ $category->translate(app()->getLocale())->name }}
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Products Header -->
        <div class="flex justify-between items-center mb-3">
            <h1 class="text-lg sm:text-xl font-bold text-gray-800">{{ __('Products') }}</h1>
            <span class="text-gray-500 text-xs sm:text-sm">{{ $products->total() }} {{ __('found') }}</span>
        </div>

        <!-- Products Grid -->
        @if($products->count() > 0)
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-3 sm:gap-4">
                @foreach($products as $product)
                    @php
                        $translation = $product->translate(app()->getLocale());
                        $gradients = ['from-blue-400 via-blue-500 to-indigo-600','from-purple-400 via-pink-500 to-red-500','from-green-400 via-teal-500 to-blue-600','from-yellow-400 via-orange-500 to-red-600','from-pink-400 via-purple-500 to-indigo-600','from-cyan-400 via-blue-500 to-purple-600'];
                        $gradient = $gradients[$product->id % count($gradients)];
                    @endphp
                    <div class="group bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 hover:border-primary-500 hover:shadow-lg transition-all h-full flex flex-col">
                        <!-- Image with Quick View Overlay -->
                        <div class="relative overflow-hidden">
                            @if($product->pricing->isSaleActive())
                                <span class="absolute top-1.5 right-1.5 z-10 bg-red-500 text-white px-1.5 py-0.5 rounded text-[10px] font-bold">
                                    -{{ number_format((($product->pricing->retail_price - $product->pricing->sale_price) / $product->pricing->retail_price) * 100, 0) }}%
                                </span>
                            @endif
                            @if($product->isOutOfStock())
                                <span class="absolute top-1.5 left-1.5 z-10 bg-red-500 text-white px-1.5 py-0.5 rounded text-[10px] font-bold">
                                    {{ __('Out of Stock') }}
                                </span>
                            @endif

                            <a href="{{ route('products.show', $product->slug) }}">
                                @if($product->featured_image)
                                    <img src="{{ asset('storage/' . $product->featured_image) }}"
                                         alt="{{ $translation->name }}"
                                         class="w-full h-32 sm:h-40 object-cover group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <div class="w-full h-32 sm:h-40 bg-gradient-to-br {{ $gradient }} flex items-center justify-center">
                                        <i class="fas fa-flask text-white text-3xl opacity-30"></i>
                                    </div>
                                @endif
                            </a>

                            <!-- Hover Overlay with Quick View & Cart -->
                            <div class="absolute inset-0 bg-black/40 flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                <button @click.prevent="quickView = {
                                    name: {{ json_encode($translation->name) }},
                                    slug: {{ json_encode($product->slug) }},
                                    image: {{ json_encode($product->featured_image ? asset('storage/' . $product->featured_image) : '') }},
                                    category: {{ json_encode($product->category->translate(app()->getLocale())->name) }},
                                    brand: {{ json_encode($product->brand) }},
                                    weight: {{ json_encode($product->weight) }},
                                    sku: {{ json_encode($product->sku) }},
                                    stock: {{ json_encode($product->stock_quantity) }},
                                    moq: {{ json_encode($product->moq) }},
                                    outOfStock: {{ json_encode($product->isOutOfStock()) }},
                                    description: {{ json_encode($translation->short_description) }},
                                    price: {{ json_encode(number_format($product->pricing->getCurrentPrice(), 0)) }},
                                    retailPrice: {{ json_encode(number_format($product->pricing->retail_price, 0)) }},
                                    onSale: {{ json_encode($product->pricing->isSaleActive()) }},
                                    url: {{ json_encode(route('products.show', $product->slug)) }},
                                    gradient: {{ json_encode($gradient) }}
                                }"
                                    class="w-9 h-9 sm:w-10 sm:h-10 bg-white rounded-full flex items-center justify-center shadow-lg hover:bg-primary-500 hover:text-white text-gray-700 transition transform hover:scale-110"
                                    title="{{ __('Quick View') }}">
                                    <i class="fas fa-eye text-sm"></i>
                                </button>
                                <a href="{{ route('products.show', $product->slug) }}"
                                   class="w-9 h-9 sm:w-10 sm:h-10 bg-white rounded-full flex items-center justify-center shadow-lg hover:bg-primary-500 hover:text-white text-gray-700 transition transform hover:scale-110"
                                   title="{{ __('View Details') }}">
                                    <i class="fas fa-shopping-cart text-sm"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Product Info -->
                        <div class="p-2.5 sm:p-3 flex flex-col flex-1">
                            <p class="text-[10px] text-gray-400 font-semibold uppercase tracking-wide mb-0.5">
                                {{ $product->category->translate(app()->getLocale())->name }}
                            </p>
                            <a href="{{ route('products.show', $product->slug) }}">
                                <h3 class="font-bold text-xs sm:text-sm text-gray-900 group-hover:text-primary-500 transition line-clamp-2 mb-1 leading-tight">
                                    {{ $translation->name }}
                                </h3>
                            </a>

                            <!-- Extra Info: Brand & Weight -->
                            <div class="flex flex-wrap items-center gap-x-2 gap-y-0.5 mb-1.5 text-[10px] text-gray-400">
                                @if($product->brand)
                                    <span><i class="fas fa-tag mr-0.5"></i>{{ $product->brand }}</span>
                                @endif
                                @if($product->weight)
                                    <span><i class="fas fa-weight-hanging mr-0.5"></i>{{ $product->weight }}kg</span>
                                @endif
                            </div>

                            <!-- Short Description -->
                            @if($translation->short_description)
                                <p class="text-[10px] sm:text-[11px] text-gray-400 line-clamp-2 mb-1.5 leading-snug hidden sm:block">
                                    {{ $translation->short_description }}
                                </p>
                            @endif

                            <!-- Price (pushed to bottom) -->
                            <div class="mt-auto">
                                @if($product->pricing->isSaleActive())
                                    <span class="text-gray-400 line-through text-[10px]">PKR {{ number_format($product->pricing->retail_price, 0) }}</span>
                                    <div class="text-primary-500 font-bold text-sm">PKR {{ number_format($product->pricing->sale_price, 0) }}</div>
                                @else
                                    <div class="text-primary-500 font-bold text-sm">PKR {{ number_format($product->pricing->retail_price, 0) }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $products->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <div class="text-4xl mb-3"><i class="fas fa-search text-gray-300"></i></div>
                <h3 class="text-lg font-bold text-gray-800 mb-1">{{ __('No products found') }}</h3>
                <p class="text-gray-500 text-sm">{{ __('Try adjusting your search or filters') }}</p>
            </div>
        @endif

        <!-- Quick View Modal -->
        <div x-show="quickView" x-cloak
             class="fixed inset-0 z-50 flex items-center justify-center p-4"
             @keydown.escape.window="quickView = null"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" @click="quickView = null"></div>

            <!-- Modal Content -->
            <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto z-10"
                 x-show="quickView"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-90"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-90"
                 @click.stop>

                <!-- Close Button -->
                <button @click="quickView = null" class="absolute top-3 right-3 z-20 w-8 h-8 bg-gray-100 hover:bg-red-500 hover:text-white rounded-full flex items-center justify-center text-gray-500 transition">
                    <i class="fas fa-times text-sm"></i>
                </button>

                <div class="flex flex-col sm:flex-row" x-show="quickView">
                    <!-- Product Image -->
                    <div class="sm:w-5/12 flex-shrink-0">
                        <img x-show="quickView && quickView.image" :src="quickView ? quickView.image : ''" :alt="quickView ? quickView.name : ''" class="w-full h-56 sm:h-full object-cover sm:rounded-l-2xl">
                        <div x-show="quickView && !quickView.image" class="w-full h-56 sm:h-full bg-gradient-to-br flex items-center justify-center sm:rounded-l-2xl"
                             :class="quickView ? quickView.gradient : ''">
                            <i class="fas fa-flask text-white text-5xl opacity-30"></i>
                        </div>
                    </div>

                    <!-- Product Details -->
                    <div class="sm:w-7/12 p-5 sm:p-6">
                        <!-- Category -->
                        <p class="text-[11px] text-primary-500 font-semibold uppercase tracking-wide mb-1" x-text="quickView ? quickView.category : ''"></p>

                        <!-- Name -->
                        <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-2 leading-tight" x-text="quickView ? quickView.name : ''"></h3>

                        <!-- Price -->
                        <div class="mb-3">
                            <div x-show="quickView && quickView.onSale" class="flex items-baseline gap-2">
                                <span class="text-2xl font-extrabold text-primary-500">PKR <span x-text="quickView ? quickView.price : ''"></span></span>
                                <span class="text-sm text-gray-400 line-through">PKR <span x-text="quickView ? quickView.retailPrice : ''"></span></span>
                            </div>
                            <span x-show="quickView && !quickView.onSale" class="text-2xl font-extrabold text-primary-500">PKR <span x-text="quickView ? quickView.price : ''"></span></span>
                        </div>

                        <!-- Stock Status -->
                        <div class="mb-3">
                            <span x-show="quickView && quickView.outOfStock" class="inline-flex items-center gap-1 px-2.5 py-1 bg-red-100 text-red-700 rounded-full text-xs font-semibold">
                                <i class="fas fa-times-circle"></i> {{ __('Out of Stock') }}
                            </span>
                            <span x-show="quickView && !quickView.outOfStock" class="inline-flex items-center gap-1 px-2.5 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">
                                <i class="fas fa-check-circle"></i> {{ __('In Stock') }}
                            </span>
                        </div>

                        <!-- Details Grid -->
                        <div class="grid grid-cols-2 gap-2 mb-3 text-xs">
                            <div x-show="quickView && quickView.sku" class="bg-gray-50 rounded-lg px-3 py-2">
                                <span class="text-gray-400 block">{{ __('SKU') }}</span>
                                <span class="font-semibold text-gray-700" x-text="quickView ? quickView.sku : ''"></span>
                            </div>
                            <div x-show="quickView && quickView.brand" class="bg-gray-50 rounded-lg px-3 py-2">
                                <span class="text-gray-400 block">{{ __('Brand') }}</span>
                                <span class="font-semibold text-gray-700" x-text="quickView ? quickView.brand : ''"></span>
                            </div>
                            <div x-show="quickView && quickView.weight" class="bg-gray-50 rounded-lg px-3 py-2">
                                <span class="text-gray-400 block">{{ __('Weight') }}</span>
                                <span class="font-semibold text-gray-700" x-text="quickView ? quickView.weight + 'kg' : ''"></span>
                            </div>
                            <div x-show="quickView && quickView.moq > 1" class="bg-gray-50 rounded-lg px-3 py-2">
                                <span class="text-gray-400 block">{{ __('Min Order') }}</span>
                                <span class="font-semibold text-gray-700" x-text="quickView ? quickView.moq + ' pcs' : ''"></span>
                            </div>
                        </div>

                        <!-- Description -->
                        <div x-show="quickView && quickView.description" class="mb-4">
                            <p class="text-xs text-gray-500 leading-relaxed line-clamp-4" x-text="quickView ? quickView.description : ''"></p>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-2">
                            <a :href="quickView ? quickView.url : '#'"
                               class="flex-1 bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white font-bold py-2.5 px-4 rounded-xl text-center text-sm transition shadow-md hover:shadow-lg">
                                <i class="fas fa-shopping-cart mr-1.5"></i>{{ __('Add to Cart') }}
                            </a>
                            <a :href="quickView ? quickView.url : '#'"
                               class="px-4 py-2.5 border-2 border-gray-200 hover:border-primary-500 text-gray-600 hover:text-primary-500 font-bold rounded-xl text-center text-sm transition">
                                <i class="fas fa-info-circle mr-1.5"></i>{{ __('Details') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
