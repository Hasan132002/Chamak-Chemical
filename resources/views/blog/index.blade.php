@extends('layouts.app')

@section('title', __('Blog'))

@section('content')
    <div class="bg-gradient-to-r from-primary-500 to-blue-600 text-white py-16">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-5xl font-extrabold mb-4"><i class="fas fa-blog mr-3"></i>{{ __('Blog') }}</h1>
            <p class="text-xl text-blue-100">{{ __('Tips, guides, and news about chemical products') }}</p>
        </div>
    </div>

    <div class="container mx-auto px-4 py-16">
        <div class="text-center py-16">
            <div class="text-6xl mb-6"><i class="fas fa-newspaper text-gray-300"></i></div>
            <h2 class="text-3xl font-bold text-gray-800 mb-4">{{ __('Blog Coming Soon') }}</h2>
            <p class="text-gray-600 mb-8">{{ __('We are working on bringing you informative articles about chemical products and safety.') }}</p>
            <a href="{{ route('home') }}" class="inline-block bg-primary-500 hover:bg-primary-600 text-white px-8 py-3 rounded-full font-semibold transition">
                <i class="fas fa-home mr-2"></i>{{ __('Back to Home') }}
            </a>
        </div>
    </div>
@endsection
