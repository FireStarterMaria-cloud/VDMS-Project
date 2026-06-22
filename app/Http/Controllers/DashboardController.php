<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Branch;
use App\Models\User;
use App\Models\Sale;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $query = Vehicle::with('branch');

        if (!$user->isSuperAdmin() && !$user->isHOAdmin()) {
            $query->where('branch_id', $user->branch_id);
        }

        $stats = [
            'total_vehicles'   => $query->count(),
            'available'        => (clone $query)->where('status', 'available')->count(),
            'sold'             => (clone $query)->where('status', 'sold')->count(),
            'total_branches'   => Branch::count(),
            'total_users'      => User::count(),
        ];

        $recentVehicles = $query->with('branch')->latest()->take(5)->get();

        $salesQuery = Sale::with(['customer', 'vehicle']);
        if (!$user->isSuperAdmin() && !$user->isHOAdmin()) {
            $salesQuery->where('branch_id', $user->branch_id);
        }

        $recentSales = $salesQuery->latest()->take(5)->get();

        $needsReviewInvoices = collect();
if ($user->isHO()) {
    $needsReviewInvoices = \App\Models\Invoice::with(['sale.customer', 'branch'])
        ->where('needs_review', true)
        ->latest()
        ->take(5)
        ->get();
}
        $totalRevenue = (clone $salesQuery)->where('status', 'completed')->sum('final_price');

        return view('dashboard.index', compact('stats', 'recentVehicles', 'recentSales', 'needsReviewInvoices' ,  'totalRevenue'));
    }
}