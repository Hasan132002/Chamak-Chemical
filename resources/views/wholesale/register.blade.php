@extends('layouts.app')

@section('title', __('Become a Dealer'))

@section('content')
    <div class="bg-gradient-to-r from-primary-500 to-primary-700 text-white py-12">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl font-bold mb-4">{{ __('Become a Wholesale Dealer') }}</h1>
            <p class="text-xl">{{ __('Join our network and get special wholesale pricing') }}</p>
        </div>
    </div>

    <div class="container mx-auto px-4 py-12">
        <div class="max-w-3xl mx-auto">
            <!-- Benefits -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                <div class="bg-white rounded-lg shadow-md p-6 text-center">
                    <div class="text-4xl mb-3">💰</div>
                    <h3 class="font-bold mb-2">{{ __('Wholesale Pricing') }}</h3>
                    <p class="text-sm text-gray-600">{{ __('Up to 25% discount on bulk orders') }}</p>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6 text-center">
                    <div class="text-4xl mb-3">🎯</div>
                    <h3 class="font-bold mb-2">{{ __('Priority Support') }}</h3>
                    <p class="text-sm text-gray-600">{{ __('Dedicated account manager') }}</p>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6 text-center">
                    <div class="text-4xl mb-3">📦</div>
                    <h3 class="font-bold mb-2">{{ __('Bulk Orders') }}</h3>
                    <p class="text-sm text-gray-600">{{ __('Custom packaging available') }}</p>
                </div>
            </div>

            <!-- Registration Form -->
            <div class="bg-white rounded-lg shadow-md p-8">
                <h2 class="text-2xl font-bold mb-6">{{ __('Dealer Registration Form') }}</h2>

                <form action="{{ route('wholesale.register.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Personal Information -->
                    <h3 class="font-bold text-lg mb-4 text-primary-500">{{ __('Personal Information') }}</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium mb-2">{{ __('Full Name') }} *</label>
                            <input type="text" name="name" value="{{ old('name') }}" required
                                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                            @error('name')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2">{{ __('Email') }} *</label>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                            @error('email')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2">{{ __('Phone') }} *</label>
                            <input type="tel" name="phone" value="{{ old('phone') }}" required
                                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                            @error('phone')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2">{{ __('Password') }} *</label>
                            <input type="password" name="password" required
                                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                            @error('password')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium mb-2">{{ __('Confirm Password') }} *</label>
                            <input type="password" name="password_confirmation" required
                                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                        </div>
                    </div>

                    <!-- Business Information -->
                    <h3 class="font-bold text-lg mb-4 text-primary-500">{{ __('Business Information') }}</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium mb-2">{{ __('Business Name') }} *</label>
                            <input type="text" name="business_name" value="{{ old('business_name') }}" required
                                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                            @error('business_name')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2">{{ __('Business License') }}</label>
                            <input type="file" name="business_license" accept=".pdf,.jpg,.jpeg,.png"
                                   class="w-full px-4 py-2 border rounded-lg">
                            <p class="text-xs text-gray-500 mt-1">{{ __('PDF, JPG or PNG (Max 2MB)') }}</p>
                            @error('business_license')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2">{{ __('Tax ID / NTN') }}</label>
                            <input type="text" name="tax_id" value="{{ old('tax_id') }}"
                                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                            @error('tax_id')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium mb-2">{{ __('Business Address') }} *</label>
                            <textarea name="address" rows="3" required
                                      class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">{{ old('address') }}</textarea>
                            @error('address')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2">{{ __('City') }} *</label>
                            <input type="text" name="city" value="{{ old('city') }}" required
                                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                            @error('city')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2">{{ __('State/Province') }}</label>
                            <input type="text" name="state" value="{{ old('state') }}"
                                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2">{{ __('Postal Code') }}</label>
                            <input type="text" name="postal_code" value="{{ old('postal_code') }}"
                                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                        </div>
                    </div>

                    <!-- Submit -->
                    <div class="flex gap-4">
                        <button type="submit" class="flex-1 bg-secondary-500 hover:bg-secondary-600 text-white font-semibold py-3 rounded-lg transition">
                            {{ __('Submit Registration') }}
                        </button>
                        <a href="{{ route('home') }}" class="flex-1 text-center border-2 border-gray-300 text-gray-700 hover:border-gray-400 font-semibold py-3 rounded-lg transition">
                            {{ __('Cancel') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
