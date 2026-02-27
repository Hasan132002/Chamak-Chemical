@extends('layouts.app')

@section('title', __('All Categories'))

@section('content')
    <div class="bg-gradient-to-r from-primary-500 to-blue-600 text-white py-10 sm:py-16">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-3xl sm:text-5xl font-extrabold mb-3 sm:mb-4">{{ __('Product Categories') }}</h1>
            <p class="text-base sm:text-xl text-blue-100">{{ __('Explore our complete range of chemical products') }}</p>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8 sm:py-16">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-8">
            @foreach($categories as $category)
                <a href="{{ route('categories.show', $category->slug) }}" class="group">
                    <div class="bg-white rounded-2xl shadow-lg p-6 sm:p-10 hover-lift border-2 border-transparent hover:border-primary-500 transition-all">
                        <div class="text-center">
                            <div class="w-24 h-24 gradient-primary rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 group-hover:rotate-6 transition-all">
                                <i class="fas fa-flask text-5xl text-white"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-3 group-hover:text-primary-500 transition">
                                {{ $category->translate(app()->getLocale())->name }}
                            </h3>
                            <p class="text-gray-600 mb-4">
                                {{ $category->translate(app()->getLocale())->description }}
                            </p>
                            <div class="inline-flex items-center text-primary-500 font-semibold group-hover:translate-x-2 transition">
                                <span>{{ __('View Products') }}</span>
                                <i class="fas fa-arrow-right ml-2"></i>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endsection
