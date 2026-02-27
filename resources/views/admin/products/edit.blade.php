@extends('admin.layout')

@section('title', 'Edit Product')
@section('page-title', 'Edit Product')
@section('page-description', 'Update product information')

@section('content')
<div class="max-w-6xl animate-slide-in">
    <!-- Back Button -->
    <a href="{{ route('admin.products.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-semibold mb-6">
        <i class="fas fa-arrow-left mr-2"></i>Back to Products
    </a>

    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl shadow-lg p-8">
        @csrf
        @method('PUT')

        <!-- Product Information -->
        <div class="mb-8">
            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                <i class="fas fa-info-circle text-blue-500 mr-3"></i>
                Product Information
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- SKU (Read-only) -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        SKU Code
                    </label>
                    <input type="text" value="{{ $product->sku }}" disabled
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-100 text-gray-600">
                    <p class="text-xs text-gray-500 mt-1">SKU cannot be changed</p>
                </div>

                <!-- Category -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Category <span class="text-red-500">*</span>
                    </label>
                    <select name="category_id" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->translations->where('locale', 'en')->first()->name ?? 'N/A' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Stock Quantity -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Stock Quantity <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity) }}" required min="0"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <!-- Featured Product -->
                <div class="flex items-center">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}
                            class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                        <span class="ml-3 text-sm font-semibold text-gray-700">
                            <i class="fas fa-star text-yellow-500 mr-1"></i>Mark as Featured
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
                <!-- Existing Images with Delete -->
                @if($product->featured_image || $product->gallery_images)
                <div class="mb-4">
                    <p class="text-sm font-semibold text-gray-700 mb-3">Current Images: <span class="text-xs text-red-500">(Hover to delete)</span></p>
                    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                        @if($product->featured_image)
                            <div class="relative group">
                                <img src="{{ asset('storage/' . $product->featured_image) }}" alt="Featured" class="w-full h-32 object-cover rounded-lg border-2 border-purple-300">
                                <span class="absolute top-2 left-2 bg-purple-500 text-white text-xs px-2 py-1 rounded font-bold">Main</span>
                                <button type="button" onclick="if(confirm('Delete main image?')) document.getElementById('delete_featured').value='1'; this.closest('.group').remove();"
                                    class="absolute top-2 right-2 bg-red-500 text-white w-7 h-7 rounded-full opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                                    <i class="fas fa-times text-sm"></i>
                                </button>
                            </div>
                        @endif

                        @if($product->gallery_images)
                            @foreach($product->gallery_images as $index => $image)
                                <div class="relative group">
                                    <img src="{{ asset('storage/' . $image) }}" alt="Gallery {{ $index + 1 }}" class="w-full h-32 object-cover rounded-lg border-2 border-gray-300">
                                    <span class="absolute top-2 left-2 bg-gray-700 text-white text-xs px-2 py-1 rounded">{{ $index + 2 }}</span>
                                    <button type="button" onclick="if(confirm('Delete this image?')) { let input = document.getElementById('delete_gallery_{{ $index }}'); if(input) input.value='{{ $image }}'; this.closest('.group').remove(); }"
                                        class="absolute top-2 right-2 bg-red-500 text-white w-7 h-7 rounded-full opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                                        <i class="fas fa-times text-sm"></i>
                                    </button>
                                    <input type="hidden" id="delete_gallery_{{ $index }}" name="delete_gallery_images[]" value="">
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <input type="hidden" id="delete_featured" name="delete_featured_image" value="0">
                </div>
                @endif

                <!-- Upload New Images -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Upload New Images <span class="text-xs text-gray-500">(Multiple)</span>
                    </label>
                    <input type="file" name="images[]" multiple accept="image/*"
                        class="w-full px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                    <p class="text-xs text-gray-500 mt-2">
                        <i class="fas fa-info-circle mr-1"></i>Max 2MB per image
                    </p>
                </div>
            </div>
        </div>

        <!-- Pricing Information -->
        @php
            $translationEn = $product->translations->where('locale', 'en')->first();
            $translationUr = $product->translations->where('locale', 'ur')->first();
        @endphp

        <div class="mb-8 p-6 bg-green-50 rounded-xl">
            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                <i class="fas fa-dollar-sign text-green-500 mr-3"></i>
                Pricing Information
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Retail Price (PKR) <span class="text-red-500">*</span></label>
                    <input type="number" name="retail_price" value="{{ old('retail_price', $product->pricing->retail_price ?? 0) }}" required min="0" step="0.01"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Wholesale Price (PKR) <span class="text-red-500">*</span></label>
                    <input type="number" name="wholesale_price" value="{{ old('wholesale_price', $product->pricing->wholesale_price ?? 0) }}" required min="0" step="0.01"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">MOQ <span class="text-red-500">*</span></label>
                    <input type="number" name="moq" value="{{ old('moq', $product->moq ?? 1) }}" required min="1"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                </div>
            </div>

            <!-- Discount / Sale Price Section -->
            <div class="mt-6 p-4 bg-red-50 rounded-xl border border-red-200">
                <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-tags text-red-500 mr-2"></i>
                    Discount / Sale Price
                    <span class="text-xs text-gray-500 ml-2 font-normal">(Optional - Leave empty for no discount)</span>
                    @if($product->pricing && $product->pricing->isSaleActive())
                        <span class="ml-3 bg-red-500 text-white text-xs px-2 py-1 rounded-full font-bold">SALE ACTIVE</span>
                    @endif
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Sale Price -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Sale / Discount Price (PKR)</label>
                        <input type="number" name="sale_price" value="{{ old('sale_price', $product->pricing->sale_price ?? '') }}" min="0" step="0.01"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500"
                            placeholder="e.g., 350">
                        <p class="text-xs text-gray-500 mt-1">Retail price will show as strikethrough, this will be the new price</p>
                    </div>

                    <!-- Sale Start Date -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Sale Start Date</label>
                        <input type="date" name="sale_start_date" value="{{ old('sale_start_date', $product->pricing->sale_start_date ? $product->pricing->sale_start_date->format('Y-m-d') : '') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500">
                        <p class="text-xs text-gray-500 mt-1">Leave empty to start immediately</p>
                    </div>

                    <!-- Sale End Date -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Sale End Date</label>
                        <input type="date" name="sale_end_date" value="{{ old('sale_end_date', $product->pricing->sale_end_date ? $product->pricing->sale_end_date->format('Y-m-d') : '') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500">
                        <p class="text-xs text-gray-500 mt-1">Leave empty for no end date</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Variations -->
        <div class="mb-8 p-6 bg-orange-50 rounded-xl">
            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                <i class="fas fa-weight text-orange-500 mr-3"></i>
                Product Variations (Sizes/Weights)
            </h3>

            <!-- Existing Variations - EDITABLE -->
            @if($product->variations && $product->variations->count() > 0)
            <div class="mb-6">
                <p class="text-sm font-semibold text-gray-700 mb-3">Existing Variations: <span class="text-xs text-gray-500">(Edit or delete)</span></p>
                <div class="space-y-3">
                    @foreach($product->variations as $variation)
                    <div class="existing-variation grid grid-cols-1 md:grid-cols-5 gap-4 p-4 bg-white rounded-lg border border-orange-200">
                        <input type="hidden" name="existing_variations[{{ $variation->id }}][id]" value="{{ $variation->id }}">

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Size/Weight</label>
                            <input type="text" name="existing_variations[{{ $variation->id }}][size]" value="{{ $variation->size }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Retail Price</label>
                            <input type="number" name="existing_variations[{{ $variation->id }}][retail_price]" value="{{ $variation->retail_price }}" step="0.01"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Wholesale Price</label>
                            <input type="number" name="existing_variations[{{ $variation->id }}][wholesale_price]" value="{{ $variation->wholesale_price }}" step="0.01"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Stock</label>
                            <input type="number" name="existing_variations[{{ $variation->id }}][stock]" value="{{ $variation->stock_quantity }}" min="0"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                        </div>
                        <div class="flex items-end">
                            <button type="button" onclick="if(confirm('Delete this variation?')) { document.getElementById('delete_var_{{ $variation->id }}').value='{{ $variation->id }}'; this.closest('.existing-variation').remove(); }"
                                class="w-full px-3 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-lg transition">
                                <i class="fas fa-trash mr-1"></i>Delete
                            </button>
                            <input type="hidden" id="delete_var_{{ $variation->id }}" name="delete_variations[]" value="">
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Add New Variations -->
            <div>
                <p class="text-sm font-semibold text-gray-700 mb-3">Add New Variations:</p>
                <div id="variations-container">
                    <div class="variation-item grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Size/Weight</label>
                            <input type="text" name="new_variations[0][size]" placeholder="e.g., 1 KG"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Retail Price</label>
                            <input type="number" name="new_variations[0][retail_price]" placeholder="e.g., 500" step="0.01"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Wholesale Price</label>
                            <input type="number" name="new_variations[0][wholesale_price]" placeholder="e.g., 400" step="0.01"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Stock</label>
                            <input type="number" name="new_variations[0][stock]" placeholder="e.g., 100" min="0"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                        </div>
                    </div>
                </div>

                <button type="button" id="add-variation" class="mt-2 px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-lg transition">
                    <i class="fas fa-plus mr-2"></i>Add More Variation
                </button>
            </div>
        </div>

        <!-- English Translation -->
        <div class="mb-8 p-6 bg-blue-50 rounded-xl">
            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                <i class="fas fa-language text-blue-500 mr-3"></i>
                English Translation
            </h3>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Product Name (English) <span class="text-red-500">*</span></label>
                    <input type="text" name="name_en" value="{{ old('name_en', $translationEn->name ?? '') }}" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Short Description <span class="text-red-500">*</span></label>
                    <textarea name="short_description_en" rows="2" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">{{ old('short_description_en', $translationEn->short_description ?? '') }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Full Description <span class="text-red-500">*</span></label>
                    <textarea name="description_en" rows="5" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">{{ old('description_en', $translationEn->long_description ?? '') }}</textarea>
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
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Product Name (Urdu) <span class="text-red-500">*</span></label>
                    <input type="text" name="name_ur" value="{{ old('name_ur', $translationUr->name ?? '') }}" required dir="rtl"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Short Description <span class="text-red-500">*</span></label>
                    <textarea name="short_description_ur" rows="2" required dir="rtl"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">{{ old('short_description_ur', $translationUr->short_description ?? '') }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Full Description <span class="text-red-500">*</span></label>
                    <textarea name="description_ur" rows="5" required dir="rtl"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">{{ old('description_ur', $translationUr->long_description ?? '') }}</textarea>
                </div>
            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="flex gap-4">
            <button type="submit" class="flex-1 px-6 py-4 rounded-xl text-white font-bold text-lg shadow-lg hover-lift" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
                <i class="fas fa-save mr-2"></i>Update Product
            </button>
            <a href="{{ route('admin.products.index') }}" class="flex-1 px-6 py-4 bg-gray-200 hover:bg-gray-300 rounded-xl text-gray-700 font-bold text-lg text-center transition">
                <i class="fas fa-times mr-2"></i>Cancel
            </a>
        </div>
    </form>
</div>

@push('scripts')
<script>
// Add Product Variation
let variationCount = 1;
document.getElementById('add-variation').addEventListener('click', function() {
    const container = document.getElementById('variations-container');
    const newVariation = `
        <div class="variation-item grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
            <div>
                <input type="text" name="new_variations[${variationCount}][size]" placeholder="e.g., 5 KG"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
            </div>
            <div>
                <input type="number" name="new_variations[${variationCount}][retail_price]" placeholder="Retail Price" step="0.01"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
            </div>
            <div>
                <input type="number" name="new_variations[${variationCount}][wholesale_price]" placeholder="Wholesale" step="0.01"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
            </div>
            <div class="flex gap-2">
                <input type="number" name="new_variations[${variationCount}][stock]" placeholder="Stock" min="0"
                    class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
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
