@extends('admin.layout')

@section('title', 'Notifications')
@section('page-title', 'Notifications Center')
@section('page-description', 'View and manage system notifications')

@section('content')
<div class="max-w-4xl mx-auto animate-slide-in">
    <!-- Header Actions -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 flex items-center">
                <i class="fas fa-bell text-blue-500 mr-3"></i>
                All Notifications
            </h2>
            <p class="text-sm text-gray-600 mt-1">23 unread notifications</p>
        </div>
        <div class="flex gap-2">
            <button class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-lg transition">
                <i class="fas fa-check-double mr-2"></i>Mark All Read
            </button>
            <button class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white font-semibold rounded-lg transition">
                <i class="fas fa-trash mr-2"></i>Clear All
            </button>
        </div>
    </div>

    <!-- Notification Tabs -->
    <div class="bg-white rounded-2xl shadow-lg mb-6">
        <div class="flex border-b border-gray-200">
            <button class="flex-1 px-6 py-4 font-semibold text-blue-600 border-b-2 border-blue-600">
                <i class="fas fa-inbox mr-2"></i>All (23)
            </button>
            <button class="flex-1 px-6 py-4 font-semibold text-gray-600 hover:text-blue-600 transition">
                <i class="fas fa-shopping-cart mr-2"></i>Orders (12)
            </button>
            <button class="flex-1 px-6 py-4 font-semibold text-gray-600 hover:text-blue-600 transition">
                <i class="fas fa-users mr-2"></i>Dealers (5)
            </button>
            <button class="flex-1 px-6 py-4 font-semibold text-gray-600 hover:text-blue-600 transition">
                <i class="fas fa-box mr-2"></i>Products (6)
            </button>
        </div>
    </div>

    <!-- Notifications List -->
    <div class="space-y-4">
        <!-- New Order Notification -->
        <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-green-500 hover:shadow-xl transition">
            <div class="flex items-start justify-between">
                <div class="flex items-start gap-4 flex-1">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                        <i class="fas fa-shopping-cart text-white text-lg"></i>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-1">
                            <h4 class="font-bold text-gray-900">New Order Received</h4>
                            <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                        </div>
                        <p class="text-sm text-gray-600 mb-2">Order #ORD-2024-001 placed by John Doe for PKR 5,400</p>
                        <div class="flex items-center gap-4 text-xs text-gray-500">
                            <span><i class="fas fa-clock mr-1"></i>2 minutes ago</span>
                            <button class="text-blue-600 hover:text-blue-800 font-semibold">
                                <i class="fas fa-eye mr-1"></i>View Order
                            </button>
                        </div>
                    </div>
                </div>
                <button class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        <!-- Low Stock Alert -->
        <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-orange-500 hover:shadow-xl transition">
            <div class="flex items-start justify-between">
                <div class="flex items-start gap-4 flex-1">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                        <i class="fas fa-exclamation-triangle text-white text-lg"></i>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-1">
                            <h4 class="font-bold text-gray-900">Low Stock Alert</h4>
                            <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                        </div>
                        <p class="text-sm text-gray-600 mb-2">Product "Washing Powder Premium" stock is low (5 units remaining)</p>
                        <div class="flex items-center gap-4 text-xs text-gray-500">
                            <span><i class="fas fa-clock mr-1"></i>15 minutes ago</span>
                            <button class="text-blue-600 hover:text-blue-800 font-semibold">
                                <i class="fas fa-eye mr-1"></i>View Product
                            </button>
                        </div>
                    </div>
                </div>
                <button class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        <!-- Dealer Registration -->
        <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-blue-500 hover:shadow-xl transition">
            <div class="flex items-start justify-between">
                <div class="flex items-start gap-4 flex-1">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
                        <i class="fas fa-handshake text-white text-lg"></i>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-1">
                            <h4 class="font-bold text-gray-900">New Dealer Registration</h4>
                            <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                        </div>
                        <p class="text-sm text-gray-600 mb-2">ABC Traders has submitted wholesale dealer application</p>
                        <div class="flex items-center gap-4 text-xs text-gray-500">
                            <span><i class="fas fa-clock mr-1"></i>1 hour ago</span>
                            <button class="text-blue-600 hover:text-blue-800 font-semibold">
                                <i class="fas fa-eye mr-1"></i>Review Application
                            </button>
                        </div>
                    </div>
                </div>
                <button class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        <!-- New Review -->
        <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-purple-500 hover:shadow-xl transition">
            <div class="flex items-start justify-between">
                <div class="flex items-start gap-4 flex-1">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center" style="background: linear-gradient(135deg, #a855f7 0%, #9333ea 100%);">
                        <i class="fas fa-star text-white text-lg"></i>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-bold text-gray-900 mb-1">New Product Review</h4>
                        <p class="text-sm text-gray-600 mb-2">Customer left a 5-star review on "Glass Cleaner Pro"</p>
                        <div class="flex items-center gap-4 text-xs text-gray-500">
                            <span><i class="fas fa-clock mr-1"></i>2 hours ago</span>
                            <button class="text-blue-600 hover:text-blue-800 font-semibold">
                                <i class="fas fa-eye mr-1"></i>View Review
                            </button>
                        </div>
                    </div>
                </div>
                <button class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        <!-- System Update -->
        <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-gray-500">
            <div class="flex items-start justify-between">
                <div class="flex items-start gap-4 flex-1">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center bg-gray-500">
                        <i class="fas fa-cog text-white text-lg"></i>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-bold text-gray-900 mb-1">System Update</h4>
                        <p class="text-sm text-gray-600 mb-2">Database backup completed successfully</p>
                        <div class="flex items-center gap-4 text-xs text-gray-500">
                            <span><i class="fas fa-clock mr-1"></i>5 hours ago</span>
                        </div>
                    </div>
                </div>
                <button class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Load More -->
    <div class="text-center mt-8">
        <button class="px-6 py-3 bg-gray-200 hover:bg-gray-300 rounded-lg text-gray-700 font-semibold transition">
            <i class="fas fa-arrow-down mr-2"></i>Load More Notifications
        </button>
    </div>
</div>
@endsection
