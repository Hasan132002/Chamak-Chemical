@extends('layouts.app')

@section('title', __('Blog'))

@section('content')
    <div class="bg-gradient-to-r from-primary-500 to-blue-600 text-white py-10 sm:py-16">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-3xl sm:text-5xl font-extrabold mb-3 sm:mb-4"><i class="fas fa-blog mr-2 sm:mr-3"></i>{{ __('Blog') }}</h1>
            <p class="text-base sm:text-xl text-blue-100">{{ __('Tips, guides, and news about chemical products') }}</p>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8 sm:py-16">
        @if($posts->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-8">
                @foreach($posts as $post)
                    @php
                        $translation = $post->translate(app()->getLocale());
                    @endphp
                    <article class="bg-white rounded-2xl shadow-lg overflow-hidden hover-lift transition">
                        <!-- Featured Image -->
                        <div class="relative h-56">
                            @if($post->featured_image)
                                <img src="{{ asset('storage/' . $post->featured_image) }}"
                                     alt="{{ $translation->title ?? 'Blog Post' }}"
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-blue-400 via-purple-500 to-pink-600 flex items-center justify-center">
                                    <i class="fas fa-newspaper text-white text-6xl opacity-30"></i>
                                </div>
                            @endif

                            <!-- Date Badge -->
                            <div class="absolute top-4 left-4 bg-white rounded-lg px-3 py-2 shadow-lg">
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-primary-600">{{ $post->published_at->format('d') }}</div>
                                    <div class="text-xs text-gray-600 uppercase">{{ $post->published_at->format('M') }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-6">
                            <!-- Categories -->
                            @if($post->categories->count() > 0)
                            <div class="flex gap-2 mb-3">
                                @foreach($post->categories->take(2) as $category)
                                    <span class="px-3 py-1 bg-primary-100 text-primary-700 rounded-full text-xs font-bold">
                                        {{ $category->translate(app()->getLocale())->name ?? 'Category' }}
                                    </span>
                                @endforeach
                            </div>
                            @endif

                            <!-- Title -->
                            <h2 class="text-xl font-bold text-gray-900 mb-3 hover:text-primary-600 transition line-clamp-2">
                                <a href="#">{{ $translation->title ?? 'Untitled' }}</a>
                            </h2>

                            <!-- Excerpt -->
                            <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                {{ Str::limit(strip_tags($translation->content ?? ''), 120) }}
                            </p>

                            <!-- Meta -->
                            <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                <div class="flex items-center gap-2 text-sm text-gray-500">
                                    <i class="fas fa-user"></i>
                                    <span>{{ $post->author->name ?? 'Admin' }}</span>
                                </div>
                                <div class="flex items-center gap-2 text-sm text-gray-500">
                                    <i class="fas fa-eye"></i>
                                    <span>{{ $post->view_count ?? 0 }}</span>
                                </div>
                            </div>

                            <!-- Read More -->
                            <a href="#" class="mt-4 inline-block text-primary-600 hover:text-primary-700 font-semibold text-sm">
                                {{ __('Read More') }} <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $posts->links() }}
            </div>
        @else
            <!-- No Blog Posts -->
            <div class="text-center py-16">
                <div class="text-6xl mb-6"><i class="fas fa-newspaper text-gray-300"></i></div>
                <h2 class="text-3xl font-bold text-gray-800 mb-4">{{ __('No Blog Posts Yet') }}</h2>
                <p class="text-gray-600 mb-8">{{ __('Check back soon for informative articles about chemical products and safety.') }}</p>
                <a href="{{ route('home') }}" class="inline-block bg-primary-500 hover:bg-primary-600 text-white px-8 py-3 rounded-full font-semibold transition">
                    <i class="fas fa-home mr-2"></i>{{ __('Back to Home') }}
                </a>
            </div>
        @endif
    </div>
@endsection
