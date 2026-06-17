@extends('layouts.app')
@section('title', 'Transfer Details')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4"><i class="bx bx-transfer me-2"></i> Transfer Details</h4>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="text-muted">Vehicle</label>
                    <p class="fw-bold">{{ $branchTransfer->vehicle->make ?? '' }} {{ $branchTransfer->vehicle->model ?? 'N/A' }}
                        <small class="text-muted">({{ $branchTransfer->vehicle->registration_number ?? '' }})</small>
                    </p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="text-muted">Status</label>
                    <p>
                        @if($branchTransfer->status == 'approved')
                            <span class="badge bg-success">Approved</span>
                        @elseif($branchTransfer->status == 'pending')
                            <span class="badge bg-warning">Pending</span>
                        @else
                            <span class="badge bg-danger">Rejected</span>
                        @endif
                    </p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="text-muted">From Branch</label>
                    <p class="fw-bold">{{ $branchTransfer->fromBranch->city ?? 'N/A' }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="text-muted">To Branch</label>
                    <p class="fw-bold">{{ $branchTransfer->toBranch->city ?? 'N/A' }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="text-muted">Requested By</label>
                    <p class="fw-bold">{{ $branchTransfer->requestedBy->name ?? 'N/A' }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="text-muted">Approved By</label>
                    <p class="fw-bold">{{ $branchTransfer->approvedBy->name ?? 'N/A' }}</p>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="text-muted">Requested Date</label>
                    <p class="fw-bold">{{ $branchTransfer->requested_date?->format('d M Y') }}</p>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="text-muted">Approved Date</label>
                    <p class="fw-bold">{{ $branchTransfer->approved_date?->format('d M Y') ?? 'N/A' }}</p>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="text-muted">Completed Date</label>
                    <p class="fw-bold">{{ $branchTransfer->completed_date?->format('d M Y') ?? 'N/A' }}</p>
                </div>
                @if($branchTransfer->reason)
                <div class="col-md-12 mb-3">
                    <label class="text-muted">Reason</label>
                    <p>{{ $branchTransfer->reason }}</p>
                </div>
                @endif
            </div>

            <a href="{{ route('branch-transfers.index') }}" class="btn btn-secondary">← Back</a>

            @if(auth()->user()->isHO() && $branchTransfer->status == 'pending')
            <form action="{{ route('branch-transfers.approve', $branchTransfer) }}" method="POST" class="d-inline ms-2">
                @csrf
                <button type="submit" class="btn btn-success">
                    <i class="bx bx-check me-1"></i> Approve
                </button>
            </form>
            <form action="{{ route('branch-transfers.reject', $branchTransfer) }}" method="POST" class="d-inline ms-2">
                @csrf
                <button type="submit" class="btn btn-danger" onclick="return confirm('Reject this transfer?')">
                    <i class="bx bx-x me-1"></i> Reject
                </button>
            </form>
            @endif
        </div>
    </div>
</div>
@endsection