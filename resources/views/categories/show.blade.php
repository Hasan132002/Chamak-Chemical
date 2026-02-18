@extends('layouts.app')

@section('title', $category->translate(app()->getLocale())->name)

@section('content')
    <!-- Breadcrumb -->
    <div class="bg-gray-100 py-4">
        <div class="container mx-auto px-4">
            <nav class="text-sm">
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-primary-500">{{ __('Home') }}</a>
                <span class="mx-2">/</span>
                <a href="{{ route('categories.index') }}" class="text-gray-600 hover:text-primary-500">{{ __('Categories') }}</a>
                <span class="mx-2">/</span>
                <span class="text-gray-900">{{ $category->translate(app()->getLocale())->name }}</span>
            </nav>
        </div>
    </div>

    <!-- Category Header -->
    <div class="bg-gradient-to-r from-primary-500 to-primary-700 text-white py-12">
        <div class="container mx-auto px-4">
            <h1 class="text-4xl font-bold mb-4">{{ $category->translate(app()->getLocale())->name }}</h1>
            <p class="text-xl opacity-90">{{ $category->translate(app()->getLocale())->description }}</p>
        </div>
    </div>

    <!-- Products -->
    <div class="container mx-auto px-4 py-8">
        @if($products->count() > 0)
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold">{{ $products->total() }} {{ __('Products') }}</h2>
                <a href="{{ route('products.index') }}" class="text-primary-500 hover:text-primary-600">
                    {{ __('View All Products') }} →
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($products as $product)
                    <div class="product-card">
                        <div class="relative">
                            @if($product->pricing->isSaleActive())
                                <span class="absolute top-2 right-2 bg-secondary-500 text-white px-3 py-1 rounded-full text-sm font-bold z-10">
                                    {{ __('Sale') }}
                                </span>
                            @endif
                            <a href="{{ route('products.show', $product->slug) }}">
                                @if($product->featured_image)
                                    <img src="{{ asset('storage/' . $product->featured_image) }}"
                                         alt="{{ $product->translate(app()->getLocale())->name }}"
                                         class="w-full h-48 object-cover">
                                @else
                                    @php
                                        $gradients = [
                                            'from-blue-400 via-blue-500 to-indigo-600',
                                            'from-purple-400 via-pink-500 to-red-500',
                                            'from-green-400 via-teal-500 to-blue-600',
                                            'from-yellow-400 via-orange-500 to-red-600',
                                            'from-pink-400 via-purple-500 to-indigo-600',
                                        ];
                                        $gradient = $gradients[$product->id % count($gradients)];
                                    @endphp
                                    <div class="w-full h-48 bg-gradient-to-br {{ $gradient }} flex items-center justify-center">
                                        <i class="fas fa-flask text-white text-6xl opacity-30"></i>
                                    </div>
                                @endif
                            </a>
                        </div>
                        <div class="p-4">
                            <h3 class="font-semibold text-gray-800 mb-2 hover:text-primary-500">
                                <a href="{{ route('products.show', $product->slug) }}">
                                    {{ $product->translate(app()->getLocale())->name }}
                                </a>
                            </h3>
                            <p class="text-gray-600 text-sm mb-4">
                                {{ Str::limit($product->translate(app()->getLocale())->short_description, 60) }}
                            </p>
                            <div class="flex justify-between items-center">
                                <div>
                                    @if($product->pricing->isSaleActive())
                                        <span class="text-gray-400 line-through text-sm block">PKR {{ number_format($product->pricing->retail_price, 0) }}</span>
                                        <span class="text-primary-500 font-bold">PKR {{ number_format($product->pricing->sale_price, 0) }}</span>
                                    @else
                                        <span class="text-primary-500 font-bold">PKR {{ number_format($product->pricing->retail_price, 0) }}</span>
                                    @endif
                                </div>
                                <a href="{{ route('products.show', $product->slug) }}" class="bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-lg text-sm transition">
                                    {{ __('View') }}
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
                <div class="text-6xl mb-4">📦</div>
                <h3 class="text-2xl font-bold text-gray-800 mb-2">{{ __('No products in this category yet') }}</h3>
                <a href="{{ route('products.index') }}" class="text-primary-500 hover:text-primary-600">
                    {{ __('Browse all products') }} →
                </a>
            </div>
        @endif
    </div>
@endsection
