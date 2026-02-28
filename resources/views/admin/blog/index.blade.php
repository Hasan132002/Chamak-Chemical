@extends('admin.layout')

@section('title', 'Blog Management')
@section('page-title', 'Blog Posts')
@section('page-description', 'Manage your blog content')

@section('content')
<div class="animate-slide-in">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-4 sm:mb-6 gap-3">
        <div>
            <h2 class="text-xl sm:text-2xl font-bold text-gray-900 flex items-center">
                <i class="fas fa-blog text-green-500 mr-2 sm:mr-3"></i>
                All Blog Posts
                <span class="ml-2 sm:ml-3 text-xs sm:text-sm font-normal text-gray-500">({{ $posts->total() }} total)</span>
            </h2>
        </div>
        <a href="{{ route('admin.blog.create') }}" class="px-4 sm:px-6 py-2 sm:py-3 rounded-xl text-white font-semibold shadow-lg hover-lift text-sm sm:text-base text-center" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
            <i class="fas fa-plus mr-2"></i>New Post
        </a>
    </div>

    @if($posts->count() > 0)
    <!-- Blog Posts Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-6">
        @foreach($posts as $post)
        @php $translation = $post->translate('en'); @endphp
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover-lift">
            <div class="h-36 sm:h-48 bg-gradient-to-br from-green-100 to-blue-100 flex items-center justify-center relative">
                @if($post->featured_image)
                    <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $translation->title ?? '' }}" class="w-full h-full object-cover">
                @else
                    <i class="fas fa-image text-6xl text-gray-300"></i>
                @endif

                <!-- Status Badge -->
                <div class="absolute top-3 right-3">
                    @if($post->is_published)
                        <span class="px-3 py-1 bg-green-500 text-white rounded-full text-xs font-bold shadow">Published</span>
                    @else
                        <span class="px-3 py-1 bg-yellow-500 text-white rounded-full text-xs font-bold shadow">Draft</span>
                    @endif
                </div>
            </div>

            <div class="p-4 sm:p-6">
                <div class="flex items-center gap-2 mb-3">
                    <span class="text-xs text-gray-500">
                        <i class="fas fa-calendar mr-1"></i>
                        {{ $post->published_at ? $post->published_at->format('M d, Y') : 'Not published' }}
                    </span>
                    <span class="text-xs text-gray-500">
                        <i class="fas fa-user mr-1"></i>{{ $post->author->name ?? 'Admin' }}
                    </span>
                </div>

                <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2">{{ $translation->title ?? 'Untitled' }}</h3>
                <p class="text-sm text-gray-600 mb-4 line-clamp-2">{{ Str::limit(strip_tags($translation->content ?? ''), 100) }}</p>

                <!-- Categories -->
                @if($post->categories->count() > 0)
                <div class="flex flex-wrap gap-1 mb-4">
                    @foreach($post->categories->take(3) as $cat)
                        <span class="px-2 py-0.5 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold">
                            {{ $cat->translate('en')->name ?? 'Category' }}
                        </span>
                    @endforeach
                </div>
                @endif

                <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                    <span><i class="fas fa-eye mr-1"></i>{{ $post->view_count ?? 0 }} views</span>
                </div>

                <div class="flex gap-2 pt-4 border-t border-gray-100">
                    <a href="{{ route('admin.blog.edit', $post) }}" class="flex-1 px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-semibold rounded-lg transition text-center">
                        <i class="fas fa-edit mr-1"></i>Edit
                    </a>
                    <form action="{{ route('admin.blog.destroy', $post) }}" method="POST" class="flex-1" onsubmit="return confirm('Are you sure you want to delete this post?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-lg transition">
                            <i class="fas fa-trash mr-1"></i>Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $posts->links() }}
    </div>
    @else
    <!-- Empty State -->
    <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
        <div class="text-6xl mb-4"><i class="fas fa-blog text-gray-300"></i></div>
        <h3 class="text-2xl font-bold text-gray-700 mb-2">No Blog Posts Yet</h3>
        <p class="text-gray-500 mb-6">Create your first blog post to share content with your audience.</p>
        <a href="{{ route('admin.blog.create') }}" class="inline-block px-8 py-3 rounded-xl text-white font-semibold shadow-lg" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
            <i class="fas fa-plus mr-2"></i>Create First Post
        </a>
    </div>
    @endif
</div>
@endsection
