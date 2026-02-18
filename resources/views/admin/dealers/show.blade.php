@extends('admin.layout')

@section('title', 'Dealer Details')
@section('page-title', $dealer->business_name)
@section('page-description', 'View dealer information and approve/reject')

@section('content')
<div class="animate-slide-in">
    <!-- Back Button -->
    <a href="{{ route('admin.dealers.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-semibold mb-6">
        <i class="fas fa-arrow-left mr-2"></i>Back to Dealers
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Dealer Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Business Information -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-building text-orange-500 mr-3"></i>
                    Business Information
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Business Name</p>
                        <p class="font-bold text-gray-900">{{ $dealer->business_name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Business License</p>
                        <p class="font-semibold text-gray-900">{{ $dealer->business_license ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Tax ID</p>
                        <p class="font-semibold text-gray-900">{{ $dealer->tax_id ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Dealer Tier</p>
                        <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-sm font-bold">
                            {{ ucfirst($dealer->dealer_tier ?? 'Standard') }}
                        </span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Credit Limit</p>
                        <p class="font-bold text-green-600">PKR {{ number_format($dealer->credit_limit ?? 0, 0) }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Payment Terms</p>
                        <p class="font-semibold text-gray-900">{{ $dealer->payment_terms ?? 0 }} days</p>
                    </div>
                </div>
            </div>

            <!-- Business Address -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-map-marker-alt text-red-500 mr-3"></i>
                    Business Address
                </h3>

                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-gray-900">{{ $dealer->address }}</p>
                    <p class="text-gray-600 mt-2">{{ $dealer->city }}, {{ $dealer->state }}</p>
                    <p class="text-gray-600">{{ $dealer->postal_code }}</p>
                </div>
            </div>

            <!-- Contact Person -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-user text-blue-500 mr-3"></i>
                    Contact Person
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Name</p>
                        <p class="font-bold text-gray-900">{{ $dealer->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Email</p>
                        <p class="font-semibold text-gray-900">{{ $dealer->user->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Phone</p>
                        <p class="font-semibold text-gray-900">{{ $dealer->user->phone ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Registration Date</p>
                        <p class="font-semibold text-gray-900">{{ $dealer->created_at->format('d M, Y') }}</p>
                    </div>
                </div>

                <div class="mt-4 pt-4 border-t border-gray-200">
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $dealer->user->phone ?? '') }}" target="_blank" class="inline-block px-6 py-3 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-lg transition">
                        <i class="fab fa-whatsapp mr-2"></i>WhatsApp Contact
                    </a>
                </div>
            </div>

            <!-- Approval History -->
            @if($dealer->approval_status === 'approved' && $dealer->approvedBy)
            <div class="bg-green-50 rounded-2xl shadow-lg p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                    Approval Information
                </h3>

                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Approved By:</span>
                        <span class="font-semibold text-gray-900">{{ $dealer->approvedBy->name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Approved On:</span>
                        <span class="font-semibold text-gray-900">{{ $dealer->approved_at->format('d M, Y h:i A') }}</span>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Status Card -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-info-circle text-blue-500 mr-3"></i>
                    Status
                </h3>

                <div class="text-center mb-6">
                    @php
                        $statusColors = [
                            'pending' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-700', 'icon' => 'fa-clock'],
                            'approved' => ['bg' => 'bg-green-100', 'text' => 'text-green-700', 'icon' => 'fa-check-circle'],
                            'rejected' => ['bg' => 'bg-red-100', 'text' => 'text-red-700', 'icon' => 'fa-times-circle'],
                        ];
                        $status = $statusColors[$dealer->approval_status] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-700', 'icon' => 'fa-question'];
                    @endphp

                    <div class="inline-block px-6 py-3 {{ $status['bg'] }} {{ $status['text'] }} rounded-xl text-lg font-bold mb-2">
                        <i class="fas {{ $status['icon'] }} mr-2"></i>{{ ucfirst($dealer->approval_status) }}
                    </div>
                </div>

                <!-- Approval Actions -->
                @if($dealer->approval_status === 'pending')
                    <div class="space-y-3">
                        <form action="{{ route('admin.dealers.approve', $dealer) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="w-full px-6 py-3 rounded-xl text-white font-bold shadow-lg hover-lift" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                                <i class="fas fa-check mr-2"></i>Approve Dealer
                            </button>
                        </form>

                        <form action="{{ route('admin.dealers.reject', $dealer) }}" method="POST" onsubmit="return confirm('Are you sure you want to reject this dealer?');">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="w-full px-6 py-3 bg-red-500 hover:bg-red-600 text-white font-bold rounded-xl transition">
                                <i class="fas fa-times mr-2"></i>Reject Dealer
                            </button>
                        </form>
                    </div>
                @endif
            </div>

            <!-- Quick Stats -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-chart-bar text-purple-500 mr-3"></i>
                    Quick Stats
                </h3>

                <div class="space-y-4">
                    <div class="p-4 bg-blue-50 rounded-xl">
                        <p class="text-sm text-gray-600 mb-1">Total Orders</p>
                        <p class="text-2xl font-bold text-blue-600">0</p>
                    </div>
                    <div class="p-4 bg-green-50 rounded-xl">
                        <p class="text-sm text-gray-600 mb-1">Total Purchases</p>
                        <p class="text-2xl font-bold text-green-600">PKR 0</p>
                    </div>
                    <div class="p-4 bg-orange-50 rounded-xl">
                        <p class="text-sm text-gray-600 mb-1">Outstanding Balance</p>
                        <p class="text-2xl font-bold text-orange-600">PKR 0</p>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-bolt text-yellow-500 mr-3"></i>
                    Quick Actions
                </h3>

                <div class="space-y-3">
                    <button class="w-full px-4 py-3 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-lg transition">
                        <i class="fas fa-envelope mr-2"></i>Send Email
                    </button>
                    <button class="w-full px-4 py-3 bg-purple-500 hover:bg-purple-600 text-white font-semibold rounded-lg transition">
                        <i class="fas fa-edit mr-2"></i>Edit Details
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
