@extends('admin.layout')

@section('title', 'Blog Management')
@section('page-title', 'Blog Posts')
@section('page-description', 'Manage your blog content')

@section('content')
<div class="animate-slide-in">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 flex items-center">
                <i class="fas fa-blog text-green-500 mr-3"></i>
                All Blog Posts
            </h2>
            <p class="text-sm text-gray-600 mt-1">Create and manage blog articles</p>
        </div>
        <button class="px-6 py-3 rounded-xl text-white font-semibold shadow-lg hover-lift" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
            <i class="fas fa-plus mr-2"></i>New Post
        </button>
    </div>

    <!-- Blog Posts Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @for($i = 1; $i <= 6; $i++)
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover-lift">
            <div class="h-48 bg-gradient-to-br from-green-100 to-blue-100 flex items-center justify-center">
                <i class="fas fa-image text-6xl text-gray-300"></i>
            </div>

            <div class="p-6">
                <div class="flex items-center gap-2 mb-3">
                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">Published</span>
                    <span class="text-xs text-gray-500">{{ now()->subDays($i)->format('M d, Y') }}</span>
                </div>

                <h3 class="text-xl font-bold text-gray-900 mb-2 line-clamp-2">Sample Blog Post Title #{{ $i }}</h3>
                <p class="text-sm text-gray-600 mb-4 line-clamp-3">This is a sample blog post description that provides a brief overview of the content...</p>

                <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                    <span><i class="fas fa-eye mr-1"></i>{{ rand(50, 500) }} views</span>
                    <span><i class="fas fa-comment mr-1"></i>{{ rand(0, 20) }} comments</span>
                </div>

                <div class="flex gap-2 pt-4 border-t border-gray-100">
                    <button class="flex-1 px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-semibold rounded-lg transition">
                        <i class="fas fa-edit mr-1"></i>Edit
                    </button>
                    <button class="flex-1 px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-lg transition">
                        <i class="fas fa-trash mr-1"></i>Delete
                    </button>
                </div>
            </div>
        </div>
        @endfor
    </div>
</div>
@endsection
