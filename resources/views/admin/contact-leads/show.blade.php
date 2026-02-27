@extends('admin.layout')

@section('title', 'View Lead')
@section('page-title', 'Contact Lead #' . $lead->id)
@section('page-description', 'Submitted on ' . $lead->created_at->format('d M Y, h:i A'))

@section('content')
<div class="max-w-3xl animate-slide-in">
    <div class="bg-white rounded-2xl shadow-lg p-6 sm:p-8">
        <!-- Status Badge -->
        <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
            <div>
                @if($lead->status === 'new')
                    <span class="px-3 py-1 rounded-full text-sm font-bold bg-red-100 text-red-700"><i class="fas fa-circle text-xs mr-1"></i> New</span>
                @elseif($lead->status === 'read')
                    <span class="px-3 py-1 rounded-full text-sm font-bold bg-yellow-100 text-yellow-700"><i class="fas fa-eye text-xs mr-1"></i> Read</span>
                @else
                    <span class="px-3 py-1 rounded-full text-sm font-bold bg-green-100 text-green-700"><i class="fas fa-check text-xs mr-1"></i> Replied</span>
                @endif
            </div>
            <div class="flex items-center gap-2">
                <form action="{{ route('admin.contact-leads.status', $lead) }}" method="POST" class="inline">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="replied">
                    <button type="submit" class="px-4 py-2 bg-green-500 text-white text-sm font-semibold rounded-lg hover:bg-green-600 transition">
                        <i class="fas fa-check mr-1"></i> Mark as Replied
                    </button>
                </form>
                <form action="{{ route('admin.contact-leads.destroy', $lead) }}" method="POST" class="inline" onsubmit="return confirm('Delete this lead?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-500 text-white text-sm font-semibold rounded-lg hover:bg-red-600 transition">
                        <i class="fas fa-trash mr-1"></i> Delete
                    </button>
                </form>
            </div>
        </div>

        <!-- Lead Details -->
        <div class="space-y-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Name</label>
                    <p class="text-lg font-semibold text-gray-900">{{ $lead->name }}</p>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Date</label>
                    <p class="text-lg text-gray-900">{{ $lead->created_at->format('d M Y, h:i A') }}</p>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Email</label>
                    <a href="mailto:{{ $lead->email }}" class="text-lg text-blue-600 hover:underline">{{ $lead->email }}</a>
                </div>
                @if($lead->phone)
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Phone</label>
                    <a href="tel:{{ $lead->phone }}" class="text-lg text-blue-600 hover:underline">{{ $lead->phone }}</a>
                </div>
                @endif
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Message</label>
                <div class="bg-gray-50 rounded-xl p-5 text-gray-700 leading-relaxed">
                    {{ $lead->message }}
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="mt-8 pt-6 border-t border-gray-200 flex flex-wrap gap-3">
            <a href="mailto:{{ $lead->email }}" class="px-4 py-2 bg-blue-500 text-white text-sm font-semibold rounded-lg hover:bg-blue-600 transition">
                <i class="fas fa-reply mr-1"></i> Reply via Email
            </a>
            @php $whatsappNumber = \App\Models\SiteSetting::get('whatsapp_number', '+923001234567'); @endphp
            @if($lead->phone)
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $lead->phone) }}" target="_blank" class="px-4 py-2 bg-green-500 text-white text-sm font-semibold rounded-lg hover:bg-green-600 transition">
                    <i class="fab fa-whatsapp mr-1"></i> WhatsApp
                </a>
            @endif
            <a href="{{ route('admin.contact-leads.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 text-sm font-semibold rounded-lg hover:bg-gray-300 transition">
                <i class="fas fa-arrow-left mr-1"></i> Back to All Leads
            </a>
        </div>
    </div>
</div>
@endsection
