@extends('admin.layout')

@section('title', 'Contact Leads')
@section('page-title', 'Contact Leads')
@section('page-description', 'Messages received from the contact form')

@section('content')
<div class="animate-slide-in">
    <!-- Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm p-4 flex items-center gap-4">
            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-envelope text-blue-600 text-xl"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900">{{ \App\Models\ContactLead::count() }}</p>
                <p class="text-xs text-gray-500">Total Leads</p>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4 flex items-center gap-4">
            <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-exclamation-circle text-red-600 text-xl"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900">{{ \App\Models\ContactLead::where('status', 'new')->count() }}</p>
                <p class="text-xs text-gray-500">New (Unread)</p>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4 flex items-center gap-4">
            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-check-circle text-green-600 text-xl"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900">{{ \App\Models\ContactLead::where('status', 'replied')->count() }}</p>
                <p class="text-xs text-gray-500">Replied</p>
            </div>
        </div>
    </div>

    <!-- Leads Table -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-4 sm:px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">#</th>
                        <th class="px-4 sm:px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Name</th>
                        <th class="px-4 sm:px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase hidden md:table-cell">Email</th>
                        <th class="px-4 sm:px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase hidden lg:table-cell">Message</th>
                        <th class="px-4 sm:px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Status</th>
                        <th class="px-4 sm:px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase hidden sm:table-cell">Date</th>
                        <th class="px-4 sm:px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($leads as $lead)
                        <tr class="hover:bg-gray-50 transition {{ $lead->status === 'new' ? 'bg-blue-50/50' : '' }}">
                            <td class="px-4 sm:px-6 py-4 text-sm text-gray-500">{{ $lead->id }}</td>
                            <td class="px-4 sm:px-6 py-4">
                                <div class="flex items-center gap-2">
                                    @if($lead->status === 'new')
                                        <span class="w-2 h-2 bg-red-500 rounded-full flex-shrink-0"></span>
                                    @endif
                                    <span class="font-semibold text-sm text-gray-900">{{ $lead->name }}</span>
                                </div>
                            </td>
                            <td class="px-4 sm:px-6 py-4 text-sm text-gray-600 hidden md:table-cell">{{ $lead->email }}</td>
                            <td class="px-4 sm:px-6 py-4 text-sm text-gray-600 hidden lg:table-cell">{{ Str::limit($lead->message, 50) }}</td>
                            <td class="px-4 sm:px-6 py-4">
                                @if($lead->status === 'new')
                                    <span class="px-2 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700">New</span>
                                @elseif($lead->status === 'read')
                                    <span class="px-2 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-700">Read</span>
                                @else
                                    <span class="px-2 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">Replied</span>
                                @endif
                            </td>
                            <td class="px-4 sm:px-6 py-4 text-sm text-gray-500 hidden sm:table-cell">{{ $lead->created_at->format('d M Y') }}</td>
                            <td class="px-4 sm:px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.contact-leads.show', $lead) }}" class="p-2 hover:bg-blue-100 rounded-lg text-blue-600 transition" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form action="{{ route('admin.contact-leads.destroy', $lead) }}" method="POST" onsubmit="return confirm('Delete this lead?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 hover:bg-red-100 rounded-lg text-red-600 transition" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                <i class="fas fa-inbox text-4xl mb-3 text-gray-300"></i>
                                <p class="font-semibold">No contact leads yet</p>
                                <p class="text-sm">Messages from the contact form will appear here</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($leads->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $leads->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
