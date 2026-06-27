<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Vehicle;
use App\Models\Customer;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\ShowroomScoped;

class SalesController extends Controller
{
    use ShowroomScoped;

    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Sale::with(['vehicle', 'customer', 'branch', 'soldBy']);

        $this->applyShowroomScope($query);

        if ($request->filled('search')) {
            $query->whereHas('vehicle', function($q) use ($request) {
                $q->where('registration_number', 'like', "%{$request->search}%")
                  ->orWhere('model', 'like', "%{$request->search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('branch_id')) {
            $query->where('branch_id', $request->branch_id);
        }

        $sales = $query->latest()->paginate(15);
        $branches = $this->getBranches();

        return view('sales.index', compact('sales', 'branches'));
    }

    public function create()
    {
        $user = Auth::user();
        if ($user->isAccountant()) abort(403);

        $vehicleQuery = Vehicle::where('status', 'available');
        $this->applyShowroomScope($vehicleQuery);
        $vehicles = $vehicleQuery->get();

        $customerQuery = Customer::query();
        $this->applyShowroomScope($customerQuery);
        $customers = $customerQuery->get();

        $branches = $this->getBranches();

        return view('sales.create', compact('vehicles', 'customers', 'branches'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if ($user->isAccountant()) abort(403);

        $validated = $request->validate([
            'vehicle_id'  => 'required|exists:vehicles,id',
            'customer_id' => 'required|exists:customers,id',
            'branch_id'   => 'required|exists:branches,id',
            'sale_price'  => 'required|numeric|min:0',
            'discount'    => 'nullable|numeric|min:0',
            'final_price' => 'required|numeric|min:0',
            'status'      => 'required|in:pending,completed,cancelled',
            'sale_date'   => 'required|date',
            'notes'       => 'nullable|string',
        ]);

        $validated['sold_by'] = $user->id;
        Sale::create($validated);

        Vehicle::where('id', $validated['vehicle_id'])->update(['status' => 'sold']);

        // Trigger notifications
$vehicle = \App\Models\Vehicle::with('branch')->find($validated['vehicle_id']);
\App\Services\NotificationService::vehicleSold($vehicle);
\App\Services\NotificationService::checkLowStock($validated['branch_id']);

        return redirect()->route('sales.index')->with('success', 'Sale recorded successfully!');
    }

    public function show(Sale $sale)
    {
        $user = Auth::user();
        if (!$user->isChairwoman() && !$user->canAccessBranch($sale->branch_id)) abort(403);
        $sale->load(['vehicle', 'customer', 'branch', 'soldBy']);
        return view('sales.show', compact('sale'));
    }

    public function edit(Sale $sale)
    {
        $user = Auth::user();
        if ($user->isAccountant() || $user->isSalesStaff()) abort(403);
        if (!$user->isChairwoman() && !$user->canAccessBranch($sale->branch_id)) abort(403);

        $vehicles = Vehicle::all();
        $customers = Customer::all();
        $branches = $this->getBranches();

        return view('sales.edit', compact('sale', 'vehicles', 'customers', 'branches'));
    }

    public function update(Request $request, Sale $sale)
    {
        $user = Auth::user();
        if ($user->isAccountant() || $user->isSalesStaff()) abort(403);

        $validated = $request->validate([
            'vehicle_id'  => 'required|exists:vehicles,id',
            'customer_id' => 'required|exists:customers,id',
            'branch_id'   => 'required|exists:branches,id',
            'sale_price'  => 'required|numeric|min:0',
            'discount'    => 'nullable|numeric|min:0',
            'final_price' => 'required|numeric|min:0',
            'status'      => 'required|in:pending,completed,cancelled',
            'sale_date'   => 'required|date',
            'notes'       => 'nullable|string',
        ]);

        $sale->update($validated);
        return redirect()->route('sales.index')->with('success', 'Sale updated successfully!');
    }

    public function destroy(Sale $sale)
    {
        $user = Auth::user();
        if (!$user->isHO() && !$user->isChairwoman()) abort(403);
        $sale->delete();
        return redirect()->route('sales.index')->with('success', 'Sale deleted successfully!');
    }
}