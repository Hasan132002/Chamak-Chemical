<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\CategoryTranslation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name_en' => 'Washing Powder',
                'name_ur' => 'واشنگ پاؤڈر',
                'description_en' => 'High-quality washing powders for laundry',
                'description_ur' => 'کپڑے دھونے کے لیے اعلیٰ معیار کا پاؤڈر',
            ],
            [
                'name_en' => 'Dish Wash',
                'name_ur' => 'ڈش واش',
                'description_en' => 'Effective dish washing liquids and bars',
                'description_ur' => 'برتن دھونے کے مؤثر مائع اور بار',
            ],
            [
                'name_en' => 'Glass Cleaner',
                'name_ur' => 'گلاس کلینر',
                'description_en' => 'Professional glass and window cleaners',
                'description_ur' => 'شیشے اور کھڑکی صاف کرنے والا',
            ],
            [
                'name_en' => 'HCL / Harpic',
                'name_ur' => 'ایچ سی ایل / ہارپک',
                'description_en' => 'Toilet cleaners and acid-based cleaners',
                'description_ur' => 'بیت الخلاء کی صفائی کے لیے',
            ],
            [
                'name_en' => 'Hospital Chemicals',
                'name_ur' => 'ہسپتال کیمیکلز',
                'description_en' => 'Medical-grade disinfectants and sanitizers',
                'description_ur' => 'طبی درجہ کے جراثیم کش',
            ],
            [
                'name_en' => 'Bulk Chemicals',
                'name_ur' => 'بلک کیمیکلز',
                'description_en' => 'Industrial chemicals in bulk quantities',
                'description_ur' => 'بڑی مقدار میں صنعتی کیمیکلز',
            ],
        ];

        foreach ($categories as $index => $data) {
            $category = Category::create([
                'slug' => Str::slug($data['name_en']),
                'parent_id' => null,
                'image' => null,
                'sort_order' => $index + 1,
                'is_active' => true,
            ]);

            // English translation
            CategoryTranslation::create([
                'category_id' => $category->id,
                'locale' => 'en',
                'name' => $data['name_en'],
                'description' => $data['description_en'],
                'meta_title' => $data['name_en'] . ' - Chamak Chemicals',
                'meta_description' => $data['description_en'],
            ]);

            // Urdu translation
            CategoryTranslation::create([
                'category_id' => $category->id,
                'locale' => 'ur',
                'name' => $data['name_ur'],
                'description' => $data['description_ur'],
                'meta_title' => $data['name_ur'] . ' - چمک کیمیکلز',
                'meta_description' => $data['description_ur'],
            ]);
        }
    }
}
