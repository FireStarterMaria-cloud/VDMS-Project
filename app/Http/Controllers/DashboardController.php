<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $query = Vehicle::with('branch');

        // Branch restriction
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

        $recentVehicles = $query->with('branch')
                                ->latest()
                                ->take(5)
                                ->get();

        return view('dashboard.index', compact('stats', 'recentVehicles'));
    }
}