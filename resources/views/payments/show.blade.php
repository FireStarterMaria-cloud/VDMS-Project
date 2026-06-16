@extends('layouts.app')
@section('title', 'Payment Details')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4">Payment Details</h4>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3"><label class="text-muted">Sale</label><p class="fw-bold">Sale #{{ $payment->sale_id }}</p></div>
                <div class="col-md-6 mb-3"><label class="text-muted">Branch</label><p class="fw-bold">{{ $payment->branch->city ?? 'N/A' }}</p></div>
                <div class="col-md-4 mb-3"><label class="text-muted">Amount</label><p class="fw-bold text-success">Rs. {{ number_format($payment->amount) }}</p></div>
                <div class="col-md-4 mb-3"><label class="text-muted">Method</label><p class="fw-bold">{{ ucfirst($payment->payment_method) }}</p></div>
                <div class="col-md-4 mb-3"><label class="text-muted">Status</label><p><span class="badge bg-{{ $payment->status == 'completed' ? 'success' : ($payment->status == 'pending' ? 'warning' : 'danger') }}">{{ ucfirst($payment->status) }}</span></p></div>
                <div class="col-md-6 mb-3"><label class="text-muted">Reference No</label><p class="fw-bold">{{ $payment->reference_no ?? 'N/A' }}</p></div>
                <div class="col-md-6 mb-3"><label class="text-muted">Date</label><p class="fw-bold">{{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}</p></div>
                <div class="col-md-12 mb-3"><label class="text-muted">Notes</label><p>{{ $payment->notes ?? 'N/A' }}</p></div>
            </div>
            <a href="{{ route('payments.index') }}" class="btn btn-secondary">← Back</a>
        </div>
    </div>
</div>
@endsection