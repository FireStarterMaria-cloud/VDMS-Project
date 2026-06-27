<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Showroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\ShowroomScoped;

class BranchController extends Controller
{
    use ShowroomScoped;

    public function index()
    {
        $user = Auth::user();
        if (!$user->isHO() && !$user->isChairwoman()) abort(403);

        $query = Branch::withCount('vehicles');

        if ($user->isChairwoman()) {
            // sab branches
        } elseif ($user->isSuperAdmin() || $user->isHOAdmin()) {
            $query->where('showroom_id', $user->showroom_id);
        }

        $branches = $query->paginate(15);
        return view('branches.index', compact('branches'));
    }

    public function create()
    {
        $user = Auth::user();
        if (!$user->isHO() && !$user->isChairwoman()) abort(403);
        $showrooms = $user->isChairwoman() ? Showroom::all() : collect();
        return view('branches.create', compact('showrooms'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user->isHO() && !$user->isChairwoman()) abort(403);

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
            'showroom_id'   => 'nullable|exists:showrooms,id',
        ]);

        $validated['country'] = $validated['country'] ?? 'Pakistan';
        $validated['currency'] = $validated['currency'] ?? 'PKR';
        $validated['exchange_rate'] = $validated['exchange_rate'] ?? 1;
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        // Auto assign showroom
        if (!$user->isChairwoman()) {
            $validated['showroom_id'] = $user->showroom_id;
        }

        Branch::create($validated);
        return redirect()->route('branches.index')->with('success', 'Branch created successfully!');
    }

    public function show(Branch $branch)
    {
        $user = Auth::user();
        if (!$user->isHO() && !$user->isChairwoman()) abort(403);
        $branch->load('vehicles', 'users');
        return view('branches.show', compact('branch'));
    }

    public function edit(Branch $branch)
    {
        $user = Auth::user();
        if (!$user->isHO() && !$user->isChairwoman()) abort(403);
        $showrooms = $user->isChairwoman() ? Showroom::all() : collect();
        return view('branches.edit', compact('branch', 'showrooms'));
    }

    public function update(Request $request, Branch $branch)
    {
        $user = Auth::user();
        if (!$user->isHO() && !$user->isChairwoman()) abort(403);

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

        return redirect()->route('branches.index')->with('success', 'Branch updated successfully!');
    }

    public function destroy(Branch $branch)
    {
        $user = Auth::user();
        if (!$user->isSuperAdmin() && !$user->isChairwoman()) abort(403);
        $branch->delete();
        return redirect()->route('branches.index')->with('success', 'Branch deleted successfully!');
    }
}