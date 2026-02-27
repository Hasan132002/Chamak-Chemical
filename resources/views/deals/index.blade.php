@extends('layouts.app')

@section('title', __('Deals & Promotions'))

@section('content')
    <div class="bg-gradient-to-r from-red-500 to-orange-600 text-white py-10 sm:py-16">
        <div class="container mx-auto px-4 text-center">
            <div class="text-5xl sm:text-7xl mb-4 sm:mb-6"><i class="fas fa-fire"></i></div>
            <h1 class="text-3xl sm:text-5xl md:text-6xl font-extrabold mb-3 sm:mb-4">{{ __('Hot Deals') }}</h1>
            <p class="text-base sm:text-xl text-orange-100">{{ __('Don\'t miss our amazing deals and promotions!') }}</p>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8 sm:py-16">
        @if($deals->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-8">
                @foreach($deals as $deal)
                    @php $translation = $deal->translate(app()->getLocale()); @endphp
                    <div class="group bg-white rounded-2xl shadow-lg overflow-hidden hover-lift border-2 border-transparent hover:border-red-500 transition-all">
                        <!-- Deal Image -->
                        <div class="relative overflow-hidden">
                            @if($deal->image)
                                <img src="{{ asset('storage/' . $deal->image) }}"
                                     alt="{{ $translation->title ?? '' }}"
                                     class="w-full h-48 sm:h-56 object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                                <div class="w-full h-48 sm:h-56 bg-gradient-to-br from-red-400 to-orange-500 flex items-center justify-center">
                                    <i class="fas fa-fire text-white text-6xl opacity-50"></i>
                                </div>
                            @endif

                            @if($deal->discount_percentage)
                                <div class="absolute top-3 right-3">
                                    <span class="bg-red-600 text-white px-4 py-2 rounded-full text-sm font-bold shadow-lg animate-pulse">
                                        {{ number_format($deal->discount_percentage, 0) }}% {{ __('OFF') }}
                                    </span>
                                </div>
                            @endif

                            @if($deal->ends_at)
                                <div class="absolute bottom-3 left-3">
                                    <span class="bg-black/70 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                        <i class="fas fa-clock mr-1"></i>{{ __('Ends') }}: {{ $deal->ends_at->format('d M, Y') }}
                                    </span>
                                </div>
                            @endif
                        </div>

                        <!-- Deal Info -->
                        <div class="p-5 sm:p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-red-500 transition">
                                {{ $translation->title ?? '' }}
                            </h3>
                            @if($translation->description)
                                <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                    {{ $translation->description }}
                                </p>
                            @endif

                            @if($deal->url)
                                <a href="{{ $deal->url }}" class="inline-flex items-center bg-gradient-to-r from-red-500 to-orange-500 text-white px-6 py-3 rounded-xl font-semibold hover:shadow-lg transition">
                                    <i class="fas fa-shopping-bag mr-2"></i>{{ __('Shop Now') }}
                                    <i class="fas fa-arrow-right ml-2"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-16">
                <i class="fas fa-fire text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-2xl font-bold text-gray-600 mb-2">{{ __('No Active Deals') }}</h3>
                <p class="text-gray-500 mb-6">{{ __('Check back later for amazing deals and promotions!') }}</p>
                <a href="{{ route('products.index') }}" class="inline-block bg-primary-500 text-white px-8 py-3 rounded-xl font-semibold hover:bg-primary-600 transition">
                    <i class="fas fa-shopping-bag mr-2"></i>{{ __('Browse Products') }}
                </a>
            </div>
        @endif
    </div>

    <style>
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
@endsection
