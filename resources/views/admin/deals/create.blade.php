@extends('admin.layout')

@section('title', 'Create Deal')
@section('page-title', 'Create New Deal')
@section('page-description', 'Add a new deal or promotion')

@section('content')
<div class="max-w-4xl animate-slide-in">
    <a href="{{ route('admin.deals.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-semibold mb-6">
        <i class="fas fa-arrow-left mr-2"></i>Back to Deals
    </a>

    <form action="{{ route('admin.deals.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl shadow-lg p-4 sm:p-8">
        @csrf

        <!-- Basic Information -->
        <div class="mb-8">
            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                <i class="fas fa-info-circle text-red-500 mr-3"></i>
                Deal Information
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Image -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Deal Image
                    </label>
                    <input type="file" name="image" accept="image/*"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent @error('image') border-red-500 @enderror">
                    <p class="text-xs text-gray-500 mt-1">Recommended: 800x400px, Max 2MB (JPG, PNG, WebP)</p>
                    @error('image')
                        <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- URL -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Deal Link URL
                    </label>
                    <input type="text" name="url" value="{{ old('url') }}" placeholder="https://..."
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                    <p class="text-xs text-gray-500 mt-1">Where should the deal link to? (optional)</p>
                </div>

                <!-- Discount Percentage -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Discount Percentage
                    </label>
                    <input type="number" name="discount_percentage" value="{{ old('discount_percentage') }}" min="0" max="100" step="0.01"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                    <p class="text-xs text-gray-500 mt-1">e.g. 20 for 20% OFF</p>
                </div>

                <!-- Starts At -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Start Date
                    </label>
                    <input type="datetime-local" name="starts_at" value="{{ old('starts_at') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                    <p class="text-xs text-gray-500 mt-1">Leave empty for immediately active</p>
                </div>

                <!-- Ends At -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        End Date
                    </label>
                    <input type="datetime-local" name="ends_at" value="{{ old('ends_at') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                    @error('ends_at')
                        <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">Leave empty for no expiry</p>
                </div>

                <!-- Sort Order -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Sort Order
                    </label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                </div>

                <!-- Active Status -->
                <div class="flex items-center">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                            class="w-5 h-5 text-red-600 border-gray-300 rounded focus:ring-2 focus:ring-red-500">
                        <span class="ml-3 text-sm font-semibold text-gray-700">
                            <i class="fas fa-check-circle text-green-500 mr-1"></i>Active
                        </span>
                    </label>
                </div>
            </div>
        </div>

        <!-- English Translation -->
        <div class="mb-8 p-4 sm:p-6 bg-blue-50 rounded-xl">
            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                <i class="fas fa-language text-blue-500 mr-3"></i>
                English Translation
            </h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Deal Title (English) <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="title_en" value="{{ old('title_en') }}" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('title_en') border-red-500 @enderror">
                    @error('title_en')
                        <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Description (English)
                    </label>
                    <textarea name="description_en" rows="3"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('description_en') }}</textarea>
                </div>
            </div>
        </div>

        <!-- Urdu Translation -->
        <div class="mb-8 p-4 sm:p-6 bg-green-50 rounded-xl">
            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                <i class="fas fa-language text-green-500 mr-3"></i>
                Urdu Translation (اردو)
            </h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Deal Title (Urdu) <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="title_ur" value="{{ old('title_ur') }}" required dir="rtl"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('title_ur') border-red-500 @enderror">
                    @error('title_ur')
                        <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Description (Urdu)
                    </label>
                    <textarea name="description_ur" rows="3" dir="rtl"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">{{ old('description_ur') }}</textarea>
                </div>
            </div>
        </div>

        <!-- Submit -->
        <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
            <button type="submit" class="flex-1 px-4 sm:px-6 py-3 sm:py-4 rounded-xl text-white font-bold text-sm sm:text-lg shadow-lg hover-lift" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);">
                <i class="fas fa-check mr-2"></i>Create Deal
            </button>
            <a href="{{ route('admin.deals.index') }}" class="flex-1 px-4 sm:px-6 py-3 sm:py-4 bg-gray-200 hover:bg-gray-300 rounded-xl text-gray-700 font-bold text-sm sm:text-lg text-center transition">
                <i class="fas fa-times mr-2"></i>Cancel
            </a>
        </div>
    </form>
</div>
@endsection
