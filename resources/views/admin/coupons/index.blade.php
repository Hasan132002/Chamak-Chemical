@extends('admin.layout')

@section('title', 'Coupons & Discounts')
@section('page-title', 'Coupons Management')
@section('page-description', 'Create and manage discount coupons')

@section('content')
<div class="animate-slide-in">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 flex items-center">
                <i class="fas fa-ticket-alt text-orange-500 mr-3"></i>
                All Coupons
            </h2>
            <p class="text-sm text-gray-600 mt-1">Manage promotional codes and discounts</p>
        </div>
        <button class="px-6 py-3 rounded-xl text-white font-semibold shadow-lg hover-lift" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
            <i class="fas fa-plus mr-2"></i>Create Coupon
        </button>
    </div>

    <!-- Coupons List -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-orange-500 to-orange-600 text-white">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-bold">Code</th>
                        <th class="px-6 py-4 text-left text-sm font-bold">Description</th>
                        <th class="px-6 py-4 text-left text-sm font-bold">Discount</th>
                        <th class="px-6 py-4 text-left text-sm font-bold">Usage</th>
                        <th class="px-6 py-4 text-left text-sm font-bold">Valid Until</th>
                        <th class="px-6 py-4 text-left text-sm font-bold">Status</th>
                        <th class="px-6 py-4 text-center text-sm font-bold">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @php
                        $coupons = [
                            ['code' => 'SUMMER2026', 'desc' => 'Summer Sale', 'discount' => '20%', 'used' => 45, 'limit' => 100, 'expires' => '2026-08-31', 'active' => true],
                            ['code' => 'WELCOME10', 'desc' => 'New Customer Discount', 'discount' => '10%', 'used' => 120, 'limit' => 500, 'expires' => '2026-12-31', 'active' => true],
                            ['code' => 'BULK50', 'desc' => 'Wholesale Discount', 'discount' => 'PKR 500', 'used' => 23, 'limit' => 50, 'expires' => '2026-06-30', 'active' => true],
                            ['code' => 'SAVE15', 'desc' => 'General Discount', 'discount' => '15%', 'used' => 87, 'limit' => 200, 'expires' => '2026-05-31', 'active' => false],
                        ];
                    @endphp

                    @foreach($coupons as $coupon)
                        <tr class="hover:bg-orange-50 transition">
                            <td class="px-6 py-4">
                                <span class="font-mono font-bold text-orange-600">{{ $coupon['code'] }}</span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                {{ $coupon['desc'] }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-bold">
                                    {{ $coupon['discount'] }} OFF
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $coupon['used'] }} / {{ $coupon['limit'] }}
                                <div class="w-full bg-gray-200 rounded-full h-2 mt-1">
                                    <div class="bg-blue-600 h-2 rounded-full" style="width: {{ ($coupon['used'] / $coupon['limit']) * 100 }}%"></div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ \Carbon\Carbon::parse($coupon['expires'])->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4">
                                @if($coupon['active'])
                                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">
                                        <i class="fas fa-circle text-green-500 mr-1" style="font-size: 6px;"></i>Active
                                    </span>
                                @else
                                    <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-bold">
                                        <i class="fas fa-circle text-gray-500 mr-1" style="font-size: 6px;"></i>Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <button class="px-3 py-2 bg-blue-500 hover:bg-blue-600 text-white text-xs font-semibold rounded-lg transition">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="px-3 py-2 bg-red-500 hover:bg-red-600 text-white text-xs font-semibold rounded-lg transition">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Coupon Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-8">
        <div class="bg-white rounded-xl shadow-lg p-6 hover-lift">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 font-semibold mb-1">Active Coupons</p>
                    <h3 class="text-3xl font-bold text-green-600">3</h3>
                </div>
                <div class="w-14 h-14 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                    <i class="fas fa-check-circle text-2xl text-white"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 hover-lift">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 font-semibold mb-1">Total Usage</p>
                    <h3 class="text-3xl font-bold text-blue-600">275</h3>
                </div>
                <div class="w-14 h-14 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
                    <i class="fas fa-chart-line text-2xl text-white"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 hover-lift">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 font-semibold mb-1">Discount Given</p>
                    <h3 class="text-3xl font-bold text-orange-600">PKR 45K</h3>
                </div>
                <div class="w-14 h-14 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                    <i class="fas fa-money-bill-wave text-2xl text-white"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 hover-lift">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 font-semibold mb-1">Expired</p>
                    <h3 class="text-3xl font-bold text-red-600">1</h3>
                </div>
                <div class="w-14 h-14 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);">
                    <i class="fas fa-times-circle text-2xl text-white"></i>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
