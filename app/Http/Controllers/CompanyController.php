<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Showroom;
use App\Models\Branch;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\Sale;
use App\Enums\Role;

class CompanyController extends Controller
{
    public function index()
    {
        $showrooms = Showroom::where('is_active', true)
            ->with(['branches' => function ($q) {
                $q->where('is_active', true);
            }])
            ->get();

        $stats = [
            'showrooms' => Showroom::where('is_active', true)->count(),
            'branches'  => Branch::where('is_active', true)->count(),
            'vehicles'  => Vehicle::count(),
            'sales'     => Sale::count(),
            'staff'     => User::where('is_active', true)->count(),
        ];

        $teamByRole = [];
        if (auth()->check() && auth()->user()->role === Role::CHAIRWOMAN) {
            $teamByRole = User::where('is_active', true)
                ->with('branch')
                ->orderBy('role')
                ->get()
                ->groupBy(fn($u) => $u->role->value);
        } else {
            $teamByRole = User::where('is_active', true)
                ->select('role', 'branch_id')
                ->with('branch:id,name')
                ->get()
                ->groupBy(fn($u) => $u->role->value);
        }

        $isChairwoman = auth()->check() && auth()->user()->role === Role::CHAIRWOMAN;

        return view('company', compact('showrooms', 'stats', 'teamByRole', 'isChairwoman'));
    }
}