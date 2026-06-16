@extends('layouts.app')
@section('title', 'Invoice Details')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4">Invoice #{{ $invoice->invoice_no }}</h4>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3"><label class="text-muted">Invoice No</label><p class="fw-bold">{{ $invoice->invoice_no }}</p></div>
                <div class="col-md-6 mb-3"><label class="text-muted">Sale</label><p class="fw-bold">Sale #{{ $invoice->sale_id }}</p></div>
                <div class="col-md-6 mb-3"><label class="text-muted">Branch</label><p class="fw-bold">{{ $invoice->branch->city ?? 'N/A' }}</p></div>
                <div class="col-md-6 mb-3"><label class="text-muted">Status</label><p><span class="badge bg-{{ $invoice->status == 'paid' ? 'success' : ($invoice->status == 'issued' ? 'info' : ($invoice->status == 'draft' ? 'warning' : 'danger')) }}">{{ ucfirst($invoice->status) }}</span></p></div>
                <div class="col-md-3 mb-3"><label class="text-muted">Subtotal</label><p class="fw-bold">Rs. {{ number_format($invoice->subtotal) }}</p></div>
                <div class="col-md-3 mb-3"><label class="text-muted">Tax</label><p class="fw-bold">Rs. {{ number_format($invoice->tax ?? 0) }}</p></div>
                <div class="col-md-3 mb-3"><label class="text-muted">Discount</label><p class="fw-bold">Rs. {{ number_format($invoice->discount ?? 0) }}</p></div>
                <div class="col-md-3 mb-3"><label class="text-muted">Total</label><p class="fw-bold text-success fs-5">Rs. {{ number_format($invoice->total_amount) }}</p></div>
                <div class="col-md-6 mb-3"><label class="text-muted">Issue Date</label><p class="fw-bold">{{ \Carbon\Carbon::parse($invoice->issue_date)->format('d M Y') }}</p></div>
                <div class="col-md-6 mb-3"><label class="text-muted">Due Date</label><p class="fw-bold">{{ $invoice->due_date ? \Carbon\Carbon::parse($invoice->due_date)->format('d M Y') : 'N/A' }}</p></div>
            </div>
            <a href="{{ route('invoices.index') }}" class="btn btn-secondary">← Back</a>
            @if(auth()->user()->isHO() || auth()->user()->isAccountant())
            <a href="{{ route('invoices.edit', $invoice) }}" class="btn btn-warning ms-2">Edit</a>
            @endif
        </div>
    </div>
</div>
@endsection