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
                  ->orWhere('vin_number', 'like', "%{$search}%")
                  ->orWhere('registration_number', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('branch_id')) {
            $query->where('branch_id', $request->branch_id);
        }

        $vehicles = $query->latest()->paginate(15);
        $branches = Branch::all();
        $statuses = ['available', 'reserved', 'sold', 'transferred'];

        return view('vehicles.index', compact('vehicles', 'branches', 'statuses'));
    }

    public function create()
    {
        $user = Auth::user();
        if ($user->isSalesStaff() || $user->isAccountant()) {
            abort(403, 'You do not have permission to add vehicles.');
        }
        $branches = Branch::all();
        return view('vehicles.create', compact('branches'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if ($user->isSalesStaff() || $user->isAccountant()) {
            abort(403);
        }

        $validated = $request->validate([
            'vin_number'          => 'required|unique:vehicles,vin_number',
            'make'                => 'required|string|max:255',
            'model'               => 'required|string|max:255',
            'year'                => 'required|integer|min:2000',
            'selling_price'       => 'required|numeric|min:0',
            'purchase_price'      => 'required|numeric|min:0',
            'colour'              => 'required|string',
            'registration_number' => 'nullable|string',
            'mileage'             => 'nullable|integer',
            'engine_capacity'     => 'nullable|string',
            'transmission'        => 'nullable|in:manual,automatic',
            'fuel_type'           => 'nullable|in:petrol,diesel,hybrid,electric',
            'variant'             => 'nullable|string',
            'condition'           => 'required|in:new,used',
            'status'              => 'required|in:available,reserved,sold,transferred',
            'branch_id'           => 'required|exists:branches,id',
            'notes'               => 'nullable|string',
        ]);

        Vehicle::create($validated);

        return redirect()->route('vehicles.index')
            ->with('success', 'Vehicle added successfully!');
    }

    public function show(Vehicle $vehicle)
    {
        $user = Auth::user();
        if (!$user->canAccessBranch($vehicle->branch_id)) {
            abort(403, 'You cannot access vehicles from other branches.');
        }

        return view('vehicles.show', compact('vehicle'));
    }

    public function edit(Vehicle $vehicle)
    {
        $user = Auth::user();
        if ($user->isSalesStaff() || $user->isAccountant()) {
            abort(403, 'You do not have permission to edit vehicles.');
        }
        if (!$user->canAccessBranch($vehicle->branch_id)) {
            abort(403, 'You cannot access vehicles from other branches.');
        }

        $branches = Branch::all();
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
            'vin_number'          => 'required|unique:vehicles,vin_number,' . $vehicle->id,
            'make'                => 'required|string|max:255',
            'model'               => 'required|string|max:255',
            'year'                => 'required|integer|min:2000',
            'selling_price'       => 'required|numeric|min:0',
            'purchase_price'      => 'required|numeric|min:0',
            'colour'              => 'required|string',
            'registration_number' => 'nullable|string',
            'mileage'             => 'nullable|integer',
            'engine_capacity'     => 'nullable|string',
            'transmission'        => 'nullable|in:manual,automatic',
            'fuel_type'           => 'nullable|in:petrol,diesel,hybrid,electric',
            'variant'             => 'nullable|string',
            'condition'           => 'required|in:new,used',
            'status'              => 'required|in:available,reserved,sold,transferred',
            'branch_id'           => 'required|exists:branches,id',
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
            abort(403, 'Only admins can delete vehicles.');
        }
        if (!$user->canAccessBranch($vehicle->branch_id)) {
            abort(403);
        }

        $vehicle->delete();

        return redirect()->route('vehicles.index')
            ->with('success', 'Vehicle deleted successfully!');
    }
}