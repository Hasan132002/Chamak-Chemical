@extends('admin.layout')

@section('title', 'Users')
@section('page-title', 'Users Management')
@section('page-description', 'Manage system users and roles')

@section('content')
<div class="animate-slide-in">
    <!-- Header with Add Button -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-4 sm:mb-6 gap-3">
        <div>
            <h2 class="text-xl sm:text-2xl font-bold text-gray-900 flex items-center">
                <i class="fas fa-users text-blue-500 mr-2 sm:mr-3"></i>
                All Users
            </h2>
            <p class="text-xs sm:text-sm text-gray-600 mt-1">Manage customer and admin accounts</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="px-4 sm:px-6 py-2 sm:py-3 rounded-xl text-white font-semibold shadow-lg hover-lift text-sm sm:text-base text-center" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
            <i class="fas fa-plus mr-2"></i>Add New User
        </a>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="p-4 sm:p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-base sm:text-xl font-bold text-gray-900">User List</h3>
                <div class="flex gap-2">
                    <button class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm font-semibold transition">
                        <i class="fas fa-filter mr-2"></i>Filter
                    </button>
                    <button class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm font-semibold transition">
                        <i class="fas fa-download mr-2"></i>Export
                    </button>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-blue-500 to-blue-600 text-white">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-bold">Name</th>
                        <th class="px-6 py-4 text-left text-sm font-bold">Email</th>
                        <th class="px-6 py-4 text-left text-sm font-bold">Phone</th>
                        <th class="px-6 py-4 text-left text-sm font-bold">Role</th>
                        <th class="px-6 py-4 text-left text-sm font-bold">Status</th>
                        <th class="px-6 py-4 text-left text-sm font-bold">Joined</th>
                        <th class="px-6 py-4 text-center text-sm font-bold">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @php
                        $users = \App\Models\User::latest()->paginate(20);
                    @endphp

                    @forelse($users as $user)
                        <tr class="hover:bg-blue-50 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center text-white font-bold" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-900">{{ $user->name }}</p>
                                        <p class="text-xs text-gray-500">ID: #{{ $user->id }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                {{ $user->email }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                {{ $user->phone ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-bold">
                                    {{ $user->getRoleNames()->first() ?? 'Customer' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">
                                    <i class="fas fa-circle text-green-500 mr-1" style="font-size: 6px;"></i>Active
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $user->created_at->format('d M, Y') }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="px-3 py-2 bg-blue-500 hover:bg-blue-600 text-white text-xs font-semibold rounded-lg transition">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if($user->id !== auth()->id())
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-2 bg-red-500 hover:bg-red-600 text-white text-xs font-semibold rounded-lg transition">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-16 text-center">
                                <i class="fas fa-users text-6xl text-gray-300 mb-4"></i>
                                <h3 class="text-xl font-bold text-gray-600 mb-2">No Users Found</h3>
                                <p class="text-gray-500">Users will appear here</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($users->hasPages())
            <div class="p-6 border-t border-gray-200">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
