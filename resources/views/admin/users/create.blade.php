@extends('admin.layout')

@section('title', 'Create User')
@section('page-title', 'Create New User')
@section('page-description', 'Add a new user to the system')

@section('content')
<div class="max-w-3xl animate-slide-in">
    <!-- Back Button -->
    <a href="{{ route('admin.users.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-semibold mb-6">
        <i class="fas fa-arrow-left mr-2"></i>Back to Users
    </a>

    <form action="{{ route('admin.users.store') }}" method="POST" class="bg-white rounded-2xl shadow-lg p-8">
        @csrf

        <div class="space-y-6">
            <!-- Name -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Full Name <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" value="{{ old('name') }}" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Email Address <span class="text-red-500">*</span>
                </label>
                <input type="email" name="email" value="{{ old('email') }}" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror">
                @error('email')
                    <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                @enderror
            </div>

            <!-- Phone -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Phone Number
                </label>
                <input type="text" name="phone" value="{{ old('phone') }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <!-- Password -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Password <span class="text-red-500">*</span>
                </label>
                <input type="password" name="password" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password') border-red-500 @enderror">
                <p class="text-xs text-gray-500 mt-1">Minimum 8 characters</p>
                @error('password')
                    <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                @enderror
            </div>

            <!-- Password Confirmation -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Confirm Password <span class="text-red-500">*</span>
                </label>
                <input type="password" name="password_confirmation" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <!-- Role -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    User Role <span class="text-red-500">*</span>
                </label>
                <select name="role" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="customer">Customer</option>
                    <option value="admin">Admin</option>
                    <option value="manager">Manager</option>
                    <option value="staff">Staff</option>
                </select>
            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="flex gap-4 mt-8">
            <button type="submit" class="flex-1 px-6 py-4 rounded-xl text-white font-bold text-lg shadow-lg hover-lift" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                <i class="fas fa-check mr-2"></i>Create User
            </button>
            <a href="{{ route('admin.users.index') }}" class="flex-1 px-6 py-4 bg-gray-200 hover:bg-gray-300 rounded-xl text-gray-700 font-bold text-lg text-center transition">
                <i class="fas fa-times mr-2"></i>Cancel
            </a>
        </div>
    </form>
</div>
@endsection
