<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Branch;
use App\Models\User;
use App\Models\Sale;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;
use App\Traits\ShowroomScoped;

class DashboardController extends Controller
{
    use ShowroomScoped;

    public function index()
    {
        $user = Auth::user();

        // Vehicle query with showroom scope
        $vehicleQuery = Vehicle::with('branch');
        if ($user->isChairwoman()) {
            // sab
        } elseif ($user->isSuperAdmin() || $user->isHOAdmin()) {
            $vehicleQuery->whereHas('branch', function($q) use ($user) {
                $q->where('showroom_id', $user->showroom_id);
            });
        } else {
            $vehicleQuery->where('branch_id', $user->branch_id);
        }

        // Branch count scope
        $branchCount = Branch::when(!$user->isChairwoman(), function($q) use ($user) {
            $q->where('showroom_id', $user->showroom_id);
        })->count();

        // User count scope
        $userCount = User::when(!$user->isChairwoman(), function($q) use ($user) {
            $q->where('showroom_id', $user->showroom_id);
        })->count();

        $stats = [
            'total_vehicles' => $vehicleQuery->count(),
            'available'      => (clone $vehicleQuery)->where('status', 'available')->count(),
            'sold'           => (clone $vehicleQuery)->where('status', 'sold')->count(),
            'total_branches' => $branchCount,
            'total_users'    => $userCount,
        ];

        $recentVehicles = (clone $vehicleQuery)->latest()->take(5)->get();

        // Sales query with showroom scope
        $salesQuery = Sale::with(['customer', 'vehicle']);
        if ($user->isChairwoman()) {
            // sab
        } elseif ($user->isSuperAdmin() || $user->isHOAdmin()) {
            $salesQuery->whereHas('branch', function($q) use ($user) {
                $q->where('showroom_id', $user->showroom_id);
            });
        } else {
            $salesQuery->where('branch_id', $user->branch_id);
        }

        $recentSales = (clone $salesQuery)->latest()->take(5)->get();
        $totalRevenue = (clone $salesQuery)->where('status', 'completed')->sum('final_price');

        // Needs review invoices
        $needsReviewInvoices = collect();
        if ($user->isHO() || $user->isChairwoman()) {
            $invoiceQuery = Invoice::with(['sale.customer', 'branch'])
                ->where('needs_review', true);

            if (!$user->isChairwoman()) {
                $invoiceQuery->whereHas('branch', function($q) use ($user) {
                    $q->where('showroom_id', $user->showroom_id);
                });
            }

            $needsReviewInvoices = $invoiceQuery->latest()->take(5)->get();
        }

        return view('dashboard.index', compact(
            'stats', 'recentVehicles', 'recentSales',
            'needsReviewInvoices', 'totalRevenue'
        ));
    }
}