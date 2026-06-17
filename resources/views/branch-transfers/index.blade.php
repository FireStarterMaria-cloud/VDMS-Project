@extends('layouts.app')
@section('title', 'Branch Transfers')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold"><i class="bx bx-transfer me-2"></i> Branch Transfers</h4>
        @if(!auth()->user()->isSalesStaff() && !auth()->user()->isAccountant())
        <a href="{{ route('branch-transfers.create') }}" class="btn btn-primary">
            <i class="bx bx-plus me-2"></i> New Transfer Request
        </a>
        @endif
    </div>

    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Vehicle</th>
                            <th>From Branch</th>
                            <th>To Branch</th>
                            <th>Requested By</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transfers as $transfer)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $transfer->vehicle->make ?? '' }} {{ $transfer->vehicle->model ?? 'N/A' }}<br>
                                <small class="text-muted">{{ $transfer->vehicle->registration_number ?? '' }}</small>
                            </td>
                            <td>{{ $transfer->fromBranch->city ?? 'N/A' }}</td>
                            <td>{{ $transfer->toBranch->city ?? 'N/A' }}</td>
                            <td>{{ $transfer->requestedBy->name ?? 'N/A' }}</td>
                            <td>
                                @if($transfer->status == 'approved')
                                    <span class="badge bg-success">Approved</span>
                                @elseif($transfer->status == 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @else
                                    <span class="badge bg-danger">Rejected</span>
                                @endif
                            </td>
                            <td>{{ $transfer->requested_date?->format('d M Y') }}</td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('branch-transfers.show', $transfer) }}" class="btn btn-sm btn-icon text-info" title="View">
                                        <i class="bx bx-show fs-5"></i>
                                    </a>
                                    @if(auth()->user()->isHO() && $transfer->status == 'pending')
                                    <form action="{{ route('branch-transfers.approve', $transfer) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-icon text-success" title="Approve">
                                            <i class="bx bx-check fs-5"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('branch-transfers.reject', $transfer) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-icon text-danger" title="Reject"
                                                onclick="return confirm('Reject this transfer?')">
                                            <i class="bx bx-x fs-5"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="8" class="text-center py-4 text-muted">No transfers found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $transfers->links() }}
        </div>
    </div>
</div>
@endsection