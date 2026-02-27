@extends('admin.layout')

@section('title', 'Settings')
@section('page-title', 'Site Settings')
@section('page-description', 'Manage delivery and announcement settings')

@section('content')
<div class="max-w-4xl animate-slide-in">
    <form action="{{ route('admin.settings.update') }}" method="POST" class="bg-white rounded-2xl shadow-lg p-4 sm:p-8">
        @csrf
        @method('PUT')

        <!-- Announcement Bar Settings -->
        <div class="mb-8">
            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                <i class="fas fa-bullhorn text-orange-500 mr-3"></i>
                Announcement Bar (Running Text)
            </h3>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Banner Text <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="delivery_banner_text" value="{{ old('delivery_banner_text', $settings['delivery_banner_text']) }}" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('delivery_banner_text') border-red-500 @enderror"
                        placeholder="e.g. Free Shipping on Orders Above PKR 5,000!">
                    @error('delivery_banner_text')
                        <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">This text will scroll across the top announcement bar on the website</p>
                </div>

                <!-- Preview -->
                <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl p-4 overflow-hidden">
                    <p class="text-white text-sm font-medium text-center">Preview: Your text will scroll like a marquee across the top bar</p>
                </div>
            </div>
        </div>

        <!-- Delivery Settings -->
        <div class="mb-8">
            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                <i class="fas fa-truck text-blue-500 mr-3"></i>
                Delivery Settings
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Delivery Charges (PKR)
                    </label>
                    <input type="text" name="delivery_charges" value="{{ old('delivery_charges', $settings['delivery_charges']) }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="e.g. 200">
                    <p class="text-xs text-gray-500 mt-1">Standard delivery charges</p>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Free Delivery Minimum (PKR)
                    </label>
                    <input type="text" name="free_delivery_minimum" value="{{ old('free_delivery_minimum', $settings['free_delivery_minimum']) }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="e.g. 5000">
                    <p class="text-xs text-gray-500 mt-1">Orders above this amount get free delivery</p>
                </div>
            </div>
        </div>

        <!-- WhatsApp Settings -->
        <div class="mb-8">
            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                <i class="fab fa-whatsapp text-green-500 mr-3"></i>
                WhatsApp Notifications
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Admin WhatsApp Number
                    </label>
                    <input type="text" name="whatsapp_number" value="{{ old('whatsapp_number', $settings['whatsapp_number']) }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                        placeholder="e.g. +923001234567">
                    <p class="text-xs text-gray-500 mt-1">This number receives order notifications and is shown on website for customer contact</p>
                </div>

                <div class="flex items-center">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" name="whatsapp_order_notify_admin" value="1" {{ old('whatsapp_order_notify_admin', $settings['whatsapp_order_notify_admin']) ? 'checked' : '' }}
                            class="w-5 h-5 text-green-600 border-gray-300 rounded focus:ring-2 focus:ring-green-500">
                        <span class="ml-3 text-sm font-semibold text-gray-700">
                            <i class="fas fa-bell text-green-500 mr-1"></i>Notify Admin on New Orders
                        </span>
                    </label>
                </div>

                <div class="flex items-center">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" name="whatsapp_order_notify_customer" value="1" {{ old('whatsapp_order_notify_customer', $settings['whatsapp_order_notify_customer']) ? 'checked' : '' }}
                            class="w-5 h-5 text-green-600 border-gray-300 rounded focus:ring-2 focus:ring-green-500">
                        <span class="ml-3 text-sm font-semibold text-gray-700">
                            <i class="fas fa-user text-green-500 mr-1"></i>Notify Customer on Order Updates
                        </span>
                    </label>
                </div>
            </div>

            <!-- WhatsApp Config Info -->
            <div class="mt-4 bg-green-50 border border-green-200 rounded-xl p-4">
                <h4 class="text-sm font-bold text-green-800 mb-2"><i class="fas fa-info-circle mr-1"></i> Configuration</h4>
                <p class="text-xs text-green-700 mb-2">WhatsApp API credentials are configured in the .env file. Contact your developer to set up the WhatsApp Business API.</p>
                <div class="text-xs text-green-600 font-mono bg-green-100 rounded p-2">
                    WHATSAPP_ADMIN_PHONE={{ env('WHATSAPP_ADMIN_PHONE', 'not set') }}
                </div>
            </div>
        </div>

        <!-- Public Login/Register Settings -->
        <div class="mb-8">
            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                <i class="fas fa-user-lock text-purple-500 mr-3"></i>
                Public Login / Registration
            </h3>

            <div class="flex items-center">
                <label class="flex items-center cursor-pointer">
                    <input type="checkbox" name="public_login_enabled" value="1" {{ old('public_login_enabled', $settings['public_login_enabled']) ? 'checked' : '' }}
                        class="w-5 h-5 text-purple-600 border-gray-300 rounded focus:ring-2 focus:ring-purple-500">
                    <span class="ml-3 text-sm font-semibold text-gray-700">
                        <i class="fas fa-sign-in-alt text-purple-500 mr-1"></i>Enable Public Login & Registration
                    </span>
                </label>
            </div>
            <p class="text-xs text-gray-500 mt-2">When disabled, the Login/Signup buttons will be hidden and /login, /register routes will show 404. Admin can still login via <strong>/admin/login</strong></p>
        </div>

        <!-- Submit -->
        <div>
            <button type="submit" class="px-6 sm:px-8 py-3 sm:py-4 rounded-xl text-white font-bold text-sm sm:text-lg shadow-lg hover-lift" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                <i class="fas fa-save mr-2"></i>Save Settings
            </button>
        </div>
    </form>
</div>
@endsection
