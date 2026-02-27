<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - Chamak Chemicals</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Poppins', sans-serif; }
        [x-cloak] { display: none !important; }

        @keyframes slideIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-slide-in {
            animation: slideIn 0.5s ease-out forwards;
        }

        .hover-lift {
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .hover-lift:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
    </style>

    @stack('styles')
</head>
<body class="bg-gray-50" x-data="{ sidebarOpen: false }">
    <div class="flex h-screen overflow-hidden">

        <!-- Mobile Sidebar Overlay -->
        <div x-show="sidebarOpen" x-cloak
             x-transition:enter="transition-opacity ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="sidebarOpen = false"
             class="fixed inset-0 bg-black/50 z-40 md:hidden"></div>

        <!-- Sidebar -->
        <aside class="fixed inset-y-0 left-0 z-50 w-64 flex-shrink-0 transform transition-transform duration-300 md:relative md:translate-x-0"
               :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'"
               style="background: linear-gradient(180deg, #1e3a8a 0%, #1e40af 100%);">
            <div class="p-6 h-full flex flex-col overflow-y-auto">
                <!-- Logo & Close Button -->
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                            <i class="fas fa-flask text-2xl text-white"></i>
                        </div>
                        <div>
                            <h2 class="font-bold text-lg text-white">Chamak</h2>
                            <p class="text-xs text-blue-200">Admin Panel</p>
                        </div>
                    </div>
                    <!-- Close button for mobile -->
                    <button @click="sidebarOpen = false" class="md:hidden p-2 rounded-lg hover:bg-white/10 text-white transition">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>

                <!-- Navigation -->
                <nav class="space-y-2 flex-1">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-white {{ request()->routeIs('admin.dashboard') ? 'bg-white/20' : 'hover:bg-white/10' }} transition">
                        <i class="fas fa-home w-5"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('admin.products.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-white {{ request()->routeIs('admin.products.*') ? 'bg-white/20' : 'hover:bg-white/10' }} transition">
                        <i class="fas fa-box w-5"></i>
                        <span>Products</span>
                    </a>
                    <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-white {{ request()->routeIs('admin.categories.*') ? 'bg-white/20' : 'hover:bg-white/10' }} transition">
                        <i class="fas fa-th-large w-5"></i>
                        <span>Categories</span>
                    </a>
                    <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-white {{ request()->routeIs('admin.orders.*') ? 'bg-white/20' : 'hover:bg-white/10' }} transition">
                        <i class="fas fa-shopping-cart w-5"></i>
                        <span>Orders</span>
                        @php $pendingOrders = \App\Models\Order::where('status', 'pending')->count(); @endphp
                        @if($pendingOrders > 0)
                            <span class="ml-auto bg-red-500 px-2 py-1 rounded-full text-xs font-bold">{{ $pendingOrders }}</span>
                        @endif
                    </a>
                    <a href="{{ route('admin.dealers.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-white {{ request()->routeIs('admin.dealers.*') ? 'bg-white/20' : 'hover:bg-white/10' }} transition">
                        <i class="fas fa-handshake w-5"></i>
                        <span>Dealers</span>
                        @php $pendingDealers = \App\Models\Dealer::where('approval_status', 'pending')->count(); @endphp
                        @if($pendingDealers > 0)
                            <span class="ml-auto bg-orange-500 px-2 py-1 rounded-full text-xs font-bold">{{ $pendingDealers }}</span>
                        @endif
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-white {{ request()->routeIs('admin.users.*') ? 'bg-white/20' : 'hover:bg-white/10' }} transition">
                        <i class="fas fa-users w-5"></i>
                        <span>Users</span>
                    </a>
                    <a href="{{ route('admin.reports') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-white {{ request()->routeIs('admin.reports') ? 'bg-white/20' : 'hover:bg-white/10' }} transition">
                        <i class="fas fa-chart-line w-5"></i>
                        <span>Reports</span>
                    </a>
                    <a href="{{ route('admin.blog.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-white {{ request()->routeIs('admin.blog.*') ? 'bg-white/20' : 'hover:bg-white/10' }} transition">
                        <i class="fas fa-blog w-5"></i>
                        <span>Blog</span>
                    </a>
                    <a href="{{ route('admin.coupons.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-white {{ request()->routeIs('admin.coupons.*') ? 'bg-white/20' : 'hover:bg-white/10' }} transition">
                        <i class="fas fa-ticket-alt w-5"></i>
                        <span>Coupons</span>
                    </a>
                    <a href="{{ route('admin.reviews.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-white {{ request()->routeIs('admin.reviews.*') ? 'bg-white/20' : 'hover:bg-white/10' }} transition">
                        <i class="fas fa-star w-5"></i>
                        <span>Reviews</span>
                    </a>
                    <a href="{{ route('admin.deals.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-white {{ request()->routeIs('admin.deals.*') ? 'bg-white/20' : 'hover:bg-white/10' }} transition">
                        <i class="fas fa-fire w-5"></i>
                        <span>Deals</span>
                    </a>
                    <a href="{{ route('admin.banners.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-white {{ request()->routeIs('admin.banners.*') ? 'bg-white/20' : 'hover:bg-white/10' }} transition">
                        <i class="fas fa-images w-5"></i>
                        <span>Banners</span>
                    </a>
                    <a href="{{ route('admin.settings.edit') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-white {{ request()->routeIs('admin.settings.*') ? 'bg-white/20' : 'hover:bg-white/10' }} transition">
                        <i class="fas fa-cog w-5"></i>
                        <span>Settings</span>
                    </a>
                </nav>

                <!-- View Website & Logout -->
                <div class="mt-auto space-y-3 pt-4">
                    <!-- View Website Button -->
                    <a href="{{ route('home') }}" target="_blank" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg bg-green-500/20 hover:bg-green-500/30 text-white transition">
                        <i class="fas fa-globe w-5"></i>
                        <span>View Website</span>
                        <i class="fas fa-external-link-alt ml-auto text-xs"></i>
                    </a>

                    <!-- Logout -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg bg-red-500/20 hover:bg-red-500/30 text-white transition">
                            <i class="fas fa-sign-out-alt w-5"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto w-full">
            <!-- Top Bar -->
            <header class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-10">
                <div class="px-4 sm:px-6 lg:px-8 py-3 sm:py-4 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <!-- Mobile Hamburger Button -->
                        <button @click="sidebarOpen = true" class="md:hidden p-2 rounded-lg hover:bg-gray-100 transition" aria-label="Open sidebar">
                            <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>
                        <div>
                            <h1 class="text-lg sm:text-2xl font-bold text-gray-900">@yield('page-title', 'Dashboard')</h1>
                            <p class="text-xs sm:text-sm text-gray-600 hidden sm:block">@yield('page-description', 'Manage your e-commerce platform')</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 sm:gap-4">
                        <!-- Notifications -->
                        <a href="{{ route('admin.notifications') }}" class="relative p-2 hover:bg-gray-100 rounded-lg transition">
                            <i class="fas fa-bell text-lg sm:text-xl text-gray-600"></i>
                            @php $notificationCount = 3; @endphp
                            @if($notificationCount > 0)
                                <span class="absolute top-0 right-0 bg-red-500 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">{{ $notificationCount }}</span>
                            @endif
                        </a>

                        <!-- User -->
                        <div class="flex items-center gap-2 sm:gap-3">
                            <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full flex items-center justify-center text-white font-bold text-sm sm:text-base" style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                            <div class="hidden lg:block">
                                <p class="text-sm font-semibold text-gray-900">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500">{{ auth()->user()->getRoleNames()->first() ?? 'Admin' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <div class="p-4 sm:p-6 lg:p-8">
                <!-- Success/Error Messages -->
                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 px-4 sm:px-6 py-3 sm:py-4 rounded-lg mb-4 sm:mb-6 animate__animated animate__fadeIn">
                        <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 px-4 sm:px-6 py-3 sm:py-4 rounded-lg mb-4 sm:mb-6 animate__animated animate__fadeIn">
                        <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    @stack('scripts')
</body>
</html>
