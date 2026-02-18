<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::where('is_active', true)
            ->with('translations')
            ->orderBy('sort_order')
            ->get();

        return view('categories.index', compact('categories'));
    }

    public function show(Category $category)
    {
        $products = Product::where('category_id', $category->id)
            ->where('is_active', true)
            ->with(['translations', 'pricing'])
            ->paginate(12);

        return view('categories.show', compact('category', 'products'));
    }
}
