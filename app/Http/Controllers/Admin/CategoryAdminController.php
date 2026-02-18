<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CategoryTranslation;
use Illuminate\Http\Request;

class CategoryAdminController extends Controller
{
    public function index()
    {
        $categories = Category::with('translations', 'products')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'slug' => 'required|unique:categories',
            'name_en' => 'required|string',
            'name_ur' => 'required|string',
            'description_en' => 'nullable|string',
            'description_ur' => 'nullable|string',
            'sort_order' => 'nullable|integer',
        ]);

        $category = Category::create([
            'slug' => $validated['slug'],
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->boolean('is_active', true),
        ]);

        // English Translation
        CategoryTranslation::create([
            'category_id' => $category->id,
            'locale' => 'en',
            'name' => $validated['name_en'],
            'description' => $validated['description_en'] ?? '',
        ]);

        // Urdu Translation
        CategoryTranslation::create([
            'category_id' => $category->id,
            'locale' => 'ur',
            'name' => $validated['name_ur'],
            'description' => $validated['description_ur'] ?? '',
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully!');
    }

    public function edit(Category $category)
    {
        $category->load('translations');
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name_en' => 'required|string',
            'name_ur' => 'required|string',
            'description_en' => 'nullable|string',
            'description_ur' => 'nullable|string',
            'sort_order' => 'nullable|integer',
        ]);

        $category->update([
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->boolean('is_active', true),
        ]);

        // Update translations
        $category->translations()->where('locale', 'en')->update([
            'name' => $validated['name_en'],
            'description' => $validated['description_en'] ?? '',
        ]);

        $category->translations()->where('locale', 'ur')->update([
            'name' => $validated['name_ur'],
            'description' => $validated['description_ur'] ?? '',
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully!');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category deleted successfully!');
    }
}
