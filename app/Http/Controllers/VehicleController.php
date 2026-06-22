<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VehicleController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Vehicle::with('branch');

        if (!$user->isSuperAdmin() && !$user->isHOAdmin()) {
            $query->where('branch_id', $user->branch_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('model', 'like', "%{$search}%")
                  ->orWhere('registration_no', 'like', "%{$search}%")
                  ->orWhere('vin_number', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $vehicles = $query->latest()->paginate(15);
        $branches = Branch::all();
        $statuses = ['available', 'reserved', 'sold', 'transferred', 'in_transit'];

        return view('vehicles.index', compact('vehicles', 'branches', 'statuses'));
    }

    public function create()
    {
        $user = Auth::user();
        if ($user->isSalesStaff() || $user->isAccountant()) {
            abort(403, 'You do not have permission to add vehicles.');
        }

        $branches = Branch::where('is_active', true)->get();   // ← Fixed: get() not pluck
        return view('vehicles.create', compact('branches'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if ($user->isSalesStaff() || $user->isAccountant()) {
            abort(403);
        }

        $validated = $request->validate([
            'branch_id'           => 'required|exists:branches,id',
            'make'                => 'required|string|max:255',
            'model'               => 'required|string|max:255',
            'year'                => 'required|integer|min:2000',
            'registration_no'     => 'required|string|unique:vehicles',
            'vin_number'          => 'nullable|string|unique:vehicles',
            'colour'              => 'required|string',
            'purchase_price'      => 'required|numeric|min:0',
            'selling_price'       => 'required|numeric|min:0',
            'profit_amount'       => 'nullable|numeric',
            'profit_type'         => 'nullable|in:profit,loss,break_even',
            'purchase_date'       => 'nullable|date',
            'status'              => 'required|in:available,reserved,sold,transferred,in_transit',
            'mileage'             => 'nullable|integer',
            'transmission'        => 'nullable|in:manual,automatic',
            'fuel_type'           => 'nullable|in:petrol,diesel,hybrid,electric',
            'variant'             => 'nullable|string',
            'condition'           => 'nullable|in:new,used',
            'notes'               => 'nullable|string',
        ]);

        Vehicle::create($validated);

        return redirect()->route('vehicles.index')
                         ->with('success', 'Vehicle added successfully!');
    }

    // edit, update, destroy methods same as before (already good)
    public function edit(Vehicle $vehicle)
    {
        $user = Auth::user();
        if ($user->isSalesStaff() || $user->isAccountant()) {
            abort(403);
        }
        if (!$user->canAccessBranch($vehicle->branch_id)) {
            abort(403);
        }

        $branches = Branch::where('is_active', true)->get();   // ← Fixed here too
        return view('vehicles.edit', compact('vehicle', 'branches'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $user = Auth::user();
        if ($user->isSalesStaff() || $user->isAccountant()) {
            abort(403);
        }
        if (!$user->canAccessBranch($vehicle->branch_id)) {
            abort(403);
        }

        $validated = $request->validate([
            'branch_id'           => 'required|exists:branches,id',
            'make'                => 'required|string|max:255',
            'model'               => 'required|string|max:255',
            'year'                => 'required|integer|min:2000',
            'registration_no'     => 'required|string|unique:vehicles,registration_no,' . $vehicle->id,
            'vin_number'          => 'nullable|string|unique:vehicles,vin_number,' . $vehicle->id,
            'colour'              => 'required|string',
            'purchase_price'      => 'required|numeric|min:0',
            'selling_price'       => 'required|numeric|min:0',
            'profit_amount'       => 'nullable|numeric',
            'profit_type'         => 'nullable|in:profit,loss,break_even',
            'purchase_date'       => 'nullable|date',
            'status'              => 'required|in:available,reserved,sold,transferred,in_transit',
            'mileage'             => 'nullable|integer',
            'transmission'        => 'nullable|in:manual,automatic',
            'fuel_type'           => 'nullable|in:petrol,diesel,hybrid,electric',
            'variant'             => 'nullable|string',
            'condition'           => 'nullable|in:new,used',
            'notes'               => 'nullable|string',
        ]);

        $vehicle->update($validated);

        return redirect()->route('vehicles.index')
                         ->with('success', 'Vehicle updated successfully!');
    }

    public function destroy(Vehicle $vehicle)
    {
        $user = Auth::user();
        if (!$user->isSuperAdmin() && !$user->isHOAdmin()) {
            abort(403);
        }
        if (!$user->canAccessBranch($vehicle->branch_id)) {
            abort(403);
        }

        $vehicle->delete();

        return redirect()->route('vehicles.index')
                         ->with('success', 'Vehicle deleted successfully!');
    }
}