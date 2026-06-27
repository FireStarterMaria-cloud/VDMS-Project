<?php

namespace App\Http\Controllers;

use App\Models\BranchTransfer;
use App\Models\Vehicle;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\ShowroomScoped;

class BranchTransferController extends Controller
{
    use ShowroomScoped;

    public function index(Request $request)
    {
        $user = Auth::user();
        $query = BranchTransfer::with(['vehicle', 'fromBranch', 'toBranch', 'requestedBy']);

        if ($user->isChairwoman()) {
            // sab transfers
        } elseif ($user->isSuperAdmin() || $user->isHOAdmin()) {
            $branchIds = $this->getBranches()->pluck('id');
            $query->where(function($q) use ($branchIds) {
                $q->whereIn('from_branch_id', $branchIds)
                  ->orWhereIn('to_branch_id', $branchIds);
            });
        } else {
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

        $vehicleQuery = Vehicle::where('status', 'available');
        $this->applyShowroomScope($vehicleQuery);
        $vehicles = $vehicleQuery->get();

        $branches = $this->getBranches();
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
        return redirect()->route('branch-transfers.index')->with('success', 'Transfer request submitted!');
    }

    public function show(BranchTransfer $branchTransfer)
    {
        $branchTransfer->load(['vehicle', 'fromBranch', 'toBranch', 'requestedBy', 'approvedBy']);
        return view('branch-transfers.show', compact('branchTransfer'));
    }

    public function approve(BranchTransfer $branchTransfer)
    {
        $user = Auth::user();
        if (!$user->isHO() && !$user->isChairwoman()) abort(403);

        $branchTransfer->update([
            'status'        => 'approved',
            'approved_by'   => Auth::id(),
            'approved_date' => now(),
        ]);

        Vehicle::where('id', $branchTransfer->vehicle_id)
            ->update(['branch_id' => $branchTransfer->to_branch_id, 'status' => 'transferred']);

        return redirect()->route('branch-transfers.index')->with('success', 'Transfer approved!');
    }

    public function reject(BranchTransfer $branchTransfer)
    {
        $user = Auth::user();
        if (!$user->isHO() && !$user->isChairwoman()) abort(403);

        $branchTransfer->update([
            'status'      => 'rejected',
            'approved_by' => Auth::id(),
        ]);

        return redirect()->route('branch-transfers.index')->with('success', 'Transfer rejected!');
    }

    public function destroy(BranchTransfer $branchTransfer)
    {
        $user = Auth::user();
        if (!$user->isHO() && !$user->isChairwoman()) abort(403);
        $branchTransfer->delete();
        return redirect()->route('branch-transfers.index')->with('success', 'Transfer deleted!');
    }
}