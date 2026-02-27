@extends('admin.layout')

@section('title', 'Deals')
@section('page-title', 'Deals Management')
@section('page-description', 'Manage all your deals and promotions')

@section('content')
<div class="animate-slide-in">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-4 sm:mb-6 gap-3">
        <div>
            <h2 class="text-xl sm:text-2xl font-bold text-gray-900 flex items-center">
                <i class="fas fa-fire text-red-500 mr-2 sm:mr-3"></i>
                All Deals
            </h2>
            <p class="text-xs sm:text-sm text-gray-600 mt-1">Total: {{ $deals->count() }} deals</p>
        </div>
        <a href="{{ route('admin.deals.create') }}" class="px-4 sm:px-6 py-2 sm:py-3 rounded-xl text-white font-semibold shadow-lg hover-lift text-sm sm:text-base text-center" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);">
            <i class="fas fa-plus mr-2"></i>Add New Deal
        </a>
    </div>

    <!-- Deals Table -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-red-500 to-red-600 text-white">
                    <tr>
                        <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs sm:text-sm font-bold">Deal</th>
                        <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs sm:text-sm font-bold">Discount</th>
                        <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs sm:text-sm font-bold">Duration</th>
                        <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs sm:text-sm font-bold">Status</th>
                        <th class="px-3 sm:px-6 py-3 sm:py-4 text-center text-xs sm:text-sm font-bold">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($deals as $deal)
                        @php
                            $translation = $deal->translations->where('locale', 'en')->first();
                        @endphp
                        <tr class="hover:bg-red-50 transition">
                            <td class="px-3 sm:px-6 py-3 sm:py-4">
                                <div class="flex items-center gap-3">
                                    @if($deal->image)
                                        <img src="{{ asset('storage/' . $deal->image) }}" alt="{{ $translation->title ?? 'Deal' }}" class="w-16 h-12 rounded-lg object-cover flex-shrink-0">
                                    @else
                                        <div class="w-16 h-12 rounded-lg flex items-center justify-center flex-shrink-0" style="background: linear-gradient(135deg, #fecaca 0%, #fca5a5 100%);">
                                            <i class="fas fa-fire text-red-400"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-bold text-gray-900">{{ $translation->title ?? 'N/A' }}</p>
                                        <p class="text-xs text-gray-500 line-clamp-1">{{ $translation->description ?? '' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-3 sm:px-6 py-3 sm:py-4">
                                @if($deal->discount_percentage)
                                    <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm font-bold">
                                        {{ $deal->discount_percentage }}% OFF
                                    </span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-3 sm:px-6 py-3 sm:py-4 text-sm text-gray-600">
                                @if($deal->starts_at || $deal->ends_at)
                                    <div>
                                        @if($deal->starts_at)
                                            <span class="text-xs">From: {{ $deal->starts_at->format('d M, Y') }}</span><br>
                                        @endif
                                        @if($deal->ends_at)
                                            <span class="text-xs">To: {{ $deal->ends_at->format('d M, Y') }}</span>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-gray-400">Always</span>
                                @endif
                            </td>
                            <td class="px-3 sm:px-6 py-3 sm:py-4">
                                <span class="px-2 sm:px-4 py-1 sm:py-2 rounded-lg text-xs sm:text-sm font-bold {{ $deal->is_active ? 'bg-green-500 text-white' : 'bg-gray-300 text-gray-700' }}">
                                    @if($deal->is_active)
                                        <i class="fas fa-check-circle mr-1"></i>Active
                                    @else
                                        <i class="fas fa-times-circle mr-1"></i>Inactive
                                    @endif
                                </span>
                            </td>
                            <td class="px-3 sm:px-6 py-3 sm:py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.deals.edit', $deal) }}"
                                       class="px-2 sm:px-4 py-1.5 sm:py-2 bg-blue-500 hover:bg-blue-600 text-white text-xs sm:text-sm font-semibold rounded-lg transition">
                                        <i class="fas fa-edit mr-1"></i>Edit
                                    </a>
                                    <form action="{{ route('admin.deals.destroy', $deal) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this deal?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2 sm:px-4 py-1.5 sm:py-2 bg-red-500 hover:bg-red-600 text-white text-xs sm:text-sm font-semibold rounded-lg transition">
                                            <i class="fas fa-trash mr-1"></i>Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 sm:px-6 py-10 sm:py-16 text-center">
                                <i class="fas fa-fire text-6xl text-gray-300 mb-4"></i>
                                <h3 class="text-xl font-bold text-gray-600 mb-2">No Deals Found</h3>
                                <p class="text-gray-500 mb-6">Start by adding your first deal</p>
                                <a href="{{ route('admin.deals.create') }}" class="inline-block px-6 py-3 rounded-xl text-white font-semibold shadow-lg hover-lift" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);">
                                    <i class="fas fa-plus mr-2"></i>Add Deal
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
