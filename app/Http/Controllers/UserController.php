<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Branch;
use App\Enums\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        if (!Auth::user()->isHO()) abort(403);
        $users = User::with('branch')->paginate(15);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        if (!Auth::user()->isHO()) abort(403);
        $branches = Branch::all();
        $roles = Role::cases();
        return view('users.create', compact('branches', 'roles'));
    }

    public function store(Request $request)
    {
        if (!Auth::user()->isHO()) abort(403);

        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|min:8|confirmed',
            'role'      => 'required|in:superadmin,ho_admin,branch_manager,sales_staff,accountant',
            'branch_id' => 'nullable|exists:branches,id',
            'phone'     => 'nullable|string|max:20',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['is_active'] = $request->has('is_active') ? 1 : 1;

        User::create($validated);
        return redirect()->route('users.index')
            ->with('success', 'User created successfully!');
    }

    public function show(User $user)
    {
        if (!Auth::user()->isHO()) abort(403);
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        if (!Auth::user()->isHO()) abort(403);
        $branches = Branch::all();
        $roles = Role::cases();
        return view('users.edit', compact('user', 'branches', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        if (!Auth::user()->isHO()) abort(403);

        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email,' . $user->id,
            'role'      => 'required|in:superadmin,ho_admin,branch_manager,sales_staff,accountant',
            'branch_id' => 'nullable|exists:branches,id',
            'phone'     => 'nullable|string|max:20',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->filled('password')) {
            $request->validate(['password' => 'min:8|confirmed']);
            $validated['password'] = Hash::make($request->password);
        }

        $validated['is_active'] = $request->has('is_active') ? 1 : 0;
        $user->update($validated);

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully!');
    }

    public function destroy(User $user)
    {
        if (!Auth::user()->isSuperAdmin()) abort(403);
        $user->delete();
        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully!');
    }
}