@extends('layouts.app')

@section('title', ($post->translate(app()->getLocale())->title ?? 'Blog Post'))

@section('content')
    <div class="bg-gray-100 py-4">
        <div class="container mx-auto px-4">
            <nav class="text-sm">
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-primary-500">{{ __('Home') }}</a>
                <span class="mx-2">/</span>
                <a href="{{ route('blog.index') }}" class="text-gray-600 hover:text-primary-500">{{ __('Blog') }}</a>
                <span class="mx-2">/</span>
                <span class="text-gray-900">{{ Str::limit($post->translate(app()->getLocale())->title ?? '', 40) }}</span>
            </nav>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8 sm:py-12">
        <div class="max-w-4xl mx-auto">
            @php $translation = $post->translate(app()->getLocale()); @endphp

            <!-- Featured Image -->
            @if($post->featured_image)
                <div class="rounded-2xl overflow-hidden mb-8 shadow-lg">
                    <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $translation->title ?? '' }}" class="w-full h-64 sm:h-96 object-cover">
                </div>
            @endif

            <!-- Categories -->
            @if($post->categories->count() > 0)
                <div class="flex gap-2 mb-4">
                    @foreach($post->categories as $category)
                        <span class="px-3 py-1 bg-primary-100 text-primary-700 rounded-full text-xs font-bold">
                            {{ $category->translate(app()->getLocale())->name ?? 'Category' }}
                        </span>
                    @endforeach
                </div>
            @endif

            <!-- Title -->
            <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mb-4">{{ $translation->title ?? 'Untitled' }}</h1>

            <!-- Meta -->
            <div class="flex items-center gap-6 text-sm text-gray-500 mb-8 pb-6 border-b border-gray-200">
                <div class="flex items-center gap-2">
                    <i class="fas fa-user"></i>
                    <span>{{ $post->author->name ?? 'Admin' }}</span>
                </div>
                @if($post->published_at)
                <div class="flex items-center gap-2">
                    <i class="fas fa-calendar"></i>
                    <span>{{ $post->published_at->format('M d, Y') }}</span>
                </div>
                @endif
                <div class="flex items-center gap-2">
                    <i class="fas fa-eye"></i>
                    <span>{{ $post->view_count ?? 0 }} {{ __('views') }}</span>
                </div>
            </div>

            <!-- Content -->
            <article class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                {!! $translation->content ?? '' !!}
            </article>

            <!-- Back to Blog -->
            <div class="mt-12 pt-8 border-t border-gray-200">
                <a href="{{ route('blog.index') }}" class="inline-flex items-center text-primary-600 hover:text-primary-700 font-semibold">
                    <i class="fas fa-arrow-left mr-2"></i>{{ __('Back to Blog') }}
                </a>
            </div>
        </div>
    </div>
@endsection
