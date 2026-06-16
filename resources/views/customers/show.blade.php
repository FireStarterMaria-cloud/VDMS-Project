@extends('layouts.app')
@section('title', 'Customer Details')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4"><i class="bx bx-user me-2"></i> Customer Details</h4>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="text-muted">Full Name</label>
                    <p class="fw-bold">{{ $customer->name }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="text-muted">CNIC</label>
                    <p class="fw-bold">{{ $customer->cnic ?? 'N/A' }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="text-muted">Phone</label>
                    <p class="fw-bold">{{ $customer->phone }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="text-muted">Email</label>
                    <p class="fw-bold">{{ $customer->email ?? 'N/A' }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="text-muted">City</label>
                    <p class="fw-bold">{{ $customer->city ?? 'N/A' }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="text-muted">Branch</label>
                    <p class="fw-bold">{{ $customer->branch->city ?? 'N/A' }}</p>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="text-muted">Address</label>
                    <p class="fw-bold">{{ $customer->address ?? 'N/A' }}</p>
                </div>
            </div>

            @if($customer->sales->count() > 0)
            <h5 class="mt-3">Purchase History</h5>
            <table class="table table-sm table-bordered">
                <thead class="table-light">
                    <tr><th>Vehicle</th><th>Final Price</th><th>Date</th><th>Status</th></tr>
                </thead>
                <tbody>
                    @foreach($customer->sales as $sale)
                    <tr>
                        <td>{{ $sale->vehicle->make ?? '' }} {{ $sale->vehicle->model ?? '' }}</td>
                        <td>Rs. {{ number_format($sale->final_price) }}</td>
                        <td>{{ $sale->sale_date?->format('d M Y') }}</td>
                        <td><span class="badge bg-{{ $sale->status == 'completed' ? 'success' : ($sale->status == 'pending' ? 'warning' : 'danger') }}">{{ ucfirst($sale->status) }}</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif

            <a href="{{ route('customers.index') }}" class="btn btn-secondary mt-3">← Back</a>
            @if(!auth()->user()->isAccountant())
            <a href="{{ route('customers.edit', $customer) }}" class="btn btn-warning mt-3 ms-2">Edit</a>
            @endif
        </div>
    </div>
</div>
@endsection