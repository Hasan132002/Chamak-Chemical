@extends('admin.layout')

@section('title', 'Reports & Analytics')
@section('page-title', 'Reports & Analytics')
@section('page-description', 'View detailed sales and performance reports')

@section('content')
<div class="animate-slide-in">
    <!-- Quick Stats -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-6 mb-4 sm:mb-8">
        @php
            $todaySales = \App\Models\Order::whereDate('created_at', today())->sum('total_amount');
            $monthSales = \App\Models\Order::whereMonth('created_at', now()->month)->sum('total_amount');
            $totalRevenue = \App\Models\Order::where('status', 'delivered')->sum('total_amount');
            $avgOrderValue = \App\Models\Order::avg('total_amount');
        @endphp

        <div class="bg-white rounded-xl sm:rounded-2xl shadow-lg p-3 sm:p-6 hover-lift" style="border-left: 4px solid #10b981;">
            <div class="flex items-center justify-between mb-2 sm:mb-4">
                <div>
                    <p class="text-xs sm:text-sm text-gray-600 font-semibold mb-1">Today's Sales</p>
                    <h3 class="text-lg sm:text-3xl font-bold text-green-600">PKR {{ number_format($todaySales, 0) }}</h3>
                </div>
                <div class="w-10 h-10 sm:w-14 sm:h-14 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                    <i class="fas fa-calendar-day text-lg sm:text-2xl text-white"></i>
                </div>
            </div>
            <p class="text-xs text-gray-500 hidden sm:block"><i class="fas fa-arrow-up text-green-500 mr-1"></i>Updated today</p>
        </div>

        <div class="bg-white rounded-xl sm:rounded-2xl shadow-lg p-3 sm:p-6 hover-lift" style="border-left: 4px solid #3b82f6;">
            <div class="flex items-center justify-between mb-2 sm:mb-4">
                <div>
                    <p class="text-xs sm:text-sm text-gray-600 font-semibold mb-1">This Month</p>
                    <h3 class="text-lg sm:text-3xl font-bold text-blue-600">PKR {{ number_format($monthSales, 0) }}</h3>
                </div>
                <div class="w-10 h-10 sm:w-14 sm:h-14 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
                    <i class="fas fa-calendar-alt text-lg sm:text-2xl text-white"></i>
                </div>
            </div>
            <p class="text-xs text-gray-500 hidden sm:block"><i class="fas fa-chart-line text-blue-500 mr-1"></i>Monthly total</p>
        </div>

        <div class="bg-white rounded-xl sm:rounded-2xl shadow-lg p-3 sm:p-6 hover-lift" style="border-left: 4px solid #a855f7;">
            <div class="flex items-center justify-between mb-2 sm:mb-4">
                <div>
                    <p class="text-xs sm:text-sm text-gray-600 font-semibold mb-1">Total Revenue</p>
                    <h3 class="text-lg sm:text-3xl font-bold text-purple-600">PKR {{ number_format($totalRevenue, 0) }}</h3>
                </div>
                <div class="w-10 h-10 sm:w-14 sm:h-14 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, #a855f7 0%, #9333ea 100%);">
                    <i class="fas fa-dollar-sign text-lg sm:text-2xl text-white"></i>
                </div>
            </div>
            <p class="text-xs text-gray-500 hidden sm:block"><i class="fas fa-infinity text-purple-500 mr-1"></i>All time</p>
        </div>

        <div class="bg-white rounded-xl sm:rounded-2xl shadow-lg p-3 sm:p-6 hover-lift" style="border-left: 4px solid #f59e0b;">
            <div class="flex items-center justify-between mb-2 sm:mb-4">
                <div>
                    <p class="text-xs sm:text-sm text-gray-600 font-semibold mb-1">Avg Order</p>
                    <h3 class="text-lg sm:text-3xl font-bold text-orange-600">PKR {{ number_format($avgOrderValue, 0) }}</h3>
                </div>
                <div class="w-10 h-10 sm:w-14 sm:h-14 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                    <i class="fas fa-shopping-cart text-lg sm:text-2xl text-white"></i>
                </div>
            </div>
            <p class="text-xs text-gray-500 hidden sm:block"><i class="fas fa-chart-bar text-orange-500 mr-1"></i>Average value</p>
        </div>
    </div>

    <!-- Report Filters -->
    <div class="bg-white rounded-2xl shadow-lg p-4 sm:p-6 mb-4 sm:mb-8">
        <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-4 sm:mb-6 flex items-center">
            <i class="fas fa-filter text-blue-500 mr-2 sm:mr-3"></i>
            Filter Reports
        </h3>

        <form class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3 sm:gap-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Date From</label>
                <input type="date" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Date To</label>
                <input type="date" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Report Type</label>
                <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option>Sales Report</option>
                    <option>Product Report</option>
                    <option>Category Report</option>
                    <option>Dealer Report</option>
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full px-6 py-2 rounded-lg text-white font-semibold" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
                    <i class="fas fa-search mr-2"></i>Generate
                </button>
            </div>
        </form>
    </div>

    <!-- Report Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-6">
        <!-- Sales Report -->
        <div class="bg-white rounded-2xl shadow-lg p-6 hover-lift">
            <div class="flex items-center justify-between mb-4">
                <div class="w-14 h-14 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                    <i class="fas fa-chart-line text-2xl text-white"></i>
                </div>
                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">Available</span>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Sales Report</h3>
            <p class="text-sm text-gray-600 mb-4">Daily, weekly, monthly sales breakdown with trends</p>
            <button class="w-full px-4 py-2 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-lg transition">
                <i class="fas fa-download mr-2"></i>Download PDF
            </button>
        </div>

        <!-- Product Performance -->
        <div class="bg-white rounded-2xl shadow-lg p-6 hover-lift">
            <div class="flex items-center justify-between mb-4">
                <div class="w-14 h-14 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
                    <i class="fas fa-box text-2xl text-white"></i>
                </div>
                <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-bold">Available</span>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Product Performance</h3>
            <p class="text-sm text-gray-600 mb-4">Top selling products and inventory analysis</p>
            <button class="w-full px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-lg transition">
                <i class="fas fa-download mr-2"></i>Download Excel
            </button>
        </div>

        <!-- Customer Report -->
        <div class="bg-white rounded-2xl shadow-lg p-6 hover-lift">
            <div class="flex items-center justify-between mb-4">
                <div class="w-14 h-14 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, #a855f7 0%, #9333ea 100%);">
                    <i class="fas fa-users text-2xl text-white"></i>
                </div>
                <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-bold">Available</span>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Customer Report</h3>
            <p class="text-sm text-gray-600 mb-4">Customer behavior and purchase patterns</p>
            <button class="w-full px-4 py-2 bg-purple-500 hover:bg-purple-600 text-white font-semibold rounded-lg transition">
                <i class="fas fa-download mr-2"></i>Download PDF
            </button>
        </div>

        <!-- Inventory Report -->
        <div class="bg-white rounded-2xl shadow-lg p-6 hover-lift">
            <div class="flex items-center justify-between mb-4">
                <div class="w-14 h-14 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                    <i class="fas fa-warehouse text-2xl text-white"></i>
                </div>
                <span class="px-3 py-1 bg-orange-100 text-orange-700 rounded-full text-xs font-bold">Available</span>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Inventory Report</h3>
            <p class="text-sm text-gray-600 mb-4">Stock levels, low stock alerts, and turnover</p>
            <button class="w-full px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-lg transition">
                <i class="fas fa-download mr-2"></i>Download Excel
            </button>
        </div>

        <!-- Dealer Report -->
        <div class="bg-white rounded-2xl shadow-lg p-6 hover-lift">
            <div class="flex items-center justify-between mb-4">
                <div class="w-14 h-14 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);">
                    <i class="fas fa-handshake text-2xl text-white"></i>
                </div>
                <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-bold">Available</span>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Wholesale Dealer Report</h3>
            <p class="text-sm text-gray-600 mb-4">Dealer sales, credit, and performance metrics</p>
            <button class="w-full px-4 py-2 bg-red-500 hover:bg-red-600 text-white font-semibold rounded-lg transition">
                <i class="fas fa-download mr-2"></i>Download PDF
            </button>
        </div>

        <!-- Tax Report -->
        <div class="bg-white rounded-2xl shadow-lg p-6 hover-lift">
            <div class="flex items-center justify-between mb-4">
                <div class="w-14 h-14 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);">
                    <i class="fas fa-file-invoice-dollar text-2xl text-white"></i>
                </div>
                <span class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-xs font-bold">Available</span>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Tax & Financial Report</h3>
            <p class="text-sm text-gray-600 mb-4">Tax calculations and financial summaries</p>
            <button class="w-full px-4 py-2 bg-indigo-500 hover:bg-indigo-600 text-white font-semibold rounded-lg transition">
                <i class="fas fa-download mr-2"></i>Download PDF
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush
@endsection
