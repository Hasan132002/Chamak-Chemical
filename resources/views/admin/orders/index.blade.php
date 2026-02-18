@extends('admin.layout')

@section('title', 'Orders')
@section('page-title', 'Orders Management')
@section('page-description', 'View and manage all customer orders')

@section('content')
<div class="animate-slide-in">
    <!-- Header with Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        @php
            $totalOrders = \App\Models\Order::count();
            $pendingOrders = \App\Models\Order::where('status', 'pending')->count();
            $processingOrders = \App\Models\Order::where('status', 'processing')->count();
            $deliveredOrders = \App\Models\Order::where('status', 'delivered')->count();
        @endphp

        <div class="bg-white rounded-xl shadow-lg p-6 hover-lift" style="border-left: 4px solid #3b82f6;">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 font-semibold mb-1">Total Orders</p>
                    <h3 class="text-3xl font-bold text-gray-900">{{ $totalOrders }}</h3>
                </div>
                <div class="w-14 h-14 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
                    <i class="fas fa-shopping-bag text-2xl text-white"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 hover-lift" style="border-left: 4px solid #f59e0b;">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 font-semibold mb-1">Pending</p>
                    <h3 class="text-3xl font-bold text-orange-600">{{ $pendingOrders }}</h3>
                </div>
                <div class="w-14 h-14 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                    <i class="fas fa-clock text-2xl text-white"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 hover-lift" style="border-left: 4px solid #a855f7;">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 font-semibold mb-1">Processing</p>
                    <h3 class="text-3xl font-bold text-purple-600">{{ $processingOrders }}</h3>
                </div>
                <div class="w-14 h-14 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, #a855f7 0%, #9333ea 100%);">
                    <i class="fas fa-cog text-2xl text-white"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 hover-lift" style="border-left: 4px solid #10b981;">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 font-semibold mb-1">Delivered</p>
                    <h3 class="text-3xl font-bold text-green-600">{{ $deliveredOrders }}</h3>
                </div>
                <div class="w-14 h-14 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                    <i class="fas fa-check-circle text-2xl text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-2xl font-bold text-gray-900 flex items-center">
                <i class="fas fa-list mr-3 text-blue-500"></i>
                All Orders
            </h2>
            <p class="text-sm text-gray-600 mt-1">Total: {{ $orders->total() }} orders</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-blue-500 to-blue-600 text-white">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-bold">Order #</th>
                        <th class="px-6 py-4 text-left text-sm font-bold">Customer</th>
                        <th class="px-6 py-4 text-left text-sm font-bold">Items</th>
                        <th class="px-6 py-4 text-left text-sm font-bold">Amount</th>
                        <th class="px-6 py-4 text-left text-sm font-bold">Payment</th>
                        <th class="px-6 py-4 text-left text-sm font-bold">Status</th>
                        <th class="px-6 py-4 text-left text-sm font-bold">Date</th>
                        <th class="px-6 py-4 text-center text-sm font-bold">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($orders as $order)
                        <tr class="hover:bg-blue-50 transition">
                            <td class="px-6 py-4">
                                <span class="font-mono text-sm font-bold text-blue-600">#{{ $order->order_number }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $order->user->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $order->user->email }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-sm font-bold">
                                    {{ $order->items->count() }} items
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-lg font-bold text-green-600">PKR {{ number_format($order->total_amount, 0) }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-bold {{ $order->payment_method === 'cod' ? 'bg-orange-100 text-orange-700' : 'bg-green-100 text-green-700' }}">
                                    {{ strtoupper($order->payment_method) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-yellow-100 text-yellow-700',
                                        'confirmed' => 'bg-blue-100 text-blue-700',
                                        'processing' => 'bg-purple-100 text-purple-700',
                                        'packed' => 'bg-indigo-100 text-indigo-700',
                                        'shipped' => 'bg-cyan-100 text-cyan-700',
                                        'delivered' => 'bg-green-100 text-green-700',
                                        'cancelled' => 'bg-red-100 text-red-700',
                                    ];
                                @endphp
                                <span class="px-3 py-1 rounded-full text-xs font-bold {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-700' }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $order->created_at->format('d M, Y') }}
                                <br>
                                <span class="text-xs text-gray-400">{{ $order->created_at->format('h:i A') }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('admin.orders.show', $order) }}" class="inline-block px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-semibold rounded-lg transition">
                                    <i class="fas fa-eye mr-1"></i>View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-16 text-center">
                                <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                                <h3 class="text-xl font-bold text-gray-600 mb-2">No Orders Found</h3>
                                <p class="text-gray-500">Orders will appear here once customers place them</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($orders->hasPages())
            <div class="p-6 border-t border-gray-200">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
