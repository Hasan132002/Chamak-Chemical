<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // General Settings
            [
                'key' => 'site_name',
                'value' => ['en' => 'Chamak Chemicals', 'ur' => 'چمک کیمیکلز'],
                'group' => 'general',
            ],
            [
                'key' => 'contact_phone',
                'value' => '+92-300-1234567',
                'group' => 'general',
            ],
            [
                'key' => 'contact_email',
                'value' => 'info@chamakchemical.com',
                'group' => 'general',
            ],

            // Order Settings
            [
                'key' => 'require_login_for_checkout',
                'value' => false, // false = guest checkout allowed, true = login required
                'group' => 'orders',
            ],
            [
                'key' => 'min_order_amount',
                'value' => 500,
                'group' => 'orders',
            ],
            [
                'key' => 'shipping_cost',
                'value' => 200,
                'group' => 'orders',
            ],
            [
                'key' => 'free_shipping_threshold',
                'value' => 5000,
                'group' => 'orders',
            ],

            // WhatsApp Settings
            [
                'key' => 'whatsapp_enabled',
                'value' => true,
                'group' => 'whatsapp',
            ],
            [
                'key' => 'whatsapp_number',
                'value' => '+923001234567',
                'group' => 'whatsapp',
            ],

            // Payment Settings
            [
                'key' => 'cod_enabled',
                'value' => true,
                'group' => 'payment',
            ],
            [
                'key' => 'bank_transfer_enabled',
                'value' => true,
                'group' => 'payment',
            ],
        ];

        foreach ($settings as $setting) {
            SiteSetting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
