<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BranchController extends Controller
{
    public function index()
    {
        if (!Auth::user()->isHO()) abort(403);
        $branches = Branch::withCount('vehicles')->paginate(15);
        return view('branches.index', compact('branches'));
    }

    public function create()
    {
        if (!Auth::user()->isHO()) abort(403);
        return view('branches.create');
    }

    public function store(Request $request)
    {
        if (!Auth::user()->isHO()) abort(403);

        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'city'          => 'required|string|max:100',
            'country'       => 'nullable|string|max:100',
            'address'       => 'nullable|string',
            'phone'         => 'nullable|string|max:20',
            'email'         => 'nullable|email',
            'currency'      => 'nullable|string|max:10',
            'exchange_rate' => 'nullable|numeric',
            'is_active'     => 'nullable|boolean',
        ]);

        $validated['country'] = $validated['country'] ?? 'Pakistan';
        $validated['currency'] = $validated['currency'] ?? 'PKR';
        $validated['exchange_rate'] = $validated['exchange_rate'] ?? 1;
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        Branch::create($validated);
        return redirect()->route('branches.index')
            ->with('success', 'Branch created successfully!');
    }

    public function show(Branch $branch)
    {
        if (!Auth::user()->isHO()) abort(403);
        $branch->load('vehicles', 'users');
        return view('branches.show', compact('branch'));
    }

    public function edit(Branch $branch)
    {
        if (!Auth::user()->isHO()) abort(403);
        return view('branches.edit', compact('branch'));
    }

    public function update(Request $request, Branch $branch)
    {
        if (!Auth::user()->isHO()) abort(403);

        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'city'          => 'required|string|max:100',
            'country'       => 'nullable|string|max:100',
            'address'       => 'nullable|string',
            'phone'         => 'nullable|string|max:20',
            'email'         => 'nullable|email',
            'currency'      => 'nullable|string|max:10',
            'exchange_rate' => 'nullable|numeric',
            'is_active'     => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active') ? 1 : 0;
        $branch->update($validated);

        return redirect()->route('branches.index')
            ->with('success', 'Branch updated successfully!');
    }

    public function destroy(Branch $branch)
    {
        if (!Auth::user()->isSuperAdmin()) abort(403);
        $branch->delete();
        return redirect()->route('branches.index')
            ->with('success', 'Branch deleted successfully!');
    }
}