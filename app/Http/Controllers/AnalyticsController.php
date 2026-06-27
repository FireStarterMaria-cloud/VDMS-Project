<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Sale;
use App\Models\Customer;
use App\Models\Branch;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Traits\ShowroomScoped;

class AnalyticsController extends Controller
{
    use ShowroomScoped;

    public function index()
    {
        $user = Auth::user();
        if (!$user->isHO() && !$user->isChairwoman()) abort(403);

        // Showroom scope for branches
        $branchIds = $this->getBranches()->pluck('id');

        $totalVehicles  = Vehicle::whereIn('branch_id', $branchIds)->count();
        $totalSales     = Sale::whereIn('branch_id', $branchIds)->count();
        $totalCustomers = Customer::whereIn('branch_id', $branchIds)->count();
        $totalRevenue   = Sale::whereIn('branch_id', $branchIds)->where('status', 'completed')->sum('final_price');

        $vehiclesByBranch = Branch::select(
            'branches.city',
            DB::raw('COUNT(vehicles.id) as total'),
            DB::raw('SUM(CASE WHEN vehicles.status = "available" THEN 1 ELSE 0 END) as available'),
            DB::raw('SUM(CASE WHEN vehicles.status = "sold" THEN 1 ELSE 0 END) as sold')
        )->leftJoin('vehicles', 'branches.id', '=', 'vehicles.branch_id')
         ->whereIn('branches.id', $branchIds)
         ->groupBy('branches.id', 'branches.city')
         ->get();

        $salesByBranch = Branch::select(
            'branches.city',
            DB::raw('COUNT(sales.id) as total_sales'),
            DB::raw('SUM(sales.final_price) as total_revenue')
        )->leftJoin('sales', 'branches.id', '=', 'sales.branch_id')
         ->whereIn('branches.id', $branchIds)
         ->groupBy('branches.id', 'branches.city')
         ->get();

        $recentSales = Sale::with(['vehicle', 'customer', 'branch'])
            ->whereIn('branch_id', $branchIds)
            ->latest()->take(10)->get();

        $monthlySales = Sale::select(
            DB::raw("DATE_FORMAT(sale_date, '%b %Y') as month"),
            DB::raw('COUNT(*) as count'),
            DB::raw('SUM(final_price) as revenue')
        )->whereIn('branch_id', $branchIds)
         ->where('sale_date', '>=', now()->subMonths(6))
         ->groupBy(DB::raw("DATE_FORMAT(sale_date, '%Y-%m')"), 'month')
         ->orderBy(DB::raw("DATE_FORMAT(sale_date, '%Y-%m')"))
         ->get();

        $statusDistribution = Vehicle::select('status', DB::raw('COUNT(*) as count'))
            ->whereIn('branch_id', $branchIds)
            ->groupBy('status')
            ->get();

        return view('analytics.index', compact(
            'totalVehicles', 'totalSales', 'totalCustomers',
            'totalRevenue', 'vehiclesByBranch', 'salesByBranch', 'recentSales',
            'monthlySales', 'statusDistribution'
        ));
    }
}