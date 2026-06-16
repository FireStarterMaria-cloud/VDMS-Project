@extends('layouts.app')
@section('title', 'Sale Details')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4"><i class="bx bx-receipt me-2"></i> Sale Details</h4>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label text-muted">Vehicle</label>
                    <p class="fw-bold">{{ $sale->vehicle->make ?? '' }} {{ $sale->vehicle->model ?? 'N/A' }} ({{ $sale->vehicle->registration_number ?? '' }})</p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label text-muted">Customer</label>
                    <p class="fw-bold">{{ $sale->customer->name ?? 'N/A' }} — {{ $sale->customer->phone ?? '' }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label text-muted">Branch</label>
                    <p class="fw-bold">{{ $sale->branch->city ?? 'N/A' }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label text-muted">Sale Date</label>
                    <p class="fw-bold">{{ $sale->sale_date?->format('d M Y') }}</p>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label text-muted">Sale Price</label>
                    <p class="fw-bold">Rs. {{ number_format($sale->sale_price) }}</p>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label text-muted">Discount</label>
                    <p class="fw-bold">Rs. {{ number_format($sale->discount ?? 0) }}</p>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label text-muted">Final Price</label>
                    <p class="fw-bold text-success">Rs. {{ number_format($sale->final_price) }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label text-muted">Status</label>
                    <p>
                        @if($sale->status == 'completed')
                            <span class="badge bg-success">Completed</span>
                        @elseif($sale->status == 'pending')
                            <span class="badge bg-warning">Pending</span>
                        @else
                            <span class="badge bg-danger">Cancelled</span>
                        @endif
                    </p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label text-muted">Sold By</label>
                    <p class="fw-bold">{{ $sale->soldBy->name ?? 'N/A' }}</p>
                </div>
                @if($sale->notes)
                <div class="col-md-12 mb-3">
                    <label class="form-label text-muted">Notes</label>
                    <p>{{ $sale->notes }}</p>
                </div>
                @endif
            </div>
            <a href="{{ route('sales.index') }}" class="btn btn-secondary">← Back</a>
            @if(!auth()->user()->isAccountant() && !auth()->user()->isSalesStaff())
            <a href="{{ route('sales.edit', $sale) }}" class="btn btn-warning ms-2">Edit</a>
            @endif
        </div>
    </div>
</div>
@endsection