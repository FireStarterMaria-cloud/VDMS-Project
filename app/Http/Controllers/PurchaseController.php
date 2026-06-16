<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Vehicle;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Purchase::with(['vehicle', 'branch', 'purchasedBy']);

        if (!$user->isHO()) {
            $query->where('branch_id', $user->branch_id);
        }

        $purchases = $query->latest()->paginate(15);
        $branches = $user->isHO() ? Branch::all() : collect();

        return view('purchases.index', compact('purchases', 'branches'));
    }

    public function create()
    {
        $user = Auth::user();
        if ($user->isSalesStaff()) abort(403);

        $vehicles = Vehicle::where('status', 'available')->get();
        $branches = Branch::all();
        return view('purchases.create', compact('vehicles', 'branches'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if ($user->isSalesStaff()) abort(403);

        $validated = $request->validate([
            'vehicle_id'       => 'required|exists:vehicles,id',
            'branch_id'        => 'required|exists:branches,id',
            'supplier_name'    => 'required|string|max:255',
            'supplier_contact' => 'nullable|string|max:20',
            'purchase_price'   => 'required|numeric|min:0',
            'payment_method'   => 'required|in:cash,cheque,bank_transfer',
            'reference_no'     => 'nullable|string|max:100',
            'purchase_date'    => 'required|date',
            'notes'            => 'nullable|string',
        ]);

        $validated['purchased_by'] = $user->id;
        Purchase::create($validated);

        return redirect()->route('purchases.index')
            ->with('success', 'Purchase recorded successfully!');
    }

    public function show(Purchase $purchase)
    {
        $user = Auth::user();
        if (!$user->isHO() && $purchase->branch_id !== $user->branch_id) abort(403);
        $purchase->load(['vehicle', 'branch', 'purchasedBy']);
        return view('purchases.show', compact('purchase'));
    }

    public function edit(Purchase $purchase)
    {
        $user = Auth::user();
        if ($user->isSalesStaff()) abort(403);
        if (!$user->isHO() && $purchase->branch_id !== $user->branch_id) abort(403);
        $vehicles = Vehicle::all();
        $branches = Branch::all();
        return view('purchases.edit', compact('purchase', 'vehicles', 'branches'));
    }

    public function update(Request $request, Purchase $purchase)
    {
        $user = Auth::user();
        if ($user->isSalesStaff()) abort(403);

        $validated = $request->validate([
            'vehicle_id'       => 'required|exists:vehicles,id',
            'branch_id'        => 'required|exists:branches,id',
            'supplier_name'    => 'required|string|max:255',
            'supplier_contact' => 'nullable|string|max:20',
            'purchase_price'   => 'required|numeric|min:0',
            'payment_method'   => 'required|in:cash,cheque,bank_transfer',
            'reference_no'     => 'nullable|string|max:100',
            'purchase_date'    => 'required|date',
            'notes'            => 'nullable|string',
        ]);

        $purchase->update($validated);
        return redirect()->route('purchases.index')
            ->with('success', 'Purchase updated successfully!');
    }

    public function destroy(Purchase $purchase)
    {
        if (!Auth::user()->isHO()) abort(403);
        $purchase->delete();
        return redirect()->route('purchases.index')
            ->with('success', 'Purchase deleted successfully!');
    }
}