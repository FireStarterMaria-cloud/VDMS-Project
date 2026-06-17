<?php

namespace App\Http\Controllers;

use App\Models\BranchTransfer;
use App\Models\Vehicle;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BranchTransferController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = BranchTransfer::with(['vehicle', 'fromBranch', 'toBranch', 'requestedBy']);

        if (!$user->isHO()) {
            $query->where(function($q) use ($user) {
                $q->where('from_branch_id', $user->branch_id)
                  ->orWhere('to_branch_id', $user->branch_id);
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $transfers = $query->latest()->paginate(15);
        return view('branch-transfers.index', compact('transfers'));
    }

    public function create()
    {
        $user = Auth::user();
        if ($user->isSalesStaff() || $user->isAccountant()) abort(403);

        $vehicles = Vehicle::where('status', 'available')->get();
        $branches = Branch::all();
        return view('branch-transfers.create', compact('vehicles', 'branches'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if ($user->isSalesStaff() || $user->isAccountant()) abort(403);

        $validated = $request->validate([
            'vehicle_id'     => 'required|exists:vehicles,id',
            'from_branch_id' => 'required|exists:branches,id',
            'to_branch_id'   => 'required|exists:branches,id|different:from_branch_id',
            'reason'         => 'nullable|string',
            'requested_date' => 'required|date',
        ]);

        $validated['requested_by'] = $user->id;
        $validated['status'] = 'pending';

        BranchTransfer::create($validated);

        return redirect()->route('branch-transfers.index')
            ->with('success', 'Transfer request submitted!');
    }

    public function show(BranchTransfer $branchTransfer)
    {
        $branchTransfer->load(['vehicle', 'fromBranch', 'toBranch', 'requestedBy', 'approvedBy']);
        return view('branch-transfers.show', compact('branchTransfer'));
    }

    public function approve(BranchTransfer $branchTransfer)
    {
        if (!Auth::user()->isHO()) abort(403);

        $branchTransfer->update([
            'status'        => 'approved',
            'approved_by'   => Auth::id(),
            'approved_date' => now(),
        ]);

        Vehicle::where('id', $branchTransfer->vehicle_id)
            ->update(['branch_id' => $branchTransfer->to_branch_id, 'status' => 'transferred']);

        return redirect()->route('branch-transfers.index')
            ->with('success', 'Transfer approved!');
    }

    public function reject(BranchTransfer $branchTransfer)
    {
        if (!Auth::user()->isHO()) abort(403);

        $branchTransfer->update([
            'status'      => 'rejected',
            'approved_by' => Auth::id(),
        ]);

        return redirect()->route('branch-transfers.index')
            ->with('success', 'Transfer rejected!');
    }

    public function destroy(BranchTransfer $branchTransfer)
    {
        if (!Auth::user()->isHO()) abort(403);
        $branchTransfer->delete();
        return redirect()->route('branch-transfers.index')
            ->with('success', 'Transfer deleted!');
    }
}