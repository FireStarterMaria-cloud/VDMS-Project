<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\ShowroomScoped;

class CustomerController extends Controller
{
    use ShowroomScoped;

    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Customer::with('branch');

        $this->applyShowroomScope($query);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('cnic', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('branch_id')) {
            $query->where('branch_id', $request->branch_id);
        }

        $customers = $query->latest()->paginate(15);
        $branches = $this->getBranches();

        return view('customers.index', compact('customers', 'branches'));
    }

    public function create()
    {
        $user = Auth::user();
        if ($user->isAccountant()) abort(403);
        $branches = $this->getBranches();
        return view('customers.create', compact('branches'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if ($user->isAccountant()) abort(403);

        $validated = $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'name'      => 'required|string|max:255',
            'cnic'      => 'nullable|string|max:15',
            'phone'     => 'required|string|max:20',
            'email'     => 'nullable|email|max:255',
            'address'   => 'nullable|string',
            'city'      => 'nullable|string|max:100',
            'country'   => 'nullable|string|max:100',
        ]);

        Customer::create($validated);
        return redirect()->route('customers.index')->with('success', 'Customer added successfully!');
    }

    public function show(Customer $customer)
    {
        $user = Auth::user();
        if (!$user->isChairwoman() && !$user->canAccessBranch($customer->branch_id)) abort(403);
        $customer->load(['branch', 'sales']);
        return view('customers.show', compact('customer'));
    }

    public function edit(Customer $customer)
    {
        $user = Auth::user();
        if ($user->isAccountant()) abort(403);
        if (!$user->isChairwoman() && !$user->canAccessBranch($customer->branch_id)) abort(403);
        $branches = $this->getBranches();
        return view('customers.edit', compact('customer', 'branches'));
    }

    public function update(Request $request, Customer $customer)
    {
        $user = Auth::user();
        if ($user->isAccountant()) abort(403);

        $validated = $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'name'      => 'required|string|max:255',
            'cnic'      => 'nullable|string|max:15',
            'phone'     => 'required|string|max:20',
            'email'     => 'nullable|email|max:255',
            'address'   => 'nullable|string',
            'city'      => 'nullable|string|max:100',
            'country'   => 'nullable|string|max:100',
        ]);

        $customer->update($validated);
        return redirect()->route('customers.index')->with('success', 'Customer updated successfully!');
    }

    public function destroy(Customer $customer)
    {
        $user = Auth::user();
        if (!$user->isHO() && !$user->isChairwoman()) abort(403);
        $customer->delete();
        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully!');
    }
}