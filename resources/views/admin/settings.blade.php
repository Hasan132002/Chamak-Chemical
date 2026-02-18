@extends('admin.layout')

@section('title', 'Settings')
@section('page-title', 'System Settings')
@section('page-description', 'Configure your system settings')

@section('content')
<div class="max-w-4xl animate-slide-in">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- General Settings -->
        <div class="bg-white rounded-2xl shadow-lg p-6 hover-lift">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
                        <i class="fas fa-cog text-2xl text-white"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">General Settings</h3>
                        <p class="text-sm text-gray-600">Site configuration</p>
                    </div>
                </div>
            </div>
            <button class="w-full px-4 py-3 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-lg transition mt-4">
                <i class="fas fa-edit mr-2"></i>Configure
            </button>
        </div>

        <!-- Payment Settings -->
        <div class="bg-white rounded-2xl shadow-lg p-6 hover-lift">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                        <i class="fas fa-credit-card text-2xl text-white"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Payment Settings</h3>
                        <p class="text-sm text-gray-600">Payment gateways</p>
                    </div>
                </div>
            </div>
            <button class="w-full px-4 py-3 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-lg transition mt-4">
                <i class="fas fa-edit mr-2"></i>Configure
            </button>
        </div>

        <!-- Shipping Settings -->
        <div class="bg-white rounded-2xl shadow-lg p-6 hover-lift">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);">
                        <i class="fas fa-truck text-2xl text-white"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Shipping Settings</h3>
                        <p class="text-sm text-gray-600">Delivery configuration</p>
                    </div>
                </div>
            </div>
            <button class="w-full px-4 py-3 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-lg transition mt-4">
                <i class="fas fa-edit mr-2"></i>Configure
            </button>
        </div>

        <!-- Email Settings -->
        <div class="bg-white rounded-2xl shadow-lg p-6 hover-lift">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, #a855f7 0%, #9333ea 100%);">
                        <i class="fas fa-envelope text-2xl text-white"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Email Settings</h3>
                        <p class="text-sm text-gray-600">SMTP configuration</p>
                    </div>
                </div>
            </div>
            <button class="w-full px-4 py-3 bg-purple-500 hover:bg-purple-600 text-white font-semibold rounded-lg transition mt-4">
                <i class="fas fa-edit mr-2"></i>Configure
            </button>
        </div>

        <!-- WhatsApp Settings -->
        <div class="bg-white rounded-2xl shadow-lg p-6 hover-lift">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                        <i class="fab fa-whatsapp text-2xl text-white"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">WhatsApp Integration</h3>
                        <p class="text-sm text-gray-600">Automation settings</p>
                    </div>
                </div>
            </div>
            <button class="w-full px-4 py-3 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-lg transition mt-4">
                <i class="fas fa-edit mr-2"></i>Configure
            </button>
        </div>

        <!-- SEO Settings -->
        <div class="bg-white rounded-2xl shadow-lg p-6 hover-lift">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);">
                        <i class="fas fa-search text-2xl text-white"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">SEO Settings</h3>
                        <p class="text-sm text-gray-600">Search optimization</p>
                    </div>
                </div>
            </div>
            <button class="w-full px-4 py-3 bg-red-500 hover:bg-red-600 text-white font-semibold rounded-lg transition mt-4">
                <i class="fas fa-edit mr-2"></i>Configure
            </button>
        </div>
    </div>

    <!-- System Information -->
    <div class="bg-white rounded-2xl shadow-lg p-6 mt-6">
        <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
            <i class="fas fa-info-circle text-blue-500 mr-3"></i>
            System Information
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="p-4 bg-gray-50 rounded-xl">
                <p class="text-sm text-gray-600 mb-1">Laravel Version</p>
                <p class="text-lg font-bold text-gray-900">{{ app()->version() }}</p>
            </div>
            <div class="p-4 bg-gray-50 rounded-xl">
                <p class="text-sm text-gray-600 mb-1">PHP Version</p>
                <p class="text-lg font-bold text-gray-900">{{ PHP_VERSION }}</p>
            </div>
            <div class="p-4 bg-gray-50 rounded-xl">
                <p class="text-sm text-gray-600 mb-1">Environment</p>
                <p class="text-lg font-bold text-gray-900">{{ config('app.env') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
