@extends('admin.layout')

@section('title', 'Edit Banner')
@section('page-title', 'Edit Banner')
@section('page-description', 'Update banner information')

@section('content')
<div class="max-w-4xl animate-slide-in">
    <a href="{{ route('admin.banners.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-semibold mb-6">
        <i class="fas fa-arrow-left mr-2"></i>Back to Banners
    </a>

    <form action="{{ route('admin.banners.update', $banner) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl shadow-lg p-4 sm:p-8">
        @csrf
        @method('PUT')

        <div class="mb-8">
            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                <i class="fas fa-image text-indigo-500 mr-3"></i>
                Banner Details
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Current Image -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Current Image</label>
                    <img src="{{ asset('storage/' . $banner->image) }}" alt="Banner" class="w-full max-w-md h-40 object-cover rounded-lg">
                </div>

                <!-- Image -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Change Image</label>
                    <input type="file" name="image" accept="image/*"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    <p class="text-xs text-gray-500 mt-1">Leave empty to keep current image</p>
                </div>

                <!-- Title -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Banner Title</label>
                    <input type="text" name="title" value="{{ old('title', $banner->title) }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                </div>

                <!-- Subtitle -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Subtitle</label>
                    <input type="text" name="subtitle" value="{{ old('subtitle', $banner->subtitle) }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                </div>

                <!-- Button Text -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Button Text</label>
                    <input type="text" name="button_text" value="{{ old('button_text', $banner->button_text) }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                </div>

                <!-- Button URL -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Button URL</label>
                    <input type="text" name="button_url" value="{{ old('button_url', $banner->button_url) }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                </div>

                <!-- Sort Order -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Sort Order</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $banner->sort_order) }}" min="0"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                </div>

                <!-- Active Status -->
                <div class="flex items-center">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $banner->is_active) ? 'checked' : '' }}
                            class="w-5 h-5 text-indigo-600 border-gray-300 rounded focus:ring-2 focus:ring-indigo-500">
                        <span class="ml-3 text-sm font-semibold text-gray-700">
                            <i class="fas fa-check-circle text-green-500 mr-1"></i>Active
                        </span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Submit -->
        <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
            <button type="submit" class="flex-1 px-4 sm:px-6 py-3 sm:py-4 rounded-xl text-white font-bold text-sm sm:text-lg shadow-lg hover-lift" style="background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);">
                <i class="fas fa-save mr-2"></i>Update Banner
            </button>
            <a href="{{ route('admin.banners.index') }}" class="flex-1 px-4 sm:px-6 py-3 sm:py-4 bg-gray-200 hover:bg-gray-300 rounded-xl text-gray-700 font-bold text-sm sm:text-lg text-center transition">
                <i class="fas fa-times mr-2"></i>Cancel
            </a>
        </div>
    </form>
</div>
@endsection
