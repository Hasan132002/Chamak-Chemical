@extends('layouts.app')

@section('title', __('Dealer Dashboard'))

@section('content')
    <div class="bg-primary-500 text-white py-8">
        <div class="container mx-auto px-4">
            <h1 class="text-3xl font-bold">{{ __('Dealer Dashboard') }}</h1>
            <p>{{ __('Welcome back') }}, {{ auth()->user()->name }}</p>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <!-- Dealer Status -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="text-sm text-gray-600 mb-1">{{ __('Status') }}</div>
                <div class="text-2xl font-bold {{ $dealer->isApproved() ? 'text-green-500' : 'text-yellow-500' }}">
                    {{ ucfirst($dealer->approval_status) }}
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="text-sm text-gray-600 mb-1">{{ __('Dealer Tier') }}</div>
                <div class="text-2xl font-bold text-primary-500">
                    {{ ucfirst($dealer->dealer_tier) }}
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="text-sm text-gray-600 mb-1">{{ __('Credit Limit') }}</div>
                <div class="text-2xl font-bold text-secondary-500">
                    PKR {{ number_format($dealer->credit_limit, 0) }}
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="text-sm text-gray-600 mb-1">{{ __('Total Orders') }}</div>
                <div class="text-2xl font-bold text-gray-800">
                    {{ $orders->total() }}
                </div>
            </div>
        </div>

        @if(!$dealer->isApproved())
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mb-8">
                <h3 class="font-bold text-yellow-800 mb-2">{{ __('Pending Approval') }}</h3>
                <p class="text-yellow-700">{{ __('Your dealer registration is under review. We will contact you once approved.') }}</p>
            </div>
        @else
            <!-- Wholesale Pricing Info -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-8">
                <h3 class="font-bold text-lg mb-4">{{ __('Your Wholesale Discounts') }}</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="text-center">
                        <div class="text-sm text-gray-600">{{ __('Bronze Tier') }}</div>
                        <div class="text-xl font-bold text-amber-700">10% OFF</div>
                        <div class="text-xs text-gray-500">50+ units</div>
                    </div>
                    <div class="text-center">
                        <div class="text-sm text-gray-600">{{ __('Silver Tier') }}</div>
                        <div class="text-xl font-bold text-gray-500">15% OFF</div>
                        <div class="text-xs text-gray-500">100+ units</div>
                    </div>
                    <div class="text-center">
                        <div class="text-sm text-gray-600">{{ __('Gold Tier') }}</div>
                        <div class="text-xl font-bold text-yellow-500">20% OFF</div>
                        <div class="text-xs text-gray-500">200+ units</div>
                    </div>
                    <div class="text-center">
                        <div class="text-sm text-gray-600">{{ __('Platinum Tier') }}</div>
                        <div class="text-xl font-bold text-blue-500">25% OFF</div>
                        <div class="text-xs text-gray-500">500+ units</div>
                    </div>
                </div>
                <div class="mt-4 text-center">
                    <a href="{{ route('products.index') }}" class="inline-block bg-primary-500 hover:bg-primary-600 text-white px-6 py-2 rounded-lg">
                        {{ __('Browse Products with Wholesale Pricing') }}
                    </a>
                </div>
            </div>
        @endif

        <!-- Recent Orders -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-bold mb-6">{{ __('Recent Orders') }}</h2>

            @if($orders->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-sm font-semibold">{{ __('Order#') }}</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold">{{ __('Date') }}</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold">{{ __('Status') }}</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold">{{ __('Total') }}</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold">{{ __('Payment') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @foreach($orders as $order)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 font-mono text-sm">{{ $order->order_number }}</td>
                                    <td class="px-4 py-3 text-sm">{{ $order->created_at->format('d M, Y') }}</td>
                                    <td class="px-4 py-3">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                                            {{ $order->status === 'delivered' ? 'bg-green-100 text-green-700' :
                                               ($order->status === 'cancelled' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 font-bold">PKR {{ number_format($order->total_amount, 0) }}</td>
                                    <td class="px-4 py-3">
                                        <span class="text-xs {{ $order->payment_status === 'paid' ? 'text-green-600' : 'text-yellow-600' }}">
                                            {{ ucfirst($order->payment_status) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    {{ $orders->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <div class="text-6xl mb-4">📦</div>
                    <p class="text-gray-600">{{ __('No orders yet. Start ordering to get wholesale discounts!') }}</p>
                </div>
            @endif
        </div>
    </div>
@endsection
