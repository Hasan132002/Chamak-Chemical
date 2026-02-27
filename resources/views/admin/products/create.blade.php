@extends('admin.layout')

@section('title', 'Create Product')
@section('page-title', 'Create New Product')
@section('page-description', 'Add a new product to your catalog')

@section('content')
<div class="max-w-6xl animate-slide-in">
    <!-- Back Button -->
    <a href="{{ route('admin.products.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-semibold mb-6">
        <i class="fas fa-arrow-left mr-2"></i>Back to Products
    </a>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl shadow-lg p-8">
        @csrf

        <!-- Product Information -->
        <div class="mb-8">
            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                <i class="fas fa-info-circle text-blue-500 mr-3"></i>
                Product Information
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- SKU -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        SKU Code <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="sku" value="{{ old('sku') }}" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('sku') border-red-500 @enderror"
                        placeholder="e.g., WP-001">
                    @error('sku')
                        <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Category <span class="text-red-500">*</span>
                    </label>
                    <select name="category_id" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('category_id') border-red-500 @enderror">
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->translations->where('locale', 'en')->first()->name ?? 'N/A' }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Stock Quantity -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Stock Quantity <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="stock_quantity" value="{{ old('stock_quantity', 0) }}" required min="0"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('stock_quantity') border-red-500 @enderror"
                        placeholder="e.g., 100">
                    @error('stock_quantity')
                        <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Featured Product -->
                <div class="flex items-center">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}
                            class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                        <span class="ml-3 text-sm font-semibold text-gray-700">
                            <i class="fas fa-star text-yellow-500 mr-1"></i>Mark as Featured Product
                        </span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Product Images -->
        <div class="mb-8 p-6 bg-purple-50 rounded-xl">
            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                <i class="fas fa-images text-purple-500 mr-3"></i>
                Product Images
            </h3>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Upload Images <span class="text-red-500">*</span>
                        <span class="text-xs text-gray-500">(You can select multiple images)</span>
                    </label>
                    <input type="file" name="images[]" multiple accept="image/*"
                        class="w-full px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('images') border-red-500 @enderror">
                    <p class="text-xs text-gray-500 mt-2">
                        <i class="fas fa-info-circle mr-1"></i>Recommended: JPG, PNG (Max 2MB each). First image will be the main product image.
                    </p>
                    @error('images')
                        <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Image Preview Area -->
                <div id="imagePreview" class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4"></div>
            </div>
        </div>

        <!-- Pricing Information -->
        <div class="mb-8 p-6 bg-green-50 rounded-xl">
            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                <i class="fas fa-dollar-sign text-green-500 mr-3"></i>
                Pricing Information
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Retail Price -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Retail Price (PKR) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="retail_price" value="{{ old('retail_price') }}" required min="0" step="0.01"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('retail_price') border-red-500 @enderror"
                        placeholder="e.g., 500">
                    @error('retail_price')
                        <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Wholesale Price -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Wholesale Price (PKR) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="wholesale_price" value="{{ old('wholesale_price') }}" required min="0" step="0.01"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('wholesale_price') border-red-500 @enderror"
                        placeholder="e.g., 400">
                    @error('wholesale_price')
                        <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Minimum Order Quantity (MOQ) -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        MOQ (Minimum Order) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="moq" value="{{ old('moq', 1) }}" required min="1"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent @error('moq') border-red-500 @enderror"
                        placeholder="e.g., 10">
                    <p class="text-xs text-gray-500 mt-1">Minimum quantity for wholesale orders</p>
                    @error('moq')
                        <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Discount / Sale Price Section -->
            <div class="mt-6 p-4 bg-red-50 rounded-xl border border-red-200">
                <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-tags text-red-500 mr-2"></i>
                    Discount / Sale Price
                    <span class="text-xs text-gray-500 ml-2 font-normal">(Optional - Leave empty for no discount)</span>
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Sale Price -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Sale / Discount Price (PKR)
                        </label>
                        <input type="number" name="sale_price" value="{{ old('sale_price') }}" min="0" step="0.01"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent @error('sale_price') border-red-500 @enderror"
                            placeholder="e.g., 350">
                        <p class="text-xs text-gray-500 mt-1">Retail price will show as strikethrough, this will be the new price</p>
                        @error('sale_price')
                            <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Sale Start Date -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Sale Start Date
                        </label>
                        <input type="date" name="sale_start_date" value="{{ old('sale_start_date') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent @error('sale_start_date') border-red-500 @enderror">
                        <p class="text-xs text-gray-500 mt-1">Leave empty to start immediately</p>
                        @error('sale_start_date')
                            <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Sale End Date -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Sale End Date
                        </label>
                        <input type="date" name="sale_end_date" value="{{ old('sale_end_date') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent @error('sale_end_date') border-red-500 @enderror">
                        <p class="text-xs text-gray-500 mt-1">Leave empty for no end date</p>
                        @error('sale_end_date')
                            <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Variations (Sizes/Weights) -->
        <div class="mb-8 p-6 bg-orange-50 rounded-xl">
            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                <i class="fas fa-weight text-orange-500 mr-3"></i>
                Product Variations (Sizes/Weights)
            </h3>

            <div id="variations-container">
                <div class="variation-item grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Size/Weight</label>
                        <input type="text" name="variations[0][size]" placeholder="e.g., 1 KG"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Retail Price (PKR)</label>
                        <input type="number" name="variations[0][retail_price]" placeholder="e.g., 500" step="0.01"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Wholesale Price (PKR)</label>
                        <input type="number" name="variations[0][wholesale_price]" placeholder="e.g., 400" step="0.01"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Stock</label>
                        <input type="number" name="variations[0][stock]" placeholder="e.g., 100" min="0"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                    </div>
                </div>
            </div>

            <button type="button" id="add-variation" class="mt-4 px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-lg transition">
                <i class="fas fa-plus mr-2"></i>Add More Variation
            </button>
        </div>

        <!-- English Translation -->
        <div class="mb-8 p-6 bg-blue-50 rounded-xl">
            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                <i class="fas fa-language text-blue-500 mr-3"></i>
                English Translation
            </h3>

            <div class="space-y-4">
                <!-- Name (EN) -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Product Name (English) <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name_en" value="{{ old('name_en') }}" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name_en') border-red-500 @enderror"
                        placeholder="e.g., Premium Washing Powder">
                    @error('name_en')
                        <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Short Description (EN) -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Short Description (English) <span class="text-red-500">*</span>
                    </label>
                    <textarea name="short_description_en" rows="2" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('short_description_en') border-red-500 @enderror"
                        placeholder="Brief product description (1-2 lines)">{{ old('short_description_en') }}</textarea>
                    @error('short_description_en')
                        <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Long Description (EN) -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Full Description (English) <span class="text-red-500">*</span>
                    </label>
                    <textarea name="description_en" rows="5" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description_en') border-red-500 @enderror"
                        placeholder="Detailed product description with features and benefits">{{ old('description_en') }}</textarea>
                    @error('description_en')
                        <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
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
                        Product Name (Urdu) <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name_ur" value="{{ old('name_ur') }}" required dir="rtl"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name_ur') border-red-500 @enderror"
                        placeholder="مثال: پریمیم واشنگ پاؤڈر">
                    @error('name_ur')
                        <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Short Description (UR) -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Short Description (Urdu) <span class="text-red-500">*</span>
                    </label>
                    <textarea name="short_description_ur" rows="2" required dir="rtl"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('short_description_ur') border-red-500 @enderror"
                        placeholder="مختصر تفصیل">{{ old('short_description_ur') }}</textarea>
                    @error('short_description_ur')
                        <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Long Description (UR) -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Full Description (Urdu) <span class="text-red-500">*</span>
                    </label>
                    <textarea name="description_ur" rows="5" required dir="rtl"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description_ur') border-red-500 @enderror"
                        placeholder="تفصیلی تفصیل">{{ old('description_ur') }}</textarea>
                    @error('description_ur')
                        <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="flex gap-4">
            <button type="submit" class="flex-1 px-6 py-4 rounded-xl text-white font-bold text-lg shadow-lg hover-lift" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                <i class="fas fa-check mr-2"></i>Create Product
            </button>
            <a href="{{ route('admin.products.index') }}" class="flex-1 px-6 py-4 bg-gray-200 hover:bg-gray-300 rounded-xl text-gray-700 font-bold text-lg text-center transition">
                <i class="fas fa-times mr-2"></i>Cancel
            </a>
        </div>
    </form>
