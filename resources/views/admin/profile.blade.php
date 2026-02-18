@extends('admin.layout')

@section('title', 'My Profile')
@section('page-title', 'My Profile')
@section('page-description', 'Manage your admin account settings')

@section('content')
<div class="max-w-4xl animate-slide-in">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profile Sidebar -->
        <div class="space-y-6">
            <!-- Profile Card -->
            <div class="bg-white rounded-2xl shadow-lg p-6 text-center">
                <div class="w-24 h-24 mx-auto rounded-full flex items-center justify-center text-white text-3xl font-bold mb-4" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-1">{{ auth()->user()->name }}</h3>
                <p class="text-sm text-gray-600 mb-1">{{ auth()->user()->email }}</p>
                <span class="inline-block px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-bold mt-2">
                    {{ auth()->user()->getRoleNames()->first() ?? 'Admin' }}
                </span>

                <div class="mt-6 pt-6 border-t border-gray-200">
                    <button class="w-full px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-lg transition">
                        <i class="fas fa-camera mr-2"></i>Change Photo
                    </button>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h4 class="font-bold text-gray-900 mb-4">Activity Summary</h4>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Login Count</span>
                        <span class="font-bold text-blue-600">245</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Last Login</span>
                        <span class="font-semibold text-gray-900 text-sm">Today</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Member Since</span>
                        <span class="font-semibold text-gray-900 text-sm">{{ auth()->user()->created_at->format('M Y') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Forms -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Personal Information -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-user text-blue-500 mr-3"></i>
                    Personal Information
                </h3>

                <form class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Full Name</label>
                            <input type="text" value="{{ auth()->user()->name }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                            <input type="email" value="{{ auth()->user()->email }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Phone Number</label>
                            <input type="text" value="{{ auth()->user()->phone ?? '' }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Role</label>
                            <input type="text" value="{{ auth()->user()->getRoleNames()->first() ?? 'Admin' }}" disabled class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100">
                        </div>
                    </div>

                    <div class="flex gap-3 pt-4">
                        <button type="submit" class="px-6 py-2 rounded-lg text-white font-semibold" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                            <i class="fas fa-save mr-2"></i>Save Changes
                        </button>
                        <button type="button" class="px-6 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg text-gray-700 font-semibold transition">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>

            <!-- Change Password -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-lock text-orange-500 mr-3"></i>
                    Change Password
                </h3>

                <form class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Current Password</label>
                        <input type="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">New Password</label>
                        <input type="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Confirm New Password</label>
                        <input type="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                    </div>

                    <button type="submit" class="px-6 py-2 rounded-lg text-white font-semibold" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                        <i class="fas fa-key mr-2"></i>Update Password
                    </button>
                </form>
            </div>

            <!-- Preferences -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-cog text-purple-500 mr-3"></i>
                    Preferences
                </h3>

                <div class="space-y-4">
                    <label class="flex items-center justify-between cursor-pointer p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                        <div>
                            <p class="font-semibold text-gray-900">Email Notifications</p>
                            <p class="text-sm text-gray-600">Receive email alerts for new orders</p>
                        </div>
                        <input type="checkbox" checked class="w-5 h-5 text-blue-600 rounded focus:ring-2 focus:ring-blue-500">
                    </label>

                    <label class="flex items-center justify-between cursor-pointer p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                        <div>
                            <p class="font-semibold text-gray-900">SMS Notifications</p>
                            <p class="text-sm text-gray-600">Get SMS for urgent updates</p>
                        </div>
                        <input type="checkbox" class="w-5 h-5 text-blue-600 rounded focus:ring-2 focus:ring-blue-500">
                    </label>

                    <label class="flex items-center justify-between cursor-pointer p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                        <div>
                            <p class="font-semibold text-gray-900">Two-Factor Authentication</p>
                            <p class="text-sm text-gray-600">Add extra security to your account</p>
                        </div>
                        <input type="checkbox" class="w-5 h-5 text-blue-600 rounded focus:ring-2 focus:ring-blue-500">
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
