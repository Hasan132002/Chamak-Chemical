@extends('admin.layout')

@section('title', 'Edit Category')
@section('page-title', 'Edit Category')
@section('page-description', 'Update category information')

@section('content')
<div class="max-w-4xl animate-slide-in">
    <!-- Back Button -->
    <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-semibold mb-6">
        <i class="fas fa-arrow-left mr-2"></i>Back to Categories
    </a>

    <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl shadow-lg p-8">
        @csrf
        @method('PUT')

        <!-- Basic Information -->
        <div class="mb-8">
            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                <i class="fas fa-info-circle text-orange-500 mr-3"></i>
                Basic Information
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Slug (Read-only) -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Slug
                    </label>
                    <input type="text" value="{{ $category->slug }}" disabled
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-100 text-gray-600">
                    <p class="text-xs text-gray-500 mt-1">Slug cannot be changed</p>
                </div>

                <!-- Sort Order -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Sort Order
                    </label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $category->sort_order) }}" min="0"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                    <p class="text-xs text-gray-500 mt-1">Display order (0 = first)</p>
                </div>

                <!-- Active Status -->
                <div class="md:col-span-2">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }}
                            class="w-5 h-5 text-orange-600 border-gray-300 rounded focus:ring-2 focus:ring-orange-500">
                        <span class="ml-3 text-sm font-semibold text-gray-700">
                            <i class="fas fa-check-circle text-green-500 mr-1"></i>Active (visible on website)
                        </span>
                    </label>
                </div>
            </div>
        </div>

        <!-- English Translation -->
        @php
            $translationEn = $category->translations->where('locale', 'en')->first();
            $translationUr = $category->translations->where('locale', 'ur')->first();
        @endphp

        <div class="mb-8 p-6 bg-blue-50 rounded-xl">
            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                <i class="fas fa-language text-blue-500 mr-3"></i>
                English Translation
            </h3>

            <div class="space-y-4">
                <!-- Name (EN) -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Category Name (English) <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name_en" value="{{ old('name_en', $translationEn->name ?? '') }}" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name_en') border-red-500 @enderror">
                    @error('name_en')
                        <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description (EN) -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Description (English)
                    </label>
                    <textarea name="description_en" rows="3"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('description_en', $translationEn->description ?? '') }}</textarea>
                </div>
            </div>
        </div>

        <!-- Urdu Translation -->
        <div class="mb-8 p-6 bg-green-50 rounded-xl">
            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                <i class="fas fa-language text-green-500 mr-3"></i>
                Urdu Translation (اردو)
            </h3>

            <div class="space-y-4">
                <!-- Name (UR) -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Category Name (Urdu) <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name_ur" value="{{ old('name_ur', $translationUr->name ?? '') }}" required dir="rtl"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name_ur') border-red-500 @enderror">
                    @error('name_ur')
                        <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description (UR) -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Description (Urdu)
                    </label>
                    <textarea name="description_ur" rows="3" dir="rtl"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('description_ur', $translationUr->description ?? '') }}</textarea>
                </div>
            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="flex gap-4">
            <button type="submit" class="flex-1 px-6 py-4 rounded-xl text-white font-bold text-lg shadow-lg hover-lift" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
                <i class="fas fa-save mr-2"></i>Update Category
            </button>
            <a href="{{ route('admin.categories.index') }}" class="flex-1 px-6 py-4 bg-gray-200 hover:bg-gray-300 rounded-xl text-gray-700 font-bold text-lg text-center transition">
                <i class="fas fa-times mr-2"></i>Cancel
            </a>
        </div>
    </form>
</div>
@endsection
