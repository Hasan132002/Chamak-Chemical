@extends('layouts.app')

@section('title', __('My Account'))

@section('content')
    <div class="bg-gradient-to-r from-primary-500 to-blue-600 text-white py-12">
        <div class="container mx-auto px-4">
            <h1 class="text-4xl font-bold"><i class="fas fa-user-circle mr-3"></i>{{ __('My Account') }}</h1>
            <p class="text-blue-100">{{ __('Welcome back') }}, {{ auth()->user()->name }}</p>
        </div>
    </div>

    <div class="container mx-auto px-4 py-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Sidebar -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <div class="text-center mb-6">
                    <div class="w-24 h-24 gradient-primary rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-user text-white text-4xl"></i>
                    </div>
                    <h3 class="font-bold text-xl">{{ auth()->user()->name }}</h3>
                    <p class="text-gray-600 text-sm">{{ auth()->user()->email }}</p>
                </div>
                <nav class="space-y-2">
                    <a href="#" class="block px-4 py-3 bg-primary-50 text-primary-600 rounded-xl font-semibold">
                        <i class="fas fa-home mr-2"></i>{{ __('Dashboard') }}
                    </a>
                    <a href="#" class="block px-4 py-3 hover:bg-gray-50 rounded-xl">
                        <i class="fas fa-shopping-bag mr-2"></i>{{ __('My Orders') }}
                    </a>
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-3 hover:bg-gray-50 rounded-xl">
                        <i class="fas fa-user-edit mr-2"></i>{{ __('Profile') }}
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-3 hover:bg-red-50 text-red-600 rounded-xl">
                            <i class="fas fa-sign-out-alt mr-2"></i>{{ __('Logout') }}
                        </button>
                    </form>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="md:col-span-2">
                <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
                    <h2 class="text-2xl font-bold mb-6">{{ __('Recent Orders') }}</h2>
                    <div class="text-center py-12">
                        <div class="text-6xl mb-4"><i class="fas fa-box-open text-gray-300"></i></div>
                        <p class="text-gray-600">{{ __('No orders yet') }}</p>
                        <a href="{{ route('products.index') }}" class="inline-block mt-4 bg-primary-500 text-white px-6 py-3 rounded-full font-semibold hover:bg-primary-600 transition">
                            <i class="fas fa-shopping-bag mr-2"></i>{{ __('Start Shopping') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
