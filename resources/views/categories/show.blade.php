@extends('layouts.app')

@section('title', $category->translate(app()->getLocale())->name)

@section('content')
    <!-- Breadcrumb with Back Button -->
    <div class="bg-gray-100 py-3">
        <div class="container mx-auto px-4">
            <div class="flex items-center gap-3">
                <a href="javascript:history.back()" class="flex items-center justify-center w-9 h-9 bg-white hover:bg-primary-500 hover:text-white text-gray-600 rounded-full shadow-sm transition" title="{{ __('Go Back') }}">
                    <i class="fas fa-arrow-left text-sm"></i>
                </a>
                <nav class="text-sm">
                    <a href="{{ route('home') }}" class="text-gray-600 hover:text-primary-500">{{ __('Home') }}</a>
                    <span class="mx-2">/</span>
                    <a href="{{ route('categories.index') }}" class="text-gray-600 hover:text-primary-500">{{ __('Categories') }}</a>
                    <span class="mx-2">/</span>
                    <span class="text-gray-900">{{ $category->translate(app()->getLocale())->name }}</span>
                </nav>
            </div>
        </div>
    </div>

    <!-- Category Header -->
    <div class="bg-gradient-to-r from-primary-500 to-primary-700 text-white py-6 sm:py-8">
        <div class="container mx-auto px-4">
            <h1 class="text-2xl sm:text-3xl font-bold mb-1">{{ $category->translate(app()->getLocale())->name }}</h1>
            <p class="text-sm sm:text-base opacity-90">{{ $category->translate(app()->getLocale())->description }}</p>
        </div>
    </div>

    <!-- Products -->
    <div class="container mx-auto px-4 py-6">
        @if($products->count() > 0)
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-bold text-gray-700">{{ $products->total() }} {{ __('Products') }}</h2>
                <a href="{{ route('products.index') }}" class="text-primary-500 hover:text-primary-600 text-sm">
                    {{ __('View All Products') }} →
                </a>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-3 sm:gap-4">
                @foreach($products as $product)
                    <a href="{{ route('products.show', $product->slug) }}" class="group">
                        <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 hover:border-primary-500 hover:shadow-lg transition-all h-full">
                            <div class="relative overflow-hidden">
                                @if($product->pricing->isSaleActive())
                                    <span class="absolute top-1.5 right-1.5 z-10 bg-red-500 text-white px-1.5 py-0.5 rounded text-[10px] font-bold">
                                        {{ __('Sale') }}
                                    </span>
                                @endif
                                @if($product->featured_image)
                                    <img src="{{ asset('storage/' . $product->featured_image) }}"
                                         alt="{{ $product->translate(app()->getLocale())->name }}"
                                         class="w-full h-28 sm:h-36 object-cover group-hover:scale-105 transition-transform duration-300">
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
                                    <div class="w-full h-28 sm:h-36 bg-gradient-to-br {{ $gradient }} flex items-center justify-center">
                                        <i class="fas fa-flask text-white text-3xl opacity-30"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="p-2.5 sm:p-3">
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

            <!-- Pagination -->
            <div class="mt-6">
                {{ $products->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <div class="text-5xl mb-3"><i class="fas fa-box-open text-gray-300"></i></div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">{{ __('No products in this category yet') }}</h3>
                <a href="{{ route('products.index') }}" class="text-primary-500 hover:text-primary-600 text-sm">
                    {{ __('Browse all products') }} →
                </a>
            </div>
        @endif
    </div>
@endsection
