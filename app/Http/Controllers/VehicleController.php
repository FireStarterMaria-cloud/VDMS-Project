<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VehicleController extends Controller
{
    private function getBranchesQuery()
    {
        $user = Auth::user();
        $query = Branch::where('is_active', true);

        if ($user->isChairwoman()) {
            // sab branches
        } elseif ($user->isSuperAdmin() || $user->isHOAdmin()) {
            $query->where('showroom_id', $user->showroom_id);
        } else {
            $query->where('id', $user->branch_id);
        }

        return $query;
    }

    private function getVehicleQuery()
    {
        $user = Auth::user();
        $query = Vehicle::with('branch');

        if ($user->isChairwoman()) {
            // sab vehicles
        } elseif ($user->isSuperAdmin() || $user->isHOAdmin()) {
            $query->whereHas('branch', function($q) use ($user) {
                $q->where('showroom_id', $user->showroom_id);
            });
        } else {
            $query->where('branch_id', $user->branch_id);
        }

        return $query;
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $query = $this->getVehicleQuery();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('model', 'like', "%{$search}%")
                  ->orWhere('registration_number', 'like', "%{$search}%")
                  ->orWhere('vin_number', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('branch_id')) {
            $query->where('branch_id', $request->branch_id);
        }

        $vehicles = $query->latest()->paginate(15);
        $branches = $this->getBranchesQuery()->get();
        $statuses = ['available', 'reserved', 'sold', 'transferred'];

        return view('vehicles.index', compact('vehicles', 'branches', 'statuses'));
    }

    public function create()
    {
        $user = Auth::user();
        if ($user->isSalesStaff() || $user->isAccountant()) {
            abort(403, 'You do not have permission to add vehicles.');
        }
        $branches = $this->getBranchesQuery()->get();
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

        $vehicle = Vehicle::create($validated);

        if ($request->hasFile('vehicle_images')) {
            foreach ($request->file('vehicle_images') as $index => $image) {
                $path = $image->store("vehicle-images/{$vehicle->id}", 'public');
                \App\Models\VehicleImage::create([
                    'vehicle_id' => $vehicle->id,
                    'image_url'  => $path,
                    'image_name' => $request->image_captions[$index] ?? $image->getClientOriginalName(),
                    'file_size'  => $image->getSize(),
                    'is_primary' => $index == 0,
                    'sort_order' => $index,
                ]);
            }
        }

        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $index => $file) {
                $path = $file->store('vehicle-documents', 'public');
                \App\Models\VehicleDocument::create([
                    'vehicle_id' => $vehicle->id,
                    'file_path'  => $path,
                    'file_name'  => $file->getClientOriginalName(),
                    'file_type'  => $file->getClientOriginalExtension(),
                    'sort_order' => $index,
                ]);
            }
        }

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
            abort(403);
        }
        if (!$user->canAccessBranch($vehicle->branch_id)) {
            abort(403);
        }
        $branches = $this->getBranchesQuery()->get();
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

        if ($request->hasFile('vehicle_images')) {
            $existingCount = $vehicle->images()->count();
            foreach ($request->file('vehicle_images') as $index => $image) {
                $path = $image->store("vehicle-images/{$vehicle->id}", 'public');
                \App\Models\VehicleImage::create([
                    'vehicle_id' => $vehicle->id,
                    'image_url'  => $path,
                    'image_name' => $request->image_captions[$index] ?? $image->getClientOriginalName(),
                    'file_size'  => $image->getSize(),
                    'is_primary' => $existingCount == 0 && $index == 0,
                    'sort_order' => $existingCount + $index,
                ]);
            }
        }

        if ($request->hasFile('documents')) {
            $existingCount = $vehicle->documents()->count();
            foreach ($request->file('documents') as $index => $file) {
                $path = $file->store('vehicle-documents', 'public');
                \App\Models\VehicleDocument::create([
                    'vehicle_id' => $vehicle->id,
                    'file_path'  => $path,
                    'file_name'  => $file->getClientOriginalName(),
                    'file_type'  => $file->getClientOriginalExtension(),
                    'sort_order' => $existingCount + $index,
                ]);
            }
        }

        return redirect()->route('vehicles.index')
            ->with('success', 'Vehicle updated successfully!');
    }

    public function destroy(Vehicle $vehicle)
    {
        $user = Auth::user();
        if (!$user->isSuperAdmin() && !$user->isHOAdmin() && !$user->isChairwoman()) {
            abort(403);
        }
        $vehicle->delete();
        return redirect()->route('vehicles.index')
            ->with('success', 'Vehicle deleted successfully!');
    }

    public function verifyDocument(\App\Models\VehicleDocument $document)
    {
        $user = Auth::user();
        if ($user->isSalesStaff() || $user->isAccountant()) {
            abort(403);
        }
        $document->update([
            'is_verified' => true,
            'verified_by' => $user->id,
            'verified_at' => now(),
        ]);
        return redirect()->back()->with('success', 'Document verified successfully!');
    }
}