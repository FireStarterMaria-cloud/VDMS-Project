<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Sale;
use App\Models\Customer;
use App\Models\Branch;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AnalyticsController extends Controller
{
    public function index()
    {
        if (!Auth::user()->isHO()) abort(403);

        $totalVehicles  = Vehicle::count();
        $totalSales     = Sale::count();
        $totalCustomers = Customer::count();
        $totalRevenue   = Sale::where('status', 'completed')->sum('final_price');

        $vehiclesByBranch = Branch::select(
            'branches.city',
            DB::raw('COUNT(vehicles.id) as total'),
            DB::raw('SUM(CASE WHEN vehicles.status = "available" THEN 1 ELSE 0 END) as available'),
            DB::raw('SUM(CASE WHEN vehicles.status = "sold" THEN 1 ELSE 0 END) as sold')
        )->leftJoin('vehicles', 'branches.id', '=', 'vehicles.branch_id')
         ->groupBy('branches.id', 'branches.city')
         ->get();

        $salesByBranch = Branch::select(
            'branches.city',
            DB::raw('COUNT(sales.id) as total_sales'),
            DB::raw('SUM(sales.final_price) as total_revenue')
        )->leftJoin('sales', 'branches.id', '=', 'sales.branch_id')
         ->groupBy('branches.id', 'branches.city')
         ->get();

        $recentSales = Sale::with(['vehicle', 'customer', 'branch'])
            ->latest()->take(10)->get();

        return view('analytics.index', compact(
            'totalVehicles', 'totalSales', 'totalCustomers',
            'totalRevenue', 'vehiclesByBranch', 'salesByBranch', 'recentSales'
        ));
    }
}