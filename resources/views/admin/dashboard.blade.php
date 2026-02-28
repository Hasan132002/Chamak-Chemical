<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chamak Chemicals - Admin Dashboard</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Poppins', sans-serif; }
        [x-cloak] { display: none !important; }

        .stat-card {
            background: white;
            border-radius: 0.75rem;
            padding: 0.875rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        @media (min-width: 640px) {
            .stat-card { padding: 1.25rem; border-radius: 1rem; }
        }
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -5px rgba(0, 0, 0, 0.1);
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-slide-in {
            animation: slideIn 0.5s ease-out forwards;
        }
    </style>
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
        <aside class="fixed inset-y-0 left-0 z-50 w-64 bg-gradient-to-b from-primary-600 to-primary-800 text-white flex-shrink-0 transform transition-transform duration-300 md:relative md:translate-x-0"
               :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'">
            <div class="p-6 h-full flex flex-col overflow-y-auto">
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                            <i class="fas fa-flask text-2xl"></i>
                        </div>
                        <div>
                            <h2 class="font-bold text-lg">Chamak</h2>
                            <p class="text-xs text-blue-200">Admin Panel</p>
                        </div>
                    </div>
                    <button @click="sidebarOpen = false" class="md:hidden p-2 rounded-lg hover:bg-white/10 text-white transition">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>

                <nav class="space-y-2 flex-1">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-white/20 backdrop-blur">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('admin.products.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
                        <i class="fas fa-box"></i>
                        <span>Products</span>
                    </a>
                    <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
                        <i class="fas fa-th-large"></i>
                        <span>Categories</span>
                    </a>
                    <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
                        <i class="fas fa-shopping-cart"></i>
                        <span>Orders</span>
                        @php $pendingOrders = \App\Models\Order::where('status', 'pending')->count(); @endphp
                        @if($pendingOrders > 0)
                            <span class="ml-auto bg-red-500 px-2 py-1 rounded-full text-xs">{{ $pendingOrders }}</span>
                        @endif
                    </a>
                    <a href="{{ route('admin.dealers.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
                        <i class="fas fa-handshake"></i>
                        <span>Dealers</span>
                        @php $pendingDealers = \App\Models\Dealer::where('approval_status', 'pending')->count(); @endphp
                        @if($pendingDealers > 0)
                            <span class="ml-auto bg-orange-500 px-2 py-1 rounded-full text-xs">{{ $pendingDealers }}</span>
                        @endif
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
                        <i class="fas fa-users"></i>
                        <span>Users</span>
                    </a>
                    <a href="{{ route('admin.reports') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
                        <i class="fas fa-chart-bar"></i>
                        <span>Reports</span>
                    </a>
                    <a href="{{ route('admin.deals.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
                        <i class="fas fa-fire"></i>
                        <span>Deals</span>
                    </a>
                    <a href="{{ route('admin.banners.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
                        <i class="fas fa-images"></i>
                        <span>Banners</span>
                    </a>
                    <a href="{{ route('admin.settings.edit') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
                        <i class="fas fa-cog"></i>
                        <span>Settings</span>
                    </a>
                </nav>

                <!-- View Website & Logout -->
                <div class="mt-auto space-y-3 pt-4">
                    <a href="{{ route('home') }}" target="_blank" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg bg-green-500/20 hover:bg-green-500/30 text-white transition">
                        <i class="fas fa-globe"></i>
                        <span>View Website</span>
                        <i class="fas fa-external-link-alt ml-auto text-xs"></i>
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg bg-red-500/20 hover:bg-red-500/30 transition">
                            <i class="fas fa-sign-out-alt"></i>
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
                            <h1 class="text-lg sm:text-2xl font-bold text-gray-900">Dashboard</h1>
                            <p class="text-xs sm:text-sm text-gray-600">Welcome back, {{ auth()->user()->name }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 sm:gap-4">
                        <button class="relative p-2 hover:bg-gray-100 rounded-lg">
                            <i class="fas fa-bell text-lg sm:text-xl text-gray-600"></i>
                            <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
                        </button>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-br from-primary-500 to-blue-600 rounded-full flex items-center justify-center text-white font-bold text-sm sm:text-base">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Dashboard Content -->
            <div class="p-4 sm:p-6 lg:p-8">
                <!-- Stats Grid -->
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-4 sm:mb-6">
                    @php
                        $totalSales = \App\Models\Order::sum('total_amount');
                        $todayOrders = \App\Models\Order::whereDate('created_at', today())->count();
                        $totalProducts = \App\Models\Product::count();
                        $pendingDealers = \App\Models\Dealer::where('approval_status', 'pending')->count();
                    @endphp

                    <!-- Total Sales -->
                    <div class="stat-card text-white animate-slide-in" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); animation-delay: 0.1s">
                        <div class="flex items-center justify-between mb-2 sm:mb-3">
                            <div class="flex-1">
                                <p class="text-white font-semibold text-xs sm:text-sm mb-1 opacity-90">Total Sales</p>
                                <h3 class="text-lg sm:text-2xl font-extrabold text-white">PKR {{ number_format($totalSales, 0) }}</h3>
                            </div>
                            <div class="w-10 h-10 sm:w-14 sm:h-14 bg-white/30 rounded-xl flex items-center justify-center">
                                <i class="fas fa-dollar-sign text-lg sm:text-2xl text-white"></i>
                            </div>
                        </div>
                        <p class="text-white font-medium text-xs opacity-80">All time revenue</p>
                    </div>

                    <!-- Today Orders -->
                    <div class="stat-card text-white animate-slide-in" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); animation-delay: 0.2s">
                        <div class="flex items-center justify-between mb-2 sm:mb-3">
                            <div class="flex-1">
                                <p class="text-white font-semibold text-xs sm:text-sm mb-1 opacity-90">Orders Today</p>
                                <h3 class="text-lg sm:text-2xl font-extrabold text-white">{{ $todayOrders }}</h3>
                            </div>
                            <div class="w-10 h-10 sm:w-14 sm:h-14 bg-white/30 rounded-xl flex items-center justify-center">
                                <i class="fas fa-shopping-bag text-lg sm:text-2xl text-white"></i>
                            </div>
                        </div>
                        <p class="text-white font-medium text-xs opacity-80">New orders today</p>
                    </div>

                    <!-- Total Products -->
                    <div class="stat-card text-white animate-slide-in" style="background: linear-gradient(135deg, #a855f7 0%, #9333ea 100%); animation-delay: 0.3s">
                        <div class="flex items-center justify-between mb-2 sm:mb-3">
                            <div class="flex-1">
                                <p class="text-white font-semibold text-xs sm:text-sm mb-1 opacity-90">Total Products</p>
                                <h3 class="text-lg sm:text-2xl font-extrabold text-white">{{ $totalProducts }}</h3>
                            </div>
                            <div class="w-10 h-10 sm:w-14 sm:h-14 bg-white/30 rounded-xl flex items-center justify-center">
                                <i class="fas fa-box text-lg sm:text-2xl text-white"></i>
                            </div>
                        </div>
                        <p class="text-white font-medium text-xs opacity-80">In your catalog</p>
                    </div>

                    <!-- Pending Dealers -->
                    <div class="stat-card text-white animate-slide-in" style="background: linear-gradient(135deg, #f97316 0%, #ea580c 100%); animation-delay: 0.4s">
                        <div class="flex items-center justify-between mb-2 sm:mb-3">
                            <div class="flex-1">
                                <p class="text-white font-semibold text-xs sm:text-sm mb-1 opacity-90">Pending Dealers</p>
                                <h3 class="text-lg sm:text-2xl font-extrabold text-white">{{ $pendingDealers }}</h3>
                            </div>
                            <div class="w-10 h-10 sm:w-14 sm:h-14 bg-white/30 rounded-xl flex items-center justify-center">
                                <i class="fas fa-user-clock text-lg sm:text-2xl text-white"></i>
                            </div>
                        </div>
                        <p class="text-white font-medium text-xs opacity-80">Need approval</p>
                    </div>
                </div>

                <!-- Charts & Tables -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-8 mb-6 sm:mb-8">
                    <!-- Sales Chart -->
                    <div class="lg:col-span-2 bg-white rounded-2xl shadow-lg p-4 sm:p-6 animate-slide-in" style="animation-delay: 0.5s">
                        <h3 class="text-lg sm:text-xl font-bold mb-4 sm:mb-6 flex items-center text-gray-900">
                            <i class="fas fa-chart-line mr-3 text-primary-500"></i>
                            Sales Overview (Last 7 Days)
                        </h3>
                        <div style="height: 250px;" class="sm:h-[300px]">
                            <canvas id="salesChart"></canvas>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-white rounded-2xl shadow-lg p-4 sm:p-6 animate-slide-in" style="animation-delay: 0.6s">
                        <h3 class="text-lg sm:text-xl font-bold mb-4 sm:mb-6 flex items-center">
                            <i class="fas fa-bolt mr-2 sm:mr-3 text-secondary-500"></i>
                            Quick Actions
                        </h3>
                        <div class="space-y-3">
                            <a href="{{ route('admin.products.create') }}" class="block px-4 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-xl hover:shadow-lg transition">
                                <i class="fas fa-plus mr-2"></i> Add New Product
                            </a>
                            <a href="{{ route('admin.orders.index') }}" class="block px-4 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-xl hover:shadow-lg transition">
                                <i class="fas fa-eye mr-2"></i> View All Orders
                            </a>
                            <a href="{{ route('admin.dealers.index') }}" class="block px-4 py-3 bg-gradient-to-r from-orange-500 to-orange-600 text-white rounded-xl hover:shadow-lg transition">
                                <i class="fas fa-check mr-2"></i> Approve Dealers
                            </a>
                            <a href="{{ route('home') }}" target="_blank" class="block px-4 py-3 bg-gradient-to-r from-purple-500 to-purple-600 text-white rounded-xl hover:shadow-lg transition">
                                <i class="fas fa-globe mr-2"></i> View Website
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Low Stock Alerts -->
                @php
                    $lowStockProducts = \App\Models\Product::whereColumn('stock_quantity', '<=', 'low_stock_threshold')
                        ->with('translations')
                        ->limit(5)
                        ->get();
                @endphp

                @if($lowStockProducts->count() > 0)
                <div class="bg-white rounded-2xl shadow-lg p-4 sm:p-6 mb-4 sm:mb-8 border-l-4 border-red-500 animate-slide-in" style="animation-delay: 0.65s">
                    <div class="flex items-center justify-between mb-4 sm:mb-6">
                        <h3 class="text-base sm:text-xl font-bold flex items-center text-red-600">
                            <i class="fas fa-exclamation-triangle mr-2 sm:mr-3 animate-pulse"></i>
                            Low Stock Alerts
                        </h3>
                        <a href="{{ route('admin.products.index') }}" class="text-red-500 hover:text-red-600 font-semibold text-xs sm:text-sm">
                            View All <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>

                    <div class="space-y-3">
                        @foreach($lowStockProducts as $lowStock)
                            <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg">
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-900">{{ $lowStock->translations->where('locale', 'en')->first()->name ?? 'N/A' }}</p>
                                    <p class="text-xs text-gray-600">SKU: {{ $lowStock->sku }}</p>
                                </div>
                                <div class="text-right">
                                    <span class="px-3 py-1 bg-red-500 text-white rounded-full text-xs font-bold">
                                        {{ $lowStock->stock_quantity }} left
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Recent Orders -->
                <div class="bg-white rounded-2xl shadow-lg p-4 sm:p-6 animate-slide-in" style="animation-delay: 0.7s">
                    <div class="flex items-center justify-between mb-4 sm:mb-6">
                        <h3 class="text-base sm:text-xl font-bold flex items-center">
                            <i class="fas fa-shopping-cart mr-2 sm:mr-3 text-primary-500"></i>
                            Recent Orders
                        </h3>
                        <a href="{{ route('admin.orders.index') }}" class="text-primary-500 hover:text-primary-600 font-semibold text-xs sm:text-sm">
                            View All <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Order #</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Customer</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Amount</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Date</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach(\App\Models\Order::latest()->take(10)->get() as $order)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 font-mono text-sm">{{ $order->order_number }}</td>
                                        <td class="px-4 py-3 text-sm">{{ $order->user->name }}</td>
                                        <td class="px-4 py-3 text-sm font-bold">PKR {{ number_format($order->total_amount, 0) }}</td>
                                        <td class="px-4 py-3">
                                            <span class="px-3 py-1 rounded-full text-xs font-bold
                                                {{ $order->status === 'delivered' ? 'bg-green-100 text-green-700' :
                                                   ($order->status === 'cancelled' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-600">{{ $order->created_at->format('d M, Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Sales Chart
        const ctx = document.getElementById('salesChart').getContext('2d');

        // Sample sales data (you can replace with real data from backend)
        const chartLabels = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
        const chartData = [2500, 3200, 2800, 4100, 3600, 5200, 4800];

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: chartLabels,
                datasets: [{
                    label: 'Sales (PKR)',
                    data: chartData,
                    borderColor: '#1e3a8a',
                    backgroundColor: 'rgba(30, 58, 138, 0.2)',
                    borderWidth: 3,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#1e3a8a',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        labels: {
                            font: { size: 14, weight: 'bold' },
                            color: '#1f2937'
                        }
                    },
                    tooltip: {
                        backgroundColor: '#1e3a8a',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        padding: 12,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return 'PKR ' + context.parsed.y.toLocaleString();
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            font: { size: 12, weight: '600' },
                            color: '#4b5563',
                            callback: function(value) {
                                return 'PKR ' + value.toLocaleString();
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        ticks: {
                            font: { size: 12, weight: '600' },
                            color: '#4b5563'
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
