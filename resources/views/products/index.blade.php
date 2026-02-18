@extends('layouts.app')

@section('title', __('Products'))

@section('content')
    <!-- Breadcrumb -->
    <div class="bg-gray-100 py-4">
        <div class="container mx-auto px-4">
            <nav class="text-sm">
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-primary-500">{{ __('Home') }}</a>
                <span class="mx-2">/</span>
                <span class="text-gray-900">{{ __('Products') }}</span>
            </nav>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <div class="flex flex-col md:flex-row gap-8">
            <!-- Filters Sidebar -->
            <aside class="w-full md:w-64 flex-shrink-0">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="font-bold text-lg mb-4">{{ __('Filters') }}</h3>

                    <!-- Search -->
                    <form method="GET" action="{{ route('products.index') }}" class="mb-6">
                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="{{ __('Search products...') }}"
                               class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                        <button type="submit" class="w-full mt-2 bg-primary-500 text-white py-2 rounded-lg hover:bg-primary-600">
                            {{ __('Search') }}
                        </button>
                    </form>

                    <!-- Categories -->
                    <div class="mb-6">
                        <h4 class="font-semibold mb-3">{{ __('Categories') }}</h4>
                        <ul class="space-y-2">
                            <li>
                                <a href="{{ route('products.index') }}"
                                   class="text-gray-700 hover:text-primary-500 {{ !request('category') ? 'font-bold text-primary-500' : '' }}">
                                    {{ __('All Products') }}
                                </a>
                            </li>
                            @foreach($categories as $category)
                                <li>
                                    <a href="{{ route('products.index', ['category' => $category->slug]) }}"
                                       class="text-gray-700 hover:text-primary-500 {{ request('category') === $category->slug ? 'font-bold text-primary-500' : '' }}">
                                        {{ $category->translate(app()->getLocale())->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Sort -->
                    <div>
                        <h4 class="font-semibold mb-3">{{ __('Sort By') }}</h4>
                        <select onchange="window.location.href=this.value" class="w-full px-4 py-2 border rounded-lg">
                            <option value="{{ route('products.index', array_merge(request()->all(), ['sort' => 'name'])) }}" {{ request('sort') === 'name' ? 'selected' : '' }}>
                                {{ __('Name') }}
                            </option>
                            <option value="{{ route('products.index', array_merge(request()->all(), ['sort' => 'price_low'])) }}" {{ request('sort') === 'price_low' ? 'selected' : '' }}>
                                {{ __('Price: Low to High') }}
                            </option>
                            <option value="{{ route('products.index', array_merge(request()->all(), ['sort' => 'price_high'])) }}" {{ request('sort') === 'price_high' ? 'selected' : '' }}>
                                {{ __('Price: High to Low') }}
                            </option>
                        </select>
                    </div>
                </div>
            </aside>

            <!-- Products Grid -->
            <div class="flex-1">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-3xl font-bold">{{ __('Products') }}</h1>
                    <span class="text-gray-600">{{ $products->total() }} {{ __('products found') }}</span>
                </div>

                @if($products->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($products as $product)
                            <div class="product-card">
                                <div class="relative">
                                    @if($product->pricing->isSaleActive())
                                        <span class="absolute top-2 right-2 bg-secondary-500 text-white px-3 py-1 rounded-full text-sm font-bold z-10">
                                            {{ __('Sale') }}
                                        </span>
                                    @endif
                                    @if($product->isOutOfStock())
                                        <span class="absolute top-2 left-2 bg-red-500 text-white px-3 py-1 rounded-full text-sm font-bold z-10">
                                            {{ __('Out of Stock') }}
                                        </span>
                                    @elseif($product->isLowStock())
                                        <span class="absolute top-2 left-2 bg-yellow-500 text-white px-3 py-1 rounded-full text-sm font-bold z-10">
                                            {{ __('Low Stock') }}
                                        </span>
                                    @endif
                                    <a href="{{ route('products.show', $product->slug) }}">
                                        @if($product->featured_image)
                                            <img src="{{ asset('storage/' . $product->featured_image) }}"
                                                 alt="{{ $product->translate(app()->getLocale())->name }}"
                                                 class="w-full h-64 object-cover">
                                        @else
                                            @php
                                                $gradients = [
                                                    'from-blue-400 via-blue-500 to-indigo-600',
                                                    'from-purple-400 via-pink-500 to-red-500',
                                                    'from-green-400 via-teal-500 to-blue-600',
                                                    'from-yellow-400 via-orange-500 to-red-600',
                                                    'from-pink-400 via-purple-500 to-indigo-600',
                                                    'from-cyan-400 via-blue-500 to-purple-600',
                                                ];
                                                $gradient = $gradients[$product->id % count($gradients)];
                                            @endphp
                                            <div class="w-full h-64 bg-gradient-to-br {{ $gradient }} flex items-center justify-center">
                                                <i class="fas fa-flask text-white text-7xl opacity-30"></i>
                                            </div>
                                        @endif
                                    </a>
                                </div>
                                <div class="p-4">
                                    <div class="text-xs text-gray-500 mb-1">
                                        {{ $product->category->translate(app()->getLocale())->name }}
                                    </div>
                                    <h3 class="font-semibold text-gray-800 mb-2 hover:text-primary-500">
                                        <a href="{{ route('products.show', $product->slug) }}">
                                            {{ $product->translate(app()->getLocale())->name }}
                                        </a>
                                    </h3>
                                    <p class="text-gray-600 text-sm mb-4">
                                        {{ Str::limit($product->translate(app()->getLocale())->short_description, 80) }}
                                    </p>
                                    <div class="flex justify-between items-center">
                                        <div>
                                            @if($product->pricing->isSaleActive())
                                                <span class="text-gray-400 line-through text-sm block">PKR {{ number_format($product->pricing->retail_price, 0) }}</span>
                                                <span class="text-primary-500 font-bold text-lg">PKR {{ number_format($product->pricing->sale_price, 0) }}</span>
                                            @else
                                                <span class="text-primary-500 font-bold text-lg">PKR {{ number_format($product->pricing->retail_price, 0) }}</span>
                                            @endif
                                        </div>
                                        <a href="{{ route('products.show', $product->slug) }}" class="bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-lg text-sm transition">
                                            {{ __('View Details') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8">
                        {{ $products->links() }}
                    </div>
                @else
                    <div class="text-center py-16">
                        <div class="text-6xl mb-4">🔍</div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">{{ __('No products found') }}</h3>
                        <p class="text-gray-600">{{ __('Try adjusting your search or filters') }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
