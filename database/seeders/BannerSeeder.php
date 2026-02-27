<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    public function run(): void
    {
        $banners = [
            [
                'title' => 'Premium Chemical Products',
                'subtitle' => 'Quality cleaning solutions for home & industry',
                'button_text' => 'Shop Now',
                'button_url' => '/products',
                'sort_order' => 1,
            ],
            [
                'title' => 'Wholesale Pricing Available',
                'subtitle' => 'Register as a dealer and save up to 40%',
                'button_text' => 'Become a Dealer',
                'button_url' => '/wholesale/register',
                'sort_order' => 2,
            ],
            [
                'title' => 'Free Delivery on PKR 5,000+',
                'subtitle' => 'Fast and reliable shipping across Pakistan',
                'button_text' => 'Browse Products',
                'button_url' => '/products',
                'sort_order' => 3,
            ],
        ];

        foreach ($banners as $index => $data) {
            Banner::create([
                'image' => 'banners/placeholder-banner-' . ($index + 1) . '.jpg',
                'title' => $data['title'],
                'subtitle' => $data['subtitle'],
                'button_text' => $data['button_text'],
                'button_url' => $data['button_url'],
                'is_active' => true,
                'sort_order' => $data['sort_order'],
            ]);
        }
    }
}
