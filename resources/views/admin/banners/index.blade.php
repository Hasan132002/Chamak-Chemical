@extends('admin.layout')

@section('title', 'Banners')
@section('page-title', 'Banner Management')
@section('page-description', 'Manage homepage banner slides')

@section('content')
<div class="animate-slide-in">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-4 sm:mb-6 gap-3">
        <div>
            <h2 class="text-xl sm:text-2xl font-bold text-gray-900 flex items-center">
                <i class="fas fa-images text-indigo-500 mr-2 sm:mr-3"></i>
                All Banners
            </h2>
            <p class="text-xs sm:text-sm text-gray-600 mt-1">Total: {{ $banners->count() }} banners</p>
        </div>
        <a href="{{ route('admin.banners.create') }}" class="px-4 sm:px-6 py-2 sm:py-3 rounded-xl text-white font-semibold shadow-lg hover-lift text-sm sm:text-base text-center" style="background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);">
            <i class="fas fa-plus mr-2"></i>Add New Banner
        </a>
    </div>

    <!-- Banners Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
        @forelse($banners as $banner)
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover-lift">
                <div class="relative">
                    <img src="{{ asset('storage/' . $banner->image) }}" alt="{{ $banner->title ?? 'Banner' }}" class="w-full h-40 sm:h-48 object-cover">
                    <div class="absolute top-3 right-3">
                        <span class="px-3 py-1 rounded-full text-xs font-bold {{ $banner->is_active ? 'bg-green-500 text-white' : 'bg-gray-500 text-white' }}">
                            {{ $banner->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                    <div class="absolute top-3 left-3">
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-black/50 text-white">
                            Order: {{ $banner->sort_order }}
                        </span>
                    </div>
                </div>
                <div class="p-4">
                    @if($banner->title)
                        <h3 class="font-bold text-gray-900 mb-1">{{ $banner->title }}</h3>
                    @endif
                    @if($banner->subtitle)
                        <p class="text-sm text-gray-600 mb-3">{{ $banner->subtitle }}</p>
                    @endif
                    @if($banner->button_text)
                        <p class="text-xs text-indigo-600 mb-3">
                            <i class="fas fa-link mr-1"></i>Button: {{ $banner->button_text }}
                        </p>
                    @endif
                    <div class="flex gap-2">
                        <a href="{{ route('admin.banners.edit', $banner) }}"
                           class="flex-1 text-center px-3 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-semibold rounded-lg transition">
                            <i class="fas fa-edit mr-1"></i>Edit
                        </a>
                        <form action="{{ route('admin.banners.destroy', $banner) }}" method="POST" class="flex-1" onsubmit="return confirm('Delete this banner?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full px-3 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-lg transition">
                                <i class="fas fa-trash mr-1"></i>Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-16">
                <i class="fas fa-images text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-xl font-bold text-gray-600 mb-2">No Banners Found</h3>
                <p class="text-gray-500 mb-6">Add banners to show on the homepage slider</p>
                <a href="{{ route('admin.banners.create') }}" class="inline-block px-6 py-3 rounded-xl text-white font-semibold shadow-lg hover-lift" style="background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);">
                    <i class="fas fa-plus mr-2"></i>Add Banner
                </a>
            </div>
        @endforelse
    </div>
</div>
@endsection
