@extends('layouts.app')
@section('title', 'Purchase Details')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4">Purchase Details</h4>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3"><label class="text-muted">Vehicle</label><p class="fw-bold">{{ $purchase->vehicle->make ?? '' }} {{ $purchase->vehicle->model ?? 'N/A' }}</p></div>
                <div class="col-md-6 mb-3"><label class="text-muted">Branch</label><p class="fw-bold">{{ $purchase->branch->city ?? 'N/A' }}</p></div>
                <div class="col-md-6 mb-3"><label class="text-muted">Supplier</label><p class="fw-bold">{{ $purchase->supplier_name }}</p></div>
                <div class="col-md-6 mb-3"><label class="text-muted">Contact</label><p class="fw-bold">{{ $purchase->supplier_contact ?? 'N/A' }}</p></div>
                <div class="col-md-4 mb-3"><label class="text-muted">Purchase Price</label><p class="fw-bold">Rs. {{ number_format($purchase->purchase_price) }}</p></div>
                <div class="col-md-4 mb-3"><label class="text-muted">Payment Method</label><p class="fw-bold">{{ ucfirst($purchase->payment_method) }}</p></div>
                <div class="col-md-4 mb-3"><label class="text-muted">Reference No</label><p class="fw-bold">{{ $purchase->reference_no ?? 'N/A' }}</p></div>
                <div class="col-md-6 mb-3"><label class="text-muted">Date</label><p class="fw-bold">{{ \Carbon\Carbon::parse($purchase->purchase_date)->format('d M Y') }}</p></div>
                <div class="col-md-12 mb-3"><label class="text-muted">Notes</label><p>{{ $purchase->notes ?? 'N/A' }}</p></div>
            </div>
            <a href="{{ route('purchases.index') }}" class="btn btn-secondary">← Back</a>
            @if(!auth()->user()->isSalesStaff())
            <a href="{{ route('purchases.edit', $purchase) }}" class="btn btn-warning ms-2">Edit</a>
            @endif
        </div>
    </div>
</div>
@endsection