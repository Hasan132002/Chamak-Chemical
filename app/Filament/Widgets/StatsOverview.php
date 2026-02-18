<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Dealer;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalSales = Order::sum('total_amount');
        $todayOrders = Order::whereDate('created_at', today())->count();
        $totalProducts = Product::count();
        $lowStockProducts = Product::whereColumn('stock_quantity', '<=', 'low_stock_threshold')->count();
        $pendingDealers = Dealer::where('approval_status', 'pending')->count();
        $totalCustomers = User::role('customer')->count();

        return [
            Stat::make('Total Sales', 'PKR ' . number_format($totalSales, 0))
                ->description('All time revenue')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('success')
                ->chart([7, 12, 15, 18, 22, 25, 30]),

            Stat::make('Orders Today', $todayOrders)
                ->description('New orders today')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color('info'),

            Stat::make('Total Products', $totalProducts)
                ->description($lowStockProducts . ' low stock')
                ->descriptionIcon('heroicon-m-cube')
                ->color($lowStockProducts > 0 ? 'warning' : 'success'),

            Stat::make('Pending Dealers', $pendingDealers)
                ->description('Awaiting approval')
                ->descriptionIcon('heroicon-m-user-group')
                ->color($pendingDealers > 0 ? 'warning' : 'success'),

            Stat::make('Total Customers', $totalCustomers)
                ->description('Registered customers')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),

            Stat::make('This Month', 'PKR ' . number_format(Order::whereMonth('created_at', now()->month)->sum('total_amount'), 0))
                ->description('Monthly revenue')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('success'),
        ];
    }
}
