@extends('layouts.app')
@section('title', 'Sales')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold"><i class="bx bx-receipt me-2"></i> Sales</h4>
        @if(!auth()->user()->isAccountant())
        <a href="{{ route('sales.create') }}" class="btn btn-primary">
            <i class="bx bx-plus me-2"></i> Add New Sale
        </a>
        @endif
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
                                <a href="{{ route('sales.show', $sale) }}" class="btn btn-sm btn-info"><i class="bx bx-show"></i></a>
                                @if(!auth()->user()->isAccountant() && !auth()->user()->isSalesStaff())
                                <a href="{{ route('sales.edit', $sale) }}" class="btn btn-sm btn-warning"><i class="bx bx-edit"></i></a>
                                @endif
                                @if(auth()->user()->isHO())
                                <form action="{{ route('sales.destroy', $sale) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Delete?')"><i class="bx bx-trash"></i></button>
                                </form>
                                @endif
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