@extends('admin.layout')

@section('title', 'Reviews Management')
@section('page-title', 'Product Reviews')
@section('page-description', 'Manage customer product reviews')

@section('content')
<div class="animate-slide-in">
    <!-- Header Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-lg p-6 hover-lift">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 font-semibold mb-1">Total Reviews</p>
                    <h3 class="text-3xl font-bold text-gray-900">1,234</h3>
                </div>
                <div class="w-14 h-14 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
                    <i class="fas fa-star text-2xl text-white"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 hover-lift">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 font-semibold mb-1">Pending Review</p>
                    <h3 class="text-3xl font-bold text-orange-600">23</h3>
                </div>
                <div class="w-14 h-14 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                    <i class="fas fa-clock text-2xl text-white"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 hover-lift">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 font-semibold mb-1">Average Rating</p>
                    <h3 class="text-3xl font-bold text-yellow-600">4.5</h3>
                </div>
                <div class="w-14 h-14 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, #eab308 0%, #ca8a04 100%);">
                    <i class="fas fa-star-half-alt text-2xl text-white"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 hover-lift">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 font-semibold mb-1">Approved</p>
                    <h3 class="text-3xl font-bold text-green-600">1,211</h3>
                </div>
                <div class="w-14 h-14 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                    <i class="fas fa-check-circle text-2xl text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Reviews List -->
    <div class="bg-white rounded-2xl shadow-lg p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-900 flex items-center">
                <i class="fas fa-comments mr-3 text-blue-500"></i>
                Recent Reviews
            </h2>
            <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                <option>All Reviews</option>
                <option>Pending</option>
                <option>Approved</option>
                <option>Rejected</option>
            </select>
        </div>

        <div class="space-y-4">
            @for($i = 1; $i <= 5; $i++)
                <div class="border border-gray-200 rounded-xl p-6 hover:bg-gray-50 transition">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center text-white font-bold" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
                                U{{ $i }}
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900">Customer Name {{ $i }}</h4>
                                <p class="text-sm text-gray-600">Product: Sample Product {{ $i }}</p>
                                <div class="flex items-center gap-1 mt-1">
                                    @for($j = 1; $j <= 5; $j++)
                                        <i class="fas fa-star text-yellow-400 text-sm"></i>
                                    @endfor
                                    <span class="ml-2 text-sm text-gray-600">{{ now()->subDays($i)->format('M d, Y') }}</span>
                                </div>
                            </div>
                        </div>

                        <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-bold">
                            Pending
                        </span>
                    </div>

                    <p class="text-gray-700 mb-4">This is a sample review text. The product quality is excellent and delivery was fast. Highly recommended!</p>

                    <div class="flex gap-2">
                        <button class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white text-sm font-semibold rounded-lg transition">
                            <i class="fas fa-check mr-1"></i>Approve
                        </button>
                        <button class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-lg transition">
                            <i class="fas fa-times mr-1"></i>Reject
                        </button>
                        <button class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-semibold rounded-lg transition">
                            <i class="fas fa-reply mr-1"></i>Reply
                        </button>
                    </div>
                </div>
            @endfor
        </div>
    </div>
</div>
@endsection
