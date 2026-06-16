@extends('layouts.app')
@section('title', 'Purchases')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold"><i class="bx bx-purchase-tag-alt me-2"></i> Purchases</h4>
        @if(!auth()->user()->isSalesStaff())
        <a href="{{ route('purchases.create') }}" class="btn btn-primary">
            <i class="bx bx-plus me-2"></i> Add Purchase
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
                            <th>Supplier</th>
                            <th>Branch</th>
                            <th>Purchase Price</th>
                            <th>Payment Method</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($purchases as $purchase)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $purchase->vehicle->make ?? '' }} {{ $purchase->vehicle->model ?? 'N/A' }}</td>
                            <td>{{ $purchase->supplier_name }}</td>
                            <td>{{ $purchase->branch->city ?? 'N/A' }}</td>
                            <td>Rs. {{ number_format($purchase->purchase_price) }}</td>
                            <td>{{ ucfirst($purchase->payment_method) }}</td>
                            <td>{{ \Carbon\Carbon::parse($purchase->purchase_date)->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('purchases.show', $purchase) }}" class="btn btn-sm btn-info"><i class="bx bx-show"></i></a>
                                @if(!auth()->user()->isSalesStaff())
                                <a href="{{ route('purchases.edit', $purchase) }}" class="btn btn-sm btn-warning"><i class="bx bx-edit"></i></a>
                                @endif
                                @if(auth()->user()->isHO())
                                <form action="{{ route('purchases.destroy', $purchase) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Delete?')"><i class="bx bx-trash"></i></button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="8" class="text-center py-4 text-muted">No purchases found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $purchases->links() }}
        </div>
    </div>
</div>
@endsection