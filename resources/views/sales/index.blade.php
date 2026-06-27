@extends('layouts.app')
@section('title', 'Sales')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">
        <i class="bx bx-receipt me-2"></i> Sales Management
    </h4>
    <div class="d-flex gap-2">
        <a href="{{ route('pdf.sales') }}" 
           class="btn btn-sm"
           target="_blank"
           style="background:#696cff; color:#fff; border:none;">
            <i class="bx bx-file-pdf me-1"></i> Download PDF
        </a>
        @if(!auth()->user()->isAccountant())
        <a href="{{ route('sales.create') }}" class="btn btn-primary btn-sm">
            <i class="bx bx-plus me-1"></i> New Sale
        </a>
        @endif
    </div>
</div>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Vehicle</th>
                            <th>Customer</th>
                            <th>Branch</th>
                            <th>Sale Price</th>
                            <th>Final Price</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sales as $sale)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $sale->vehicle->make ?? '' }} {{ $sale->vehicle->model ?? 'N/A' }}</td>
                            <td>{{ $sale->customer->name ?? 'N/A' }}</td>
                            <td>{{ $sale->branch->city ?? 'N/A' }}</td>
                            <td>Rs. {{ number_format($sale->sale_price) }}</td>
                            <td>Rs. {{ number_format($sale->final_price) }}</td>
                            <td>
                                @if($sale->status == 'completed')
                                    <span class="badge bg-success">Completed</span>
                                @elseif($sale->status == 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @else
                                    <span class="badge bg-danger">Cancelled</span>
                                @endif
                            </td>
                            <td>{{ $sale->sale_date?->format('d M Y') }}</td>
                            <td>
    <div class="btn-group btn-group-sm" role="group">
        <a href="{{ route('sales.show', $sale) }}" class="btn btn-sm btn-icon text-info" title="View">
            <i class="bx bx-show fs-5"></i>
        </a>
        @if(!auth()->user()->isAccountant() && !auth()->user()->isSalesStaff())
        <a href="{{ route('sales.edit', $sale) }}" class="btn btn-sm btn-icon text-warning" title="Edit">
            <i class="bx bx-edit fs-5"></i>
        </a>
        @endif
        @if(auth()->user()->isHO())
        <form action="{{ route('sales.destroy', $sale) }}" method="POST" class="d-inline"
              onsubmit="return confirm('Delete this sale?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-sm btn-icon text-danger" title="Delete">
                <i class="bx bx-trash fs-5"></i>
            </button>
        </form>
        @endif
    </div>
</td>
                        </tr>
                        @empty
                        <tr><td colspan="9" class="text-center py-4 text-muted">No sales found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $sales->links() }}
        </div>
    </div>
</div>
@endsection