@extends('admin.layout')

@section('title', 'Settings')
@section('page-title', 'Site Settings')
@section('page-description', 'Manage site information, delivery, and other settings')

@section('content')
<div class="max-w-4xl animate-slide-in">
    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl shadow-lg p-4 sm:p-8">
        @csrf
        @method('PUT')

        <!-- Site Information -->
        <div class="mb-8">
            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                <i class="fas fa-building text-blue-500 mr-3"></i>
                Site Information
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-phone text-blue-500 mr-1"></i> Phone Number
                    </label>
                    <input type="text" name="site_phone" value="{{ old('site_phone', $settings['site_phone']) }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="e.g. +92-300-1234567">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-envelope text-blue-500 mr-1"></i> Email Address
                    </label>
                    <input type="email" name="site_email" value="{{ old('site_email', $settings['site_email']) }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="e.g. info@chamakchemical.com">
                    @error('site_email')
                        <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-map-marker-alt text-blue-500 mr-1"></i> Address
                    </label>
                    <input type="text" name="site_address" value="{{ old('site_address', $settings['site_address']) }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="e.g. Karachi, Pakistan">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-image text-blue-500 mr-1"></i> Site Logo
                    </label>
                    @if($settings['site_logo'])
                        <div class="mb-3 flex items-center gap-4">
                            <img src="{{ asset('storage/' . $settings['site_logo']) }}" alt="Current Logo" class="h-16 object-contain bg-gray-100 rounded-lg p-2">
                            <span class="text-sm text-gray-500">Current logo</span>
                        </div>
                    @endif
                    <input type="file" name="site_logo" accept="image/*"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('site_logo')
                        <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">Upload a logo (JPG, PNG, SVG, WebP - max 2MB). Leave empty to keep current.</p>
                </div>
            </div>
        </div>

        <!-- Social Media Links -->
        <div class="mb-8">
            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                <i class="fas fa-share-alt text-pink-500 mr-3"></i>
                Social Media Links
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fab fa-facebook text-blue-600 mr-1"></i> Facebook URL
                    </label>
                    <input type="text" name="facebook_url" value="{{ old('facebook_url', $settings['facebook_url']) }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="https://facebook.com/...">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fab fa-instagram text-pink-500 mr-1"></i> Instagram URL
                    </label>
                    <input type="text" name="instagram_url" value="{{ old('instagram_url', $settings['instagram_url']) }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="https://instagram.com/...">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fab fa-twitter text-blue-400 mr-1"></i> Twitter URL
                    </label>
                    <input type="text" name="twitter_url" value="{{ old('twitter_url', $settings['twitter_url']) }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="https://twitter.com/...">
                </div>
            </div>
        </div>

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
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Free Delivery Minimum (PKR)
                    </label>
                    <input type="text" name="free_delivery_minimum" value="{{ old('free_delivery_minimum', $settings['free_delivery_minimum']) }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="e.g. 5000">
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