</div>

@push('scripts')
<script>
// Image Preview
document.querySelector('input[name="images[]"]').addEventListener('change', function(e) {
    const preview = document.getElementById('imagePreview');
    preview.innerHTML = '';

    Array.from(e.target.files).forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = function(event) {
            const div = document.createElement('div');
            div.className = 'relative';
            div.innerHTML = `
                <img src="${event.target.result}" class="w-full h-32 object-cover rounded-lg border-2 border-purple-200">
                <span class="absolute top-2 left-2 bg-purple-500 text-white text-xs px-2 py-1 rounded">${index === 0 ? 'Main' : index + 1}</span>
            `;
            preview.appendChild(div);
        };
        reader.readAsDataURL(file);
    });
});

// Add Product Variation
let variationCount = 1;
document.getElementById('add-variation').addEventListener('click', function() {
    const container = document.getElementById('variations-container');
    const newVariation = `
        <div class="variation-item grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
            <div>
                <input type="text" name="variations[${variationCount}][size]" placeholder="e.g., 5 KG"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
            </div>
            <div>
                <input type="number" name="variations[${variationCount}][retail_price]" placeholder="Retail Price" step="0.01"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
            </div>
            <div>
                <input type="number" name="variations[${variationCount}][wholesale_price]" placeholder="Wholesale Price" step="0.01"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
            </div>
            <div class="flex gap-2">
                <input type="number" name="variations[${variationCount}][stock]" placeholder="Stock" min="0"
                    class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                <button type="button" onclick="this.closest('.variation-item').remove()" class="px-3 bg-red-500 text-white rounded-lg hover:bg-red-600">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', newVariation);
    variationCount++;
});
</script>
@endpush
@endsection
