<?php

namespace Database\Seeders;

use App\Models\Deal;
use App\Models\DealTranslation;
use Illuminate\Database\Seeder;

class DealSeeder extends Seeder
{
    public function run(): void
    {
        $deals = [
            [
                'discount_percentage' => 20,
                'url' => '/products?sort=price_low',
                'sort_order' => 1,
                'starts_at' => now(),
                'ends_at' => now()->addDays(30),
                'title_en' => 'Summer Sale - 20% Off',
                'title_ur' => 'گرمیوں کی سیل - 20% چھوٹ',
                'description_en' => 'Get 20% off on all cleaning products this summer! Limited time offer.',
                'description_ur' => 'اس گرمیوں میں تمام صفائی کی مصنوعات پر 20% چھوٹ حاصل کریں!',
            ],
            [
                'discount_percentage' => 15,
                'url' => '/categories/washing-powder',
                'sort_order' => 2,
                'starts_at' => now(),
                'ends_at' => now()->addDays(15),
                'title_en' => 'Washing Powder Bundle Deal',
                'title_ur' => 'واشنگ پاؤڈر بنڈل ڈیل',
                'description_en' => 'Buy 3 washing powder packs and get 15% off on your total order.',
                'description_ur' => 'تین واشنگ پاؤڈر پیک خریدیں اور کل آرڈر پر 15% چھوٹ پائیں۔',
            ],
            [
                'discount_percentage' => 30,
                'url' => '/products',
                'sort_order' => 3,
                'starts_at' => now(),
                'ends_at' => now()->addDays(7),
                'title_en' => 'Flash Sale - 30% Off Dish Wash',
                'title_ur' => 'فلیش سیل - ڈش واش پر 30% چھوٹ',
                'description_en' => 'Hurry! Flash sale on all dish wash products. Ends in 7 days!',
                'description_ur' => 'جلدی کریں! ڈش واش کی تمام مصنوعات پر فلیش سیل۔',
            ],
            [
                'discount_percentage' => 10,
                'url' => '/wholesale',
                'sort_order' => 4,
                'starts_at' => now(),
                'ends_at' => now()->addDays(60),
                'title_en' => 'Wholesale Special - Extra 10% Off',
                'title_ur' => 'ہول سیل اسپیشل - اضافی 10% چھوٹ',
                'description_en' => 'Register as a dealer and get an extra 10% off on bulk orders.',
                'description_ur' => 'ڈیلر کے طور پر رجسٹر کریں اور بلک آرڈرز پر اضافی 10% چھوٹ حاصل کریں۔',
            ],
        ];

        foreach ($deals as $data) {
            $deal = Deal::create([
                'image' => null,
                'url' => $data['url'],
                'is_active' => true,
                'sort_order' => $data['sort_order'],
                'starts_at' => $data['starts_at'],
                'ends_at' => $data['ends_at'],
                'discount_percentage' => $data['discount_percentage'],
            ]);

            DealTranslation::create([
                'deal_id' => $deal->id,
                'locale' => 'en',
                'title' => $data['title_en'],
                'description' => $data['description_en'],
            ]);

            DealTranslation::create([
                'deal_id' => $deal->id,
                'locale' => 'ur',
                'title' => $data['title_ur'],
                'description' => $data['description_ur'],
            ]);
        }
    }
}
