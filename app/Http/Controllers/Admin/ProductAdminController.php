<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductTranslation;
use App\Models\ProductPricing;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductAdminController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'translations', 'pricing'])
            ->latest()
            ->paginate(20);

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sku' => 'required|unique:products',
            'category_id' => 'required|exists:categories,id',
            'stock_quantity' => 'required|integer|min:0',
            'name_en' => 'required|string',
            'name_ur' => 'required|string',
            'short_description_en' => 'required|string',
            'short_description_ur' => 'required|string',
            'description_en' => 'required|string',
            'description_ur' => 'required|string',
            'retail_price' => 'required|numeric|min:0',
            'wholesale_price' => 'required|numeric|min:0',
            'moq' => 'required|integer|min:1',
            'images.*' => 'nullable|image|max:2048',
        ]);

        // Handle Image Uploads
        $featuredImage = null;
        $galleryImages = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products', 'public');

                if ($index === 0) {
                    $featuredImage = $path; // First image is featured
                } else {
                    $galleryImages[] = $path;
                }
            }
        }

        $product = Product::create([
            'sku' => $validated['sku'],
            'slug' => Str::slug($validated['name_en']),
            'category_id' => $validated['category_id'],
            'stock_quantity' => $validated['stock_quantity'],
            'is_active' => true,
            'is_featured' => $request->boolean('is_featured'),
            'moq' => $validated['moq'],
            'featured_image' => $featuredImage,
            'gallery_images' => $galleryImages,
        ]);

        // Translations
        ProductTranslation::create([
            'product_id' => $product->id,
            'locale' => 'en',
            'name' => $validated['name_en'],
            'short_description' => $validated['short_description_en'],
            'long_description' => $validated['description_en'],
        ]);

        ProductTranslation::create([
            'product_id' => $product->id,
            'locale' => 'ur',
            'name' => $validated['name_ur'],
            'short_description' => $validated['short_description_ur'],
            'long_description' => $validated['description_ur'],
        ]);

        // Pricing
        ProductPricing::create([
            'product_id' => $product->id,
            'retail_price' => $validated['retail_price'],
            'wholesale_price' => $validated['wholesale_price'],
        ]);

        // Handle Variations (if provided)
        if ($request->has('variations')) {
            foreach ($request->variations as $index => $variation) {
                if (!empty($variation['size'])) {
                    \App\Models\ProductVariation::create([
                        'product_id' => $product->id,
                        'size' => $variation['size'],
                        'retail_price' => $variation['retail_price'] ?? $validated['retail_price'],
                        'wholesale_price' => $variation['wholesale_price'] ?? $validated['wholesale_price'],
                        'stock_quantity' => $variation['stock'] ?? 0,
                        'is_active' => true,
                        'sort_order' => $index,
                    ]);
                }
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully!');
    }

    public function edit(Product $product)
    {
        $categories = Category::where('is_active', true)->get();
        $product->load(['translations', 'pricing', 'variations']);

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'stock_quantity' => 'required|integer|min:0',
            'name_en' => 'required|string',
            'name_ur' => 'required|string',
            'short_description_en' => 'required|string',
            'short_description_ur' => 'required|string',
            'description_en' => 'required|string',
            'description_ur' => 'required|string',
            'retail_price' => 'required|numeric|min:0',
            'wholesale_price' => 'required|numeric|min:0',
            'moq' => 'required|integer|min:1',
            'images.*' => 'nullable|image|max:2048',
        ]);

        // Handle new image uploads
        if ($request->hasFile('images')) {
            $galleryImages = $product->gallery_images ?? [];

            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products', 'public');

                if ($index === 0 && !$product->featured_image) {
                    // Set first image as featured if no featured image exists
                    $product->update(['featured_image' => $path]);
                } else {
                    $galleryImages[] = $path;
                }
            }

            $product->update(['gallery_images' => $galleryImages]);
        }

        $product->update([
            'category_id' => $validated['category_id'],
            'stock_quantity' => $validated['stock_quantity'],
            'is_featured' => $request->boolean('is_featured'),
            'moq' => $validated['moq'],
        ]);

        // Update translations
        $product->translations()->where('locale', 'en')->update([
            'name' => $validated['name_en'],
            'short_description' => $validated['short_description_en'],
            'long_description' => $validated['description_en'],
        ]);

        $product->translations()->where('locale', 'ur')->update([
            'name' => $validated['name_ur'],
            'short_description' => $validated['short_description_ur'],
            'long_description' => $validated['description_ur'],
        ]);

        // Update pricing
        $product->pricing()->update([
            'retail_price' => $validated['retail_price'],
            'wholesale_price' => $validated['wholesale_price'],
        ]);

        // Handle existing variation updates
        if ($request->has('existing_variations')) {
            foreach ($request->existing_variations as $varId => $varData) {
                \App\Models\ProductVariation::where('id', $varId)->update([
                    'size' => $varData['size'],
                    'retail_price' => $varData['retail_price'],
                    'wholesale_price' => $varData['wholesale_price'],
                    'stock_quantity' => $varData['stock'] ?? 0,
                ]);
            }
        }

        // Handle variation deletions
        if ($request->has('delete_variations')) {
            foreach ($request->delete_variations as $varId) {
                if (!empty($varId)) {
                    \App\Models\ProductVariation::where('id', $varId)->delete();
                }
            }
        }

        // Handle new variations
        if ($request->has('new_variations')) {
            foreach ($request->new_variations as $index => $variation) {
                if (!empty($variation['size'])) {
                    \App\Models\ProductVariation::create([
                        'product_id' => $product->id,
                        'size' => $variation['size'],
                        'retail_price' => $variation['retail_price'] ?? $validated['retail_price'],
                        'wholesale_price' => $variation['wholesale_price'] ?? $validated['wholesale_price'],
                        'stock_quantity' => $variation['stock'] ?? 0,
                        'is_active' => true,
                        'sort_order' => $index,
                    ]);
                }
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully!');
    }

    public function toggleStatus(Product $product)
    {
        $product->update([
            'is_active' => !$product->is_active
        ]);

        $status = $product->is_active ? 'activated' : 'deactivated';
        return back()->with('success', "Product {$status} successfully!");
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully!');
    }
}
