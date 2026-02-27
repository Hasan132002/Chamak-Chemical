@extends('admin.layout')

@section('title', 'Change Password')
@section('page-title', 'Change Password')
@section('page-description', 'Update your account password')

@section('content')
<div class="animate-slide-in max-w-xl">
    @if($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 px-6 py-4 rounded-lg mb-6">
            <div class="font-bold mb-2"><i class="fas fa-exclamation-triangle mr-2"></i>Please fix the following errors:</div>
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-lg p-6 sm:p-8">
        <div class="flex items-center gap-4 mb-8">
            <div class="w-14 h-14 rounded-xl flex items-center justify-center text-white text-2xl font-bold" style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);">
                <i class="fas fa-key"></i>
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-900">Change Password</h2>
                <p class="text-sm text-gray-500">{{ auth()->user()->name }} &mdash; {{ auth()->user()->email }}</p>
            </div>
        </div>

        <form action="{{ route('admin.password.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Current Password *</label>
                    <div class="relative">
                        <input type="password" name="current_password" required
                               class="w-full px-4 py-3 pl-11 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-blue-500 transition"
                               placeholder="Enter current password">
                        <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">New Password *</label>
                    <div class="relative">
                        <input type="password" name="password" required
                               class="w-full px-4 py-3 pl-11 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-blue-500 transition"
                               placeholder="Enter new password (min 8 characters)">
                        <i class="fas fa-key absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Confirm New Password *</label>
                    <div class="relative">
                        <input type="password" name="password_confirmation" required
                               class="w-full px-4 py-3 pl-11 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-blue-500 transition"
                               placeholder="Confirm new password">
                        <i class="fas fa-check-double absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    </div>
                </div>
            </div>

            <button type="submit" class="w-full mt-8 py-4 rounded-xl text-white font-bold text-lg shadow-lg hover-lift transition" style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);">
                <i class="fas fa-save mr-2"></i>Update Password
            </button>
        </form>
    </div>
</div>
@endsection
