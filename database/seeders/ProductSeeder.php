<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductTranslation;
use App\Models\ProductPricing;
use App\Models\WholesalePricing;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::all();

        $products = [
            [
                'category' => 'Washing Powder',
                'name_en' => 'Chamak Ultra Washing Powder 500g',
                'name_ur' => 'چمک الٹرا واشنگ پاؤڈر 500 گرام',
                'description_en' => 'Premium quality washing powder for bright and clean clothes',
                'description_ur' => 'روشن اور صاف کپڑوں کے لیے اعلیٰ معیار کا پاؤڈر',
                'retail_price' => 250,
                'cost_price' => 150,
                'stock' => 500,
            ],
            [
                'category' => 'Washing Powder',
                'name_en' => 'Chamak Power Clean 1kg',
                'name_ur' => 'چمک پاور کلین 1 کلو',
                'description_en' => 'Extra strength formula for tough stains',
                'description_ur' => 'مشکل داغوں کے لیے اضافی طاقت کا فارمولا',
                'retail_price' => 450,
                'cost_price' => 280,
                'stock' => 300,
            ],
            [
                'category' => 'Dish Wash',
                'name_en' => 'Power Clean Dish Wash Liquid 500ml',
                'name_ur' => 'پاور کلین ڈش واش مائع 500 ملی لیٹر',
                'description_en' => 'Lemon fresh dish washing liquid',
                'description_ur' => 'لیموں کی تازگی والا برتن دھونے کا مائع',
                'retail_price' => 180,
                'cost_price' => 110,
                'stock' => 400,
            ],
            [
                'category' => 'Glass Cleaner',
                'name_en' => 'Crystal Clear Glass Cleaner 500ml',
                'name_ur' => 'کرسٹل کلیئر گلاس کلینر 500 ملی لیٹر',
                'description_en' => 'Streak-free shine for all glass surfaces',
                'description_ur' => 'تمام شیشوں کی سطحوں کے لیے چمک',
                'retail_price' => 200,
                'cost_price' => 120,
                'stock' => 250,
            ],
            [
                'category' => 'HCL / Harpic',
                'name_en' => 'Toilet Cleaner Acid 500ml',
                'name_ur' => 'ٹوائلٹ کلینر ایسڈ 500 ملی لیٹر',
                'description_en' => 'Powerful acid-based toilet cleaner',
                'description_ur' => 'طاقتور تیزاب پر مبنی ٹوائلٹ کلینر',
                'retail_price' => 150,
                'cost_price' => 90,
                'stock' => 350,
            ],
            [
                'category' => 'Hospital Chemicals',
                'name_en' => 'Medical Grade Disinfectant 1L',
                'name_ur' => 'طبی درجہ کا جراثیم کش 1 لیٹر',
                'description_en' => 'Hospital-grade surface disinfectant',
                'description_ur' => 'ہسپتال کے معیار کا سطح جراثیم کش',
                'retail_price' => 500,
                'cost_price' => 320,
                'stock' => 200,
            ],
        ];

        foreach ($products as $productData) {
            $category = $categories->firstWhere('slug', Str::slug($productData['category']));

            if (!$category) continue;

            $product = Product::create([
                'sku' => 'CHM-' . strtoupper(Str::random(6)),
                'slug' => Str::slug($productData['name_en']),
                'category_id' => $category->id,
                'brand' => 'Chamak',
                'featured_image' => null,
                'gallery_images' => null,
                'weight' => null,
                'dimensions' => null,
                'is_active' => true,
                'is_featured' => rand(0, 1) == 1,
                'stock_quantity' => $productData['stock'],
                'low_stock_threshold' => 50,
                'allow_backorder' => false,
            ]);

            // English translation
            ProductTranslation::create([
                'product_id' => $product->id,
                'locale' => 'en',
                'name' => $productData['name_en'],
                'short_description' => $productData['description_en'],
                'long_description' => $productData['description_en'] . '. Perfect for daily use.',
                'meta_title' => $productData['name_en'],
                'meta_description' => $productData['description_en'],
            ]);

            // Urdu translation
            ProductTranslation::create([
                'product_id' => $product->id,
                'locale' => 'ur',
                'name' => $productData['name_ur'],
                'short_description' => $productData['description_ur'],
                'long_description' => $productData['description_ur'] . '۔ روزمرہ استعمال کے لیے بہترین',
                'meta_title' => $productData['name_ur'],
                'meta_description' => $productData['description_ur'],
            ]);

            // Pricing
            ProductPricing::create([
                'product_id' => $product->id,
                'retail_price' => $productData['retail_price'],
                'sale_price' => null,
                'cost_price' => $productData['cost_price'],
            ]);

            // Wholesale pricing tiers
            $wholesaleTiers = [
                ['tier' => 'bronze', 'min_qty' => 50, 'discount' => 0.10],
                ['tier' => 'silver', 'min_qty' => 100, 'discount' => 0.15],
                ['tier' => 'gold', 'min_qty' => 200, 'discount' => 0.20],
                ['tier' => 'platinum', 'min_qty' => 500, 'discount' => 0.25],
            ];

            foreach ($wholesaleTiers as $tier) {
                WholesalePricing::create([
                    'product_id' => $product->id,
                    'dealer_tier' => $tier['tier'],
                    'min_quantity' => $tier['min_qty'],
                    'unit_price' => $productData['retail_price'] * (1 - $tier['discount']),
                ]);
            }
        }
    }
}
