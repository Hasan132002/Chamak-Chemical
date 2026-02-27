<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

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
        ]);

        SiteSetting::set('delivery_banner_text', $validated['delivery_banner_text'], 'delivery');
        SiteSetting::set('delivery_charges', $validated['delivery_charges'] ?? '200', 'delivery');
        SiteSetting::set('free_delivery_minimum', $validated['free_delivery_minimum'] ?? '5000', 'delivery');
        SiteSetting::set('whatsapp_number', $validated['whatsapp_number'] ?? '+923001234567', 'whatsapp');
        SiteSetting::set('whatsapp_order_notify_admin', $request->has('whatsapp_order_notify_admin'), 'whatsapp');
        SiteSetting::set('whatsapp_order_notify_customer', $request->has('whatsapp_order_notify_customer'), 'whatsapp');
        SiteSetting::set('public_login_enabled', $request->has('public_login_enabled'), 'auth');

        return redirect()->route('admin.settings.edit')
            ->with('success', 'Settings updated successfully!');
    }
}
