@extends('admin.layout')

@section('title', 'Products')
@section('page-title', 'Products Management')
@section('page-description', 'Manage all your products in one place')

@section('content')
<div class="animate-slide-in">
    <!-- Header with Add Button -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 flex items-center">
                <i class="fas fa-box text-purple-500 mr-3"></i>
                All Products
            </h2>
            <p class="text-sm text-gray-600 mt-1">Total: {{ $products->total() }} products</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="px-6 py-3 rounded-xl text-white font-semibold shadow-lg hover-lift" style="background: linear-gradient(135deg, #a855f7 0%, #9333ea 100%);">
            <i class="fas fa-plus mr-2"></i>Add New Product
        </a>
    </div>

    <!-- Products Table -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-purple-500 to-purple-600 text-white">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-bold">Product</th>
                        <th class="px-6 py-4 text-left text-sm font-bold">SKU</th>
                        <th class="px-6 py-4 text-left text-sm font-bold">Category</th>
                        <th class="px-6 py-4 text-left text-sm font-bold">Price</th>
                        <th class="px-6 py-4 text-left text-sm font-bold">Stock</th>
                        <th class="px-6 py-4 text-left text-sm font-bold">Status</th>
                        <th class="px-6 py-4 text-center text-sm font-bold">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($products as $product)
                        @php
                            $translation = $product->translations->where('locale', 'en')->first();
                            $pricing = $product->pricing;
                        @endphp
                        <tr class="hover:bg-purple-50 transition">
                            <!-- Product Name & Image -->
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @if($product->featured_image)
                                        <img src="{{ asset('storage/' . $product->featured_image) }}" alt="{{ $translation->name ?? 'Product' }}" class="w-12 h-12 rounded-lg object-cover flex-shrink-0">
                                    @else
                                        <div class="w-12 h-12 rounded-lg flex items-center justify-center flex-shrink-0" style="background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);">
                                            <i class="fas fa-box text-indigo-400"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-bold text-gray-900">{{ $translation->name ?? 'N/A' }}</p>
                                        @if($product->is_featured)
                                            <span class="inline-block px-2 py-1 bg-yellow-100 text-yellow-700 text-xs font-bold rounded mt-1">
                                                <i class="fas fa-star mr-1"></i>Featured
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <!-- SKU -->
                            <td class="px-6 py-4">
                                <span class="font-mono text-sm font-semibold text-purple-600">{{ $product->sku }}</span>
                            </td>

                            <!-- Category -->
                            <td class="px-6 py-4 text-sm text-gray-900">
                                {{ $product->category->translations->where('locale', 'en')->first()->name ?? 'N/A' }}
                            </td>

                            <!-- Price -->
                            <td class="px-6 py-4">
                                <div>
                                    <p class="text-lg font-bold text-green-600">PKR {{ number_format($pricing->retail_price ?? 0, 0) }}</p>
                                    @if(isset($pricing->wholesale_price))
                                        <p class="text-xs text-gray-500">Wholesale: PKR {{ number_format($pricing->wholesale_price, 0) }}</p>
                                    @endif
                                </div>
                            </td>

                            <!-- Stock -->
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-bold {{ $product->stock_quantity > 10 ? 'bg-green-100 text-green-700' : ($product->stock_quantity > 0 ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                                    {{ $product->stock_quantity }} units
                                </span>
                            </td>

                            <!-- Status with Toggle -->
                            <td class="px-6 py-4">
                                <form action="{{ route('admin.products.toggle-status', $product) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="px-4 py-2 rounded-lg text-sm font-bold transition {{ $product->is_active ? 'bg-green-500 hover:bg-green-600 text-white' : 'bg-gray-300 hover:bg-gray-400 text-gray-700' }}">
                                        @if($product->is_active)
                                            <i class="fas fa-check-circle mr-1"></i>Active
                                        @else
                                            <i class="fas fa-times-circle mr-1"></i>Inactive
                                        @endif
                                    </button>
                                </form>
                            </td>

                            <!-- Actions -->
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.products.edit', $product) }}"
                                       class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-semibold rounded-lg transition"
                                       title="Edit Product">
                                        <i class="fas fa-edit mr-1"></i>Edit
                                    </a>
                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-lg transition" title="Delete Product">
                                            <i class="fas fa-trash mr-1"></i>Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-16 text-center">
                                <i class="fas fa-box-open text-6xl text-gray-300 mb-4"></i>
                                <h3 class="text-xl font-bold text-gray-600 mb-2">No Products Found</h3>
                                <p class="text-gray-500 mb-6">Start by adding your first product</p>
                                <a href="{{ route('admin.products.create') }}" class="inline-block px-6 py-3 rounded-xl text-white font-semibold shadow-lg hover-lift" style="background: linear-gradient(135deg, #a855f7 0%, #9333ea 100%);">
                                    <i class="fas fa-plus mr-2"></i>Add Product
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($products->hasPages())
            <div class="p-6 border-t border-gray-200">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
