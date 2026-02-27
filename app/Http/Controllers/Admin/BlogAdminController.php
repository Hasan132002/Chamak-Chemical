<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\BlogPostTranslation;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogAdminController extends Controller
{
    public function index()
    {
        $posts = BlogPost::with(['translations', 'author', 'categories'])
            ->latest()
            ->paginate(20);

        return view('admin.blog.index', compact('posts'));
    }

    public function create()
    {
        $categories = BlogCategory::with('translations')->get();
        return view('admin.blog.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_en' => 'required|string|max:255',
            'title_ur' => 'required|string|max:255',
            'content_en' => 'required|string',
            'content_ur' => 'required|string',
            'excerpt_en' => 'nullable|string|max:500',
            'excerpt_ur' => 'nullable|string|max:500',
            'featured_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_published' => 'nullable',
            'published_at' => 'nullable|date',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:blog_categories,id',
        ]);

        $featuredImage = null;
        if ($request->hasFile('featured_image')) {
            $featuredImage = $request->file('featured_image')->store('blog', 'public');
        }

        $post = BlogPost::create([
            'slug' => Str::slug($validated['title_en']),
            'author_id' => auth()->id(),
            'featured_image' => $featuredImage,
            'is_published' => $request->boolean('is_published'),
            'published_at' => $request->boolean('is_published') ? ($validated['published_at'] ?? now()) : null,
        ]);

        BlogPostTranslation::create([
            'blog_post_id' => $post->id,
            'locale' => 'en',
            'title' => $validated['title_en'],
            'excerpt' => $validated['excerpt_en'] ?? null,
            'content' => $validated['content_en'],
        ]);

        BlogPostTranslation::create([
            'blog_post_id' => $post->id,
            'locale' => 'ur',
            'title' => $validated['title_ur'],
            'excerpt' => $validated['excerpt_ur'] ?? null,
            'content' => $validated['content_ur'],
        ]);

        if (!empty($validated['categories'])) {
            $post->categories()->sync($validated['categories']);
        }

        return redirect()->route('admin.blog.index')
            ->with('success', 'Blog post created successfully!');
    }

    public function edit(BlogPost $post)
    {
        $post->load(['translations', 'categories']);
        $categories = BlogCategory::with('translations')->get();

        return view('admin.blog.edit', compact('post', 'categories'));
    }

    public function update(Request $request, BlogPost $post)
    {
        $validated = $request->validate([
            'title_en' => 'required|string|max:255',
            'title_ur' => 'required|string|max:255',
            'content_en' => 'required|string',
            'content_ur' => 'required|string',
            'excerpt_en' => 'nullable|string|max:500',
            'excerpt_ur' => 'nullable|string|max:500',
            'featured_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_published' => 'nullable',
            'published_at' => 'nullable|date',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:blog_categories,id',
        ]);

        if ($request->hasFile('featured_image')) {
            if ($post->featured_image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($post->featured_image);
            }
            $post->featured_image = $request->file('featured_image')->store('blog', 'public');
        }

        $wasPublished = $post->is_published;
        $post->is_published = $request->boolean('is_published');

        if ($post->is_published && !$wasPublished) {
            $post->published_at = $validated['published_at'] ?? now();
        } elseif ($post->is_published && $wasPublished && !empty($validated['published_at'])) {
            $post->published_at = $validated['published_at'];
        } elseif (!$post->is_published) {
            $post->published_at = null;
        }

        $post->slug = Str::slug($validated['title_en']);
        $post->save();

        $post->translations()->where('locale', 'en')->update([
            'title' => $validated['title_en'],
            'excerpt' => $validated['excerpt_en'] ?? null,
            'content' => $validated['content_en'],
        ]);

        $post->translations()->where('locale', 'ur')->update([
            'title' => $validated['title_ur'],
            'excerpt' => $validated['excerpt_ur'] ?? null,
            'content' => $validated['content_ur'],
        ]);

        $post->categories()->sync($validated['categories'] ?? []);

        return redirect()->route('admin.blog.index')
            ->with('success', 'Blog post updated successfully!');
    }

    public function destroy(BlogPost $post)
    {
        if ($post->featured_image) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($post->featured_image);
        }

        $post->delete();

        return redirect()->route('admin.blog.index')
            ->with('success', 'Blog post deleted successfully!');
    }
}
