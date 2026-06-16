<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Vehicle;
use App\Models\Customer;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SalesController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Sale::with(['vehicle', 'customer', 'branch', 'soldBy']);

        if (!$user->isHO()) {
            $query->where('branch_id', $user->branch_id);
        }

        if ($request->filled('search')) {
            $query->whereHas('vehicle', function($q) use ($request) {
                $q->where('registration_number', 'like', "%{$request->search}%")
                  ->orWhere('model', 'like', "%{$request->search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('branch_id') && $user->isHO()) {
            $query->where('branch_id', $request->branch_id);
        }

        $sales = $query->latest()->paginate(15);
        $branches = $user->isHO() ? Branch::all() : collect();

        return view('sales.index', compact('sales', 'branches'));
    }

    public function create()
    {
        $user = Auth::user();
        if ($user->isAccountant()) {
            abort(403);
        }

        $query = Vehicle::where('status', 'available');
        if (!$user->isHO()) {
            $query->where('branch_id', $user->branch_id);
        }
        $vehicles = $query->get();

        $customerQuery = Customer::query();
        if (!$user->isHO()) {
            $customerQuery->where('branch_id', $user->branch_id);
        }
        $customers = $customerQuery->get();
        $branches = Branch::all();

        return view('sales.create', compact('vehicles', 'customers', 'branches'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if ($user->isAccountant()) {
            abort(403);
        }

        $validated = $request->validate([
            'vehicle_id'   => 'required|exists:vehicles,id',
            'customer_id'  => 'required|exists:customers,id',
            'branch_id'    => 'required|exists:branches,id',
            'sale_price'   => 'required|numeric|min:0',
            'discount'     => 'nullable|numeric|min:0',
            'final_price'  => 'required|numeric|min:0',
            'status'       => 'required|in:pending,completed,cancelled',
            'sale_date'    => 'required|date',
            'notes'        => 'nullable|string',
        ]);

        $validated['sold_by'] = $user->id;

        $sale = Sale::create($validated);

        // Vehicle status update
        Vehicle::where('id', $validated['vehicle_id'])
            ->update(['status' => 'sold']);

        return redirect()->route('sales.index')
            ->with('success', 'Sale recorded successfully!');
    }

    public function show(Sale $sale)
    {
        $user = Auth::user();
        if (!$user->isHO() && $sale->branch_id !== $user->branch_id) {
            abort(403);
        }
        $sale->load(['vehicle', 'customer', 'branch', 'soldBy']);
        return view('sales.show', compact('sale'));
    }

    public function edit(Sale $sale)
    {
        $user = Auth::user();
        if ($user->isAccountant() || $user->isSalesStaff()) {
            abort(403);
        }
        if (!$user->isHO() && $sale->branch_id !== $user->branch_id) {
            abort(403);
        }

        $vehicles = Vehicle::all();
        $customers = Customer::all();
        $branches = Branch::all();

        return view('sales.edit', compact('sale', 'vehicles', 'customers', 'branches'));
    }

    public function update(Request $request, Sale $sale)
    {
        $user = Auth::user();
        if ($user->isAccountant() || $user->isSalesStaff()) {
            abort(403);
        }

        $validated = $request->validate([
            'vehicle_id'   => 'required|exists:vehicles,id',
            'customer_id'  => 'required|exists:customers,id',
            'branch_id'    => 'required|exists:branches,id',
            'sale_price'   => 'required|numeric|min:0',
            'discount'     => 'nullable|numeric|min:0',
            'final_price'  => 'required|numeric|min:0',
            'status'       => 'required|in:pending,completed,cancelled',
            'sale_date'    => 'required|date',
            'notes'        => 'nullable|string',
        ]);

        $sale->update($validated);

        return redirect()->route('sales.index')
            ->with('success', 'Sale updated successfully!');
    }

    public function destroy(Sale $sale)
    {
        $user = Auth::user();
        if (!$user->isHO()) {
            abort(403);
        }

        $sale->delete();

        return redirect()->route('sales.index')
            ->with('success', 'Sale deleted successfully!');
    }
}