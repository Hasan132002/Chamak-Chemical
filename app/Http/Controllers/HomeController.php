<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Deal;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $featuredProducts = Product::where('is_active', true)
            ->where('is_featured', true)
            ->with(['translations', 'pricing', 'category'])
            ->take(8)
            ->get();

        $banners = Banner::active()->get();

        $deals = Deal::active()
            ->with('translations')
            ->orderBy('sort_order')
            ->get();

        // New arrivals - latest products
        $newArrivals = Product::where('is_active', true)
            ->with(['translations', 'pricing', 'category'])
            ->latest()
            ->take(6)
            ->get();

        return view('home', compact('categories', 'featuredProducts', 'banners', 'deals', 'newArrivals'));
    }
}
