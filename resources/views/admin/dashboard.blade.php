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

        .stat-card {
            background: white;
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
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
<body class="bg-gray-50">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 bg-gradient-to-b from-primary-600 to-primary-800 text-white flex-shrink-0 hidden md:block">
            <div class="p-6">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-flask text-2xl"></i>
                    </div>
                    <div>
                        <h2 class="font-bold text-lg">Chamak</h2>
                        <p class="text-xs text-blue-200">Admin Panel</p>
                    </div>
                </div>

                <nav class="space-y-2">
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
                    <a href="{{ route('admin.settings') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
                        <i class="fas fa-cog"></i>
                        <span>Settings</span>
                    </a>
                </nav>

                <!-- View Website & Logout -->
                <div class="mt-auto space-y-3">
                    <!-- View Website Button -->
                    <a href="{{ route('home') }}" target="_blank" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg bg-green-500/20 hover:bg-green-500/30 text-white transition">
                        <i class="fas fa-globe"></i>
                        <span>View Website</span>
                        <i class="fas fa-external-link-alt ml-auto text-xs"></i>
                    </a>

                    <!-- Logout -->
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
        <main class="flex-1 overflow-y-auto">
            <!-- Top Bar -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="px-8 py-4 flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
                        <p class="text-sm text-gray-600">Welcome back, {{ auth()->user()->name }}</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <button class="relative p-2 hover:bg-gray-100 rounded-lg">
                            <i class="fas fa-bell text-xl text-gray-600"></i>
                            <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
                        </button>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-blue-600 rounded-full flex items-center justify-center text-white font-bold">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Dashboard Content -->
            <div class="p-8">
                <!-- Stats Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    @php
                        $totalSales = \App\Models\Order::sum('total_amount');
                        $todayOrders = \App\Models\Order::whereDate('created_at', today())->count();
                        $totalProducts = \App\Models\Product::count();
                        $pendingDealers = \App\Models\Dealer::where('approval_status', 'pending')->count();
                    @endphp

                    <!-- Total Sales -->
                    <div class="stat-card text-white animate-slide-in" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); animation-delay: 0.1s">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex-1">
                                <p class="text-white font-semibold text-sm mb-2 opacity-90">💰 Total Sales</p>
                                <h3 class="text-4xl font-extrabold text-white">PKR {{ number_format($totalSales, 0) }}</h3>
                            </div>
                            <div class="w-16 h-16 bg-white/30 rounded-2xl flex items-center justify-center">
                                <i class="fas fa-dollar-sign text-3xl text-white"></i>
                            </div>
                        </div>
                        <p class="text-white font-medium text-sm opacity-90"><i class="fas fa-arrow-up mr-2"></i>All time revenue</p>
                    </div>

                    <!-- Today Orders -->
                    <div class="stat-card text-white animate-slide-in" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); animation-delay: 0.2s">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex-1">
                                <p class="text-white font-semibold text-sm mb-2 opacity-90">📦 Orders Today</p>
                                <h3 class="text-4xl font-extrabold text-white">{{ $todayOrders }}</h3>
                            </div>
                            <div class="w-16 h-16 bg-white/30 rounded-2xl flex items-center justify-center">
                                <i class="fas fa-shopping-bag text-3xl text-white"></i>
                            </div>
                        </div>
                        <p class="text-white font-medium text-sm opacity-90"><i class="fas fa-calendar mr-2"></i>New orders today</p>
                    </div>

                    <!-- Total Products -->
                    <div class="stat-card text-white animate-slide-in" style="background: linear-gradient(135deg, #a855f7 0%, #9333ea 100%); animation-delay: 0.3s">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex-1">
                                <p class="text-white font-semibold text-sm mb-2 opacity-90">📦 Total Products</p>
                                <h3 class="text-4xl font-extrabold text-white">{{ $totalProducts }}</h3>
                            </div>
                            <div class="w-16 h-16 bg-white/30 rounded-2xl flex items-center justify-center">
                                <i class="fas fa-box text-3xl text-white"></i>
                            </div>
                        </div>
                        <p class="text-white font-medium text-sm opacity-90"><i class="fas fa-cube mr-2"></i>In your catalog</p>
                    </div>

                    <!-- Pending Dealers -->
                    <div class="stat-card text-white animate-slide-in" style="background: linear-gradient(135deg, #f97316 0%, #ea580c 100%); animation-delay: 0.4s">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex-1">
                                <p class="text-white font-semibold text-sm mb-2 opacity-90">👥 Pending Dealers</p>
                                <h3 class="text-4xl font-extrabold text-white">{{ $pendingDealers }}</h3>
                            </div>
                            <div class="w-16 h-16 bg-white/30 rounded-2xl flex items-center justify-center">
                                <i class="fas fa-user-clock text-3xl text-white"></i>
                            </div>
                        </div>
                        <p class="text-white font-medium text-sm opacity-90"><i class="fas fa-exclamation mr-2"></i>Need approval</p>
                    </div>
                </div>

                <!-- Charts & Tables -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                    <!-- Sales Chart -->
                    <div class="lg:col-span-2 bg-white rounded-2xl shadow-lg p-6 animate-slide-in" style="animation-delay: 0.5s">
                        <h3 class="text-xl font-bold mb-6 flex items-center text-gray-900">
                            <i class="fas fa-chart-line mr-3 text-primary-500"></i>
                            Sales Overview (Last 7 Days)
                        </h3>
                        <div style="height: 300px;">
                            <canvas id="salesChart"></canvas>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-white rounded-2xl shadow-lg p-6 animate-slide-in" style="animation-delay: 0.6s">
                        <h3 class="text-xl font-bold mb-6 flex items-center">
                            <i class="fas fa-bolt mr-3 text-secondary-500"></i>
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

                <!-- Recent Orders -->
                <div class="bg-white rounded-2xl shadow-lg p-6 animate-slide-in" style="animation-delay: 0.7s">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold flex items-center">
                            <i class="fas fa-shopping-cart mr-3 text-primary-500"></i>
                            Recent Orders
                        </h3>
                        <a href="{{ route('admin.orders.index') }}" class="text-primary-500 hover:text-primary-600 font-semibold text-sm">
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
