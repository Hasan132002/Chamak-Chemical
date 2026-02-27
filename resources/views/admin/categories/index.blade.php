@extends('admin.layout')

@section('title', 'Categories')
@section('page-title', 'Categories Management')
@section('page-description', 'Manage product categories')

@section('content')
<div class="animate-slide-in">
    <!-- Header with Add Button -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 flex items-center">
                <i class="fas fa-th-large text-orange-500 mr-3"></i>
                All Categories
            </h2>
            <p class="text-sm text-gray-600 mt-1">Organize your products into categories</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="px-6 py-3 rounded-xl text-white font-semibold shadow-lg hover-lift" style="background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);">
            <i class="fas fa-plus mr-2"></i>Add New Category
        </a>
    </div>

    <!-- Categories Table -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-orange-500 to-orange-600 text-white">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-bold">Category</th>
                        <th class="px-6 py-4 text-left text-sm font-bold">Slug</th>
                        <th class="px-6 py-4 text-left text-sm font-bold">Products</th>
                        <th class="px-6 py-4 text-left text-sm font-bold">Order</th>
                        <th class="px-6 py-4 text-left text-sm font-bold">Status</th>
                        <th class="px-6 py-4 text-center text-sm font-bold">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @php
                        $categories = \App\Models\Category::with('translations', 'products')->orderBy('sort_order')->get();
                    @endphp

                    @forelse($categories as $category)
                        @php
                            $translation = $category->translations->where('locale', 'en')->first();
                        @endphp
                        <tr class="hover:bg-orange-50 transition">
                            <!-- Category Name -->
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background: linear-gradient(135deg, #fed7aa 0%, #fdba74 100%);">
                                        <i class="fas {{ $category->icon ?? 'fa-layer-group' }} text-orange-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-900">{{ $translation->name ?? 'N/A' }}</p>
                                        <p class="text-xs text-gray-500">{{ Str::limit($translation->description ?? '', 50) }}</p>
                                    </div>
                                </div>
                            </td>

                            <!-- Slug -->
                            <td class="px-6 py-4">
                                <span class="font-mono text-sm text-gray-600">{{ $category->slug }}</span>
                            </td>

                            <!-- Products Count -->
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-sm font-bold">
                                    <i class="fas fa-box mr-1"></i>{{ $category->products->count() }} Products
                                </span>
                            </td>

                            <!-- Sort Order -->
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-600">#{{ $category->sort_order ?? 0 }}</span>
                            </td>

                            <!-- Status -->
                            <td class="px-6 py-4">
                                @if($category->is_active)
                                    <span class="px-3 py-1 bg-green-500 text-white rounded-lg text-sm font-bold">
                                        <i class="fas fa-check-circle mr-1"></i>Active
                                    </span>
                                @else
                                    <span class="px-3 py-1 bg-gray-400 text-white rounded-lg text-sm font-bold">
                                        <i class="fas fa-times-circle mr-1"></i>Inactive
                                    </span>
                                @endif
                            </td>

                            <!-- Actions -->
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.categories.edit', $category) }}"
                                       class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-semibold rounded-lg transition">
                                        <i class="fas fa-edit mr-1"></i>Edit
                                    </a>
                                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure? This will affect products in this category.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-lg transition">
                                            <i class="fas fa-trash mr-1"></i>Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center">
                                <i class="fas fa-folder-open text-6xl text-gray-300 mb-4"></i>
                                <h3 class="text-xl font-bold text-gray-600 mb-2">No Categories Found</h3>
                                <p class="text-gray-500 mb-6">Start by creating your first category</p>
                                <a href="{{ route('admin.categories.create') }}" class="inline-block px-6 py-3 rounded-xl text-white font-semibold shadow-lg hover-lift" style="background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);">
                                    <i class="fas fa-plus mr-2"></i>Add Category
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
