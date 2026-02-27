@extends('admin.layout')

@section('title', 'Edit Blog Post')
@section('page-title', 'Edit Blog Post')
@section('page-description', 'Update blog article content')

@section('content')
<div class="animate-slide-in">
    <div class="flex items-center justify-between mb-6">
        <a href="{{ route('admin.blog.index') }}" class="text-gray-600 hover:text-gray-800 font-semibold">
            <i class="fas fa-arrow-left mr-2"></i>Back to Blog Posts
        </a>
        <div class="flex items-center gap-3">
            @if($post->is_published)
                <span class="px-4 py-2 bg-green-100 text-green-700 rounded-full text-sm font-bold">
                    <i class="fas fa-check-circle mr-1"></i>Published
                </span>
            @else
                <span class="px-4 py-2 bg-yellow-100 text-yellow-700 rounded-full text-sm font-bold">
                    <i class="fas fa-clock mr-1"></i>Draft
                </span>
            @endif
        </div>
    </div>

    @if($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 px-6 py-4 rounded-lg mb-6">
            <div class="font-bold mb-2"><i class="fas fa-exclamation-triangle mr-2"></i>Please fix the following errors:</div>
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @php
        $enTranslation = $post->translations->where('locale', 'en')->first();
        $urTranslation = $post->translations->where('locale', 'ur')->first();
        $postCategoryIds = $post->categories->pluck('id')->toArray();
    @endphp

    <form action="{{ route('admin.blog.update', $post) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- English Content -->
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                        <span class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                            <span class="text-blue-600 text-sm font-bold">EN</span>
                        </span>
                        English Content
                    </h3>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Title *</label>
                            <input type="text" name="title_en" value="{{ old('title_en', $enTranslation->title ?? '') }}" required
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-blue-500 transition"
                                   placeholder="Enter blog post title">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Excerpt</label>
                            <textarea name="excerpt_en" rows="2"
                                      class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-blue-500 transition"
                                      placeholder="Brief summary of the post (optional)">{{ old('excerpt_en', $enTranslation->excerpt ?? '') }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Content *</label>
                            <textarea name="content_en" rows="12" required
                                      class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-blue-500 transition"
                                      placeholder="Write your blog post content here... (HTML supported)">{{ old('content_en', $enTranslation->content ?? '') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Urdu Content -->
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                        <span class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                            <span class="text-green-600 text-sm font-bold">UR</span>
                        </span>
                        Urdu Content
                    </h3>

                    <div class="space-y-4" dir="rtl">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">عنوان *</label>
                            <input type="text" name="title_ur" value="{{ old('title_ur', $urTranslation->title ?? '') }}" required
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-green-500 transition"
                                   placeholder="بلاگ پوسٹ کا عنوان درج کریں">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">خلاصہ</label>
                            <textarea name="excerpt_ur" rows="2"
                                      class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-green-500 transition"
                                      placeholder="پوسٹ کا مختصر خلاصہ (اختیاری)">{{ old('excerpt_ur', $urTranslation->excerpt ?? '') }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">مواد *</label>
                            <textarea name="content_ur" rows="12" required
                                      class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-green-500 transition"
                                      placeholder="اپنی بلاگ پوسٹ کا مواد یہاں لکھیں...">{{ old('content_ur', $urTranslation->content ?? '') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Publish Settings -->
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">
                        <i class="fas fa-cog text-gray-400 mr-2"></i>Publish Settings
                    </h3>

                    <div class="space-y-4">
                        <label class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl cursor-pointer hover:bg-green-50 transition">
                            <input type="checkbox" name="is_published" value="1"
                                   {{ old('is_published', $post->is_published) ? 'checked' : '' }}
                                   class="w-5 h-5 rounded text-green-500 focus:ring-green-500">
                            <div>
                                <span class="font-semibold text-gray-700">Published</span>
                                <p class="text-xs text-gray-500">Visible on the website</p>
                            </div>
                        </label>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Publish Date</label>
                            <input type="datetime-local" name="published_at"
                                   value="{{ old('published_at', $post->published_at ? $post->published_at->format('Y-m-d\TH:i') : '') }}"
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-blue-500 transition">
                        </div>

                        <!-- Post Stats -->
                        <div class="pt-3 border-t border-gray-100 space-y-2 text-sm text-gray-500">
                            <div class="flex justify-between">
                                <span>Views:</span>
                                <span class="font-semibold text-gray-700">{{ $post->view_count ?? 0 }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Created:</span>
                                <span class="font-semibold text-gray-700">{{ $post->created_at->format('M d, Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Slug:</span>
                                <span class="font-semibold text-gray-700 text-xs">{{ $post->slug }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Featured Image -->
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">
                        <i class="fas fa-image text-gray-400 mr-2"></i>Featured Image
                    </h3>

                    @if($post->featured_image)
                    <div class="mb-4 rounded-xl overflow-hidden">
                        <img src="{{ asset('storage/' . $post->featured_image) }}" alt="Current image" class="w-full h-40 object-cover">
                    </div>
                    @endif

                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-4 text-center hover:border-blue-400 transition">
                        <p class="text-sm text-gray-500 mb-2">{{ $post->featured_image ? 'Replace image' : 'Upload an image' }}</p>
                        <input type="file" name="featured_image" accept="image/*"
                               class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        <p class="text-xs text-gray-400 mt-2">JPG, PNG, WebP (max 2MB)</p>
                    </div>
                </div>

                <!-- Categories -->
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">
                        <i class="fas fa-tags text-gray-400 mr-2"></i>Categories
                    </h3>

                    @if($categories->count() > 0)
                    <div class="space-y-2 max-h-48 overflow-y-auto">
                        @foreach($categories as $category)
                        <label class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 cursor-pointer transition">
                            <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                                   {{ in_array($category->id, old('categories', $postCategoryIds)) ? 'checked' : '' }}
                                   class="w-4 h-4 rounded text-blue-500 focus:ring-blue-500">
                            <span class="text-sm text-gray-700">{{ $category->translate('en')->name ?? 'Unnamed' }}</span>
                        </label>
                        @endforeach
                    </div>
                    @else
                    <p class="text-sm text-gray-500">No blog categories created yet.</p>
                    @endif
                </div>

                <!-- Actions -->
                <div class="space-y-3">
                    <button type="submit" class="w-full py-4 rounded-xl text-white font-bold text-lg shadow-lg hover-lift transition" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
                        <i class="fas fa-save mr-2"></i>Update Post
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
