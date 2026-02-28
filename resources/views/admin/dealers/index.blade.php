@extends('admin.layout')

@section('title', 'Dealers')
@section('page-title', 'Wholesale Dealers')
@section('page-description', 'Manage wholesale dealer registrations')

@section('content')
<div class="animate-slide-in">
    <!-- Header with Stats -->
    <div class="grid grid-cols-2 md:grid-cols-3 gap-3 sm:gap-6 mb-4 sm:mb-8">
        @php
            $totalDealers = \App\Models\Dealer::count();
            $pendingDealers = \App\Models\Dealer::where('approval_status', 'pending')->count();
            $approvedDealers = \App\Models\Dealer::where('approval_status', 'approved')->count();
        @endphp

        <div class="bg-white rounded-xl shadow-lg p-3 sm:p-6 hover-lift" style="border-left: 4px solid #3b82f6;">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm text-gray-600 font-semibold mb-1">Total Dealers</p>
                    <h3 class="text-xl sm:text-3xl font-bold text-gray-900">{{ $totalDealers }}</h3>
                </div>
                <div class="w-10 h-10 sm:w-14 sm:h-14 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
                    <i class="fas fa-handshake text-lg sm:text-2xl text-white"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-3 sm:p-6 hover-lift" style="border-left: 4px solid #f59e0b;">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm text-gray-600 font-semibold mb-1">Pending</p>
                    <h3 class="text-xl sm:text-3xl font-bold text-orange-600">{{ $pendingDealers }}</h3>
                </div>
                <div class="w-10 h-10 sm:w-14 sm:h-14 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                    <i class="fas fa-clock text-lg sm:text-2xl text-white"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-3 sm:p-6 hover-lift col-span-2 md:col-span-1" style="border-left: 4px solid #10b981;">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm text-gray-600 font-semibold mb-1">Approved</p>
                    <h3 class="text-xl sm:text-3xl font-bold text-green-600">{{ $approvedDealers }}</h3>
                </div>
                <div class="w-10 h-10 sm:w-14 sm:h-14 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                    <i class="fas fa-check-circle text-lg sm:text-2xl text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Dealers Table -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="p-4 sm:p-6 border-b border-gray-200">
            <h2 class="text-lg sm:text-2xl font-bold text-gray-900 flex items-center">
                <i class="fas fa-list mr-2 sm:mr-3 text-blue-500"></i>
                All Dealers
            </h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-orange-500 to-orange-600 text-white">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-bold">Business Name</th>
                        <th class="px-6 py-4 text-left text-sm font-bold">Contact Person</th>
                        <th class="px-6 py-4 text-left text-sm font-bold">Location</th>
                        <th class="px-6 py-4 text-left text-sm font-bold">Tier</th>
                        <th class="px-6 py-4 text-left text-sm font-bold">Status</th>
                        <th class="px-6 py-4 text-left text-sm font-bold">Registered</th>
                        <th class="px-6 py-4 text-center text-sm font-bold">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @php
                        $dealers = \App\Models\Dealer::with('user')->latest()->paginate(20);
                    @endphp

                    @forelse($dealers as $dealer)
                        <tr class="hover:bg-orange-50 transition">
                            <td class="px-6 py-4">
                                <div>
                                    <p class="font-bold text-gray-900">{{ $dealer->business_name }}</p>
                                    <p class="text-xs text-gray-500">License: {{ $dealer->business_license ?? 'N/A' }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $dealer->user->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $dealer->user->email }}</p>
                                    <p class="text-xs text-gray-500">{{ $dealer->user->phone }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $dealer->city }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-bold">
                                    {{ ucfirst($dealer->dealer_tier ?? 'Standard') }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-yellow-100 text-yellow-700',
                                        'approved' => 'bg-green-100 text-green-700',
                                        'rejected' => 'bg-red-100 text-red-700',
                                    ];
                                @endphp
                                <span class="px-3 py-1 rounded-full text-xs font-bold {{ $statusColors[$dealer->approval_status] ?? 'bg-gray-100 text-gray-700' }}">
                                    {{ ucfirst($dealer->approval_status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $dealer->created_at->format('d M, Y') }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('admin.dealers.show', $dealer) }}" class="inline-block px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-semibold rounded-lg transition">
                                    <i class="fas fa-eye mr-1"></i>View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-16 text-center">
                                <i class="fas fa-user-tie text-6xl text-gray-300 mb-4"></i>
                                <h3 class="text-xl font-bold text-gray-600 mb-2">No Dealers Found</h3>
                                <p class="text-gray-500">Dealer registrations will appear here</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($dealers->hasPages())
            <div class="p-6 border-t border-gray-200">
                {{ $dealers->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
