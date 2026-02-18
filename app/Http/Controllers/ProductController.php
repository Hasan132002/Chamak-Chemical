<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('is_active', true)
            ->with(['translations', 'pricing', 'category']);

        // Filter by category
        if ($request->has('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('translations', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%");
            });
        }

        // Sort
        $sort = $request->get('sort', 'name');
        if ($sort === 'price_low') {
            $query->join('product_pricing', 'products.id', '=', 'product_pricing.product_id')
                  ->orderBy('product_pricing.retail_price', 'asc');
        } elseif ($sort === 'price_high') {
            $query->join('product_pricing', 'products.id', '=', 'product_pricing.product_id')
                  ->orderBy('product_pricing.retail_price', 'desc');
        }

        $products = $query->paginate(12);
        $categories = Category::where('is_active', true)->get();

        return view('products.index', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        $product->load(['translations', 'pricing', 'wholesalePricing', 'category']);

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->with(['translations', 'pricing'])
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }
}
