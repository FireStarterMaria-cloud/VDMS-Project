<?php

namespace App\Http\Controllers;

use App\Models\Showroom;
use App\Models\Branch;
use App\Models\User;
use App\Enums\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ShowroomController extends Controller
{
    public function index()
    {
        if (!Auth::user()->isChairwoman()) abort(403);
        $showrooms = Showroom::withCount(['branches', 'users'])->get();
        return view('showrooms.index', compact('showrooms'));
    }

    /**
     * Glass-style overview cards page — used for the
     * "click a showroom -> see its branches" flow.
     */
    public function overview()
    {
        if (!Auth::user()->isChairwoman()) abort(403);
        $showrooms = Showroom::withCount(['branches', 'users'])->where('is_active', true)->get();
        return view('showrooms.overview', compact('showrooms'));
    }

    /**
     * Branches belonging to one showroom — its own dedicated page.
     */
    public function branches(Showroom $showroom)
    {
        if (!Auth::user()->isChairwoman()) abort(403);
        $showroom->load(['branches' => function ($q) {
            $q->withCount('vehicles');
        }]);
        return view('showrooms.branches', compact('showroom'));
    }

    public function create()
    {
        if (!Auth::user()->isChairwoman()) abort(403);
        return view('showrooms.create');
    }

    public function store(Request $request)
    {
        if (!Auth::user()->isChairwoman()) abort(403);

        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'city'           => 'required|string|max:100',
            'country'        => 'nullable|string|max:100',
            'address'        => 'nullable|string',
            'phone'          => 'nullable|string|max:20',
            'email'          => 'nullable|email',
            'theme_color'    => 'nullable|string|max:20',
            'logo'           => 'nullable|image|max:2048',
            'is_active'      => 'nullable|boolean',
            'admin_name'     => 'required|string|max:255',
            'admin_email'    => 'required|email|unique:users,email',
            'admin_password' => 'required|min:8',
        ]);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('showroom-logos', 'public');
        }

        $showroom = Showroom::create([
            'name'        => $validated['name'],
            'city'        => $validated['city'],
            'country'     => $validated['country'] ?? 'Pakistan',
            'address'     => $validated['address'] ?? null,
            'phone'       => $validated['phone'] ?? null,
            'email'       => $validated['email'] ?? null,
            'theme_color' => $validated['theme_color'] ?? '#696cff',
            'logo'        => $logoPath,
            'is_active'   => 1,
        ]);

        // Auto create superadmin for this showroom
        User::create([
            'name'        => $validated['admin_name'],
            'email'       => $validated['admin_email'],
            'password'    => Hash::make($validated['admin_password']),
            'role'        => Role::SUPERADMIN,
            'showroom_id' => $showroom->id,
            'is_active'   => true,
        ]);

        return redirect()->route('showrooms.index')->with('success', 'Showroom created with admin successfully!');
    }

    public function show(Showroom $showroom)
    {
        if (!Auth::user()->isChairwoman()) abort(403);
        $showroom->load(['branches.vehicles', 'users']);
        return view('showrooms.show', compact('showroom'));
    }

    public function edit(Showroom $showroom)
    {
        if (!Auth::user()->isChairwoman()) abort(403);
        return view('showrooms.edit', compact('showroom'));
    }

    public function update(Request $request, Showroom $showroom)
    {
        if (!Auth::user()->isChairwoman()) abort(403);

        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'city'        => 'required|string|max:100',
            'country'     => 'nullable|string|max:100',
            'address'     => 'nullable|string',
            'phone'       => 'nullable|string|max:20',
            'email'       => 'nullable|email',
            'theme_color' => 'nullable|string|max:20',
            'logo'        => 'nullable|image|max:2048',
            'is_active'   => 'nullable|boolean',
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('showroom-logos', 'public');
        }

        $validated['is_active'] = $request->has('is_active') ? 1 : 0;
        $showroom->update($validated);

        return redirect()->route('showrooms.index')->with('success', 'Showroom updated successfully!');
    }

    public function destroy(Showroom $showroom)
    {
        if (!Auth::user()->isChairwoman()) abort(403);
        $showroom->delete();
        return redirect()->route('showrooms.index')->with('success', 'Showroom deleted successfully!');
    }
}