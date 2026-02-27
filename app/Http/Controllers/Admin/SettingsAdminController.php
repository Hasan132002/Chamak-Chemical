<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsAdminController extends Controller
{
    public function edit()
    {
        $settings = [
            'delivery_banner_text' => SiteSetting::get('delivery_banner_text', 'Special Offer: Free Shipping on Orders Above PKR 5,000!'),
            'delivery_charges' => SiteSetting::get('delivery_charges', '200'),
            'free_delivery_minimum' => SiteSetting::get('free_delivery_minimum', '5000'),
            'whatsapp_number' => SiteSetting::get('whatsapp_number', '+923001234567'),
            'whatsapp_order_notify_admin' => SiteSetting::get('whatsapp_order_notify_admin', true),
            'whatsapp_order_notify_customer' => SiteSetting::get('whatsapp_order_notify_customer', true),
            'public_login_enabled' => SiteSetting::get('public_login_enabled', false),
            'site_phone' => SiteSetting::get('site_phone', '+92-300-1234567'),
            'site_email' => SiteSetting::get('site_email', 'info@chamakchemical.com'),
            'site_address' => SiteSetting::get('site_address', 'Karachi, Pakistan'),
            'site_logo' => SiteSetting::get('site_logo', null),
            'facebook_url' => SiteSetting::get('facebook_url', ''),
            'instagram_url' => SiteSetting::get('instagram_url', ''),
            'twitter_url' => SiteSetting::get('twitter_url', ''),
            // Menu & Footer Page Visibility
            'menu_show_home' => SiteSetting::get('menu_show_home', true),
            'menu_show_products' => SiteSetting::get('menu_show_products', true),
            'menu_show_categories' => SiteSetting::get('menu_show_categories', true),
            'menu_show_deals' => SiteSetting::get('menu_show_deals', true),
            'menu_show_wholesale' => SiteSetting::get('menu_show_wholesale', true),
            'menu_show_blog' => SiteSetting::get('menu_show_blog', true),
            'menu_show_contact' => SiteSetting::get('menu_show_contact', true),
            'footer_show_products' => SiteSetting::get('footer_show_products', true),
            'footer_show_categories' => SiteSetting::get('footer_show_categories', true),
            'footer_show_deals' => SiteSetting::get('footer_show_deals', true),
            'footer_show_wholesale' => SiteSetting::get('footer_show_wholesale', true),
            'footer_show_blog' => SiteSetting::get('footer_show_blog', true),
            'footer_show_about' => SiteSetting::get('footer_show_about', true),
            'footer_show_contact' => SiteSetting::get('footer_show_contact', true),
        ];

        return view('admin.settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'delivery_banner_text' => 'required|string|max:500',
            'delivery_charges' => 'nullable|string|max:50',
            'free_delivery_minimum' => 'nullable|string|max:50',
            'whatsapp_number' => 'nullable|string|max:20',
            'whatsapp_order_notify_admin' => 'nullable',
            'whatsapp_order_notify_customer' => 'nullable',
            'public_login_enabled' => 'nullable',
            'site_phone' => 'nullable|string|max:20',
            'site_email' => 'nullable|email|max:255',
            'site_address' => 'nullable|string|max:500',
            'site_logo' => 'nullable|image|mimes:jpg,jpeg,png,svg,webp|max:2048',
            'facebook_url' => 'nullable|string|max:500',
            'instagram_url' => 'nullable|string|max:500',
            'twitter_url' => 'nullable|string|max:500',
        ]);

        SiteSetting::set('delivery_banner_text', $validated['delivery_banner_text'], 'delivery');
        SiteSetting::set('delivery_charges', $validated['delivery_charges'] ?? '200', 'delivery');
        SiteSetting::set('free_delivery_minimum', $validated['free_delivery_minimum'] ?? '5000', 'delivery');
        SiteSetting::set('whatsapp_number', $validated['whatsapp_number'] ?? '+923001234567', 'whatsapp');
        SiteSetting::set('whatsapp_order_notify_admin', $request->has('whatsapp_order_notify_admin'), 'whatsapp');
        SiteSetting::set('whatsapp_order_notify_customer', $request->has('whatsapp_order_notify_customer'), 'whatsapp');
        SiteSetting::set('public_login_enabled', $request->has('public_login_enabled'), 'auth');
        SiteSetting::set('site_phone', $validated['site_phone'] ?? '+92-300-1234567', 'site');
        SiteSetting::set('site_email', $validated['site_email'] ?? 'info@chamakchemical.com', 'site');
        SiteSetting::set('site_address', $validated['site_address'] ?? 'Karachi, Pakistan', 'site');
        SiteSetting::set('facebook_url', $validated['facebook_url'] ?? '', 'social');
        SiteSetting::set('instagram_url', $validated['instagram_url'] ?? '', 'social');
        SiteSetting::set('twitter_url', $validated['twitter_url'] ?? '', 'social');

        // Menu & Footer Page Visibility
        SiteSetting::set('menu_show_home', $request->has('menu_show_home'), 'menu');
        SiteSetting::set('menu_show_products', $request->has('menu_show_products'), 'menu');
        SiteSetting::set('menu_show_categories', $request->has('menu_show_categories'), 'menu');
        SiteSetting::set('menu_show_deals', $request->has('menu_show_deals'), 'menu');
        SiteSetting::set('menu_show_wholesale', $request->has('menu_show_wholesale'), 'menu');
        SiteSetting::set('menu_show_blog', $request->has('menu_show_blog'), 'menu');
        SiteSetting::set('menu_show_contact', $request->has('menu_show_contact'), 'menu');
        SiteSetting::set('footer_show_products', $request->has('footer_show_products'), 'footer');
        SiteSetting::set('footer_show_categories', $request->has('footer_show_categories'), 'footer');
        SiteSetting::set('footer_show_deals', $request->has('footer_show_deals'), 'footer');
        SiteSetting::set('footer_show_wholesale', $request->has('footer_show_wholesale'), 'footer');
        SiteSetting::set('footer_show_blog', $request->has('footer_show_blog'), 'footer');
        SiteSetting::set('footer_show_about', $request->has('footer_show_about'), 'footer');
        SiteSetting::set('footer_show_contact', $request->has('footer_show_contact'), 'footer');

        // Handle logo upload
        if ($request->hasFile('site_logo')) {
            $oldLogo = SiteSetting::get('site_logo');
            if ($oldLogo) {
                Storage::disk('public')->delete($oldLogo);
            }
            $path = $request->file('site_logo')->store('site', 'public');
            SiteSetting::set('site_logo', $path, 'site');
        }

        return redirect()->route('admin.settings.edit')
            ->with('success', 'Settings updated successfully!');
    }
}
