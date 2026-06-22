@extends('layouts.app')
@section('title', 'Invoice Details')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0"><i class="bx bx-file me-2"></i>Invoice #{{ $invoice->invoice_no }}</h4>
        <div class="d-flex gap-2">
            <a href="{{ route('invoices.index') }}" class="btn btn-secondary">
                <i class="bx bx-arrow-back"></i> Back
            </a>
            <a href="{{ route('invoices.edit', $invoice) }}" class="btn btn-warning">
                <i class="bx bx-edit"></i> Edit
            </a>
        </div>
    </div>

    {{-- Action Buttons --}}
    <div class="card mb-4">
        <div class="card-body">
            <div class="row g-2">
                <div class="col-md-3">
                    <form action="{{ route('invoices.send-email', $invoice) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-primary w-100">
                            <i class="bx bx-envelope me-1"></i> Email to Customer
                        </button>
                    </form>
                </div>
                <div class="col-md-3">
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $invoice->sale->customer->phone ?? '') }}?text={{ urlencode('Hi ' . ($invoice->sale->customer->name ?? '') . ', here is your invoice #' . $invoice->invoice_no . ' — Total: Rs.' . number_format($invoice->total_amount) . '. View: ' . route('invoices.show', $invoice)) }}"
                       target="_blank" class="btn btn-outline-success w-100">
                        <i class="bx bxl-whatsapp me-1"></i> Share via WhatsApp
                    </a>
                </div>
                <div class="col-md-3">
                    @if(auth()->user()->isHO())
                    <span class="btn btn-outline-secondary w-100 disabled">
                        <i class="bx bx-shield-quarter me-1"></i> You are Admin
                    </span>
                    @else
                    <form action="{{ route('invoices.send-approval', $invoice) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-warning w-100">
                            <i class="bx bx-shield-quarter me-1"></i> Send for Approval
                        </button>
                    </form>
                    @endif
                </div>
                <div class="col-md-3">
                    <button onclick="window.print()" class="btn btn-outline-dark w-100">
                        <i class="bx bx-printer me-1"></i> Print Invoice
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Printable Invoice --}}
    <div class="card" id="printableInvoice">
        <div class="card-body p-5">
            {{-- Header --}}
            <div class="d-flex justify-content-between align-items-start mb-5 pb-4 border-bottom">
                <div class="d-flex align-items-center gap-2">
                    <img src="{{ asset('assets/img/logo/velora_logo.svg') }}" alt="Velora" style="height:50px;">
                    <div>
                        <h4 class="mb-0 fw-bold">VELORA</h4>
                        <small class="text-muted">Vehicle Management System</small>
                    </div>
                </div>
                <div class="text-end">
                    <h5 class="fw-bold mb-1">INVOICE</h5>
                    <span class="badge bg-{{ $invoice->status == 'paid' ? 'success' : ($invoice->status == 'issued' ? 'info' : ($invoice->status == 'draft' ? 'warning' : 'danger')) }} fs-6">
                        {{ ucfirst($invoice->status) }}
                    </span>
                </div>
            </div>

            {{-- Invoice + Customer Info --}}
            <div class="row mb-5">
                <div class="col-md-6">
                    <h6 class="text-muted mb-2">BILL TO</h6>
                    <h6 class="fw-bold mb-1">{{ $invoice->sale->customer->name ?? 'N/A' }}</h6>
                    <p class="mb-0 small">{{ $invoice->sale->customer->phone ?? '' }}</p>
                    <p class="mb-0 small">{{ $invoice->sale->customer->email ?? '' }}</p>
                    <p class="mb-0 small">{{ $invoice->sale->customer->address ?? '' }}</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <table class="table table-borderless table-sm mb-0 ms-auto" style="max-width:280px;">
                        <tr>
                            <td class="text-muted">Invoice No:</td>
                            <td class="fw-bold">{{ $invoice->invoice_no }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Issue Date:</td>
                            <td class="fw-bold">{{ \Carbon\Carbon::parse($invoice->issue_date)->format('d M Y') }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Due Date:</td>
                            <td class="fw-bold">{{ $invoice->due_date ? \Carbon\Carbon::parse($invoice->due_date)->format('d M Y') : 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Branch:</td>
                            <td class="fw-bold">{{ $invoice->branch->city ?? 'N/A' }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            {{-- Line Items --}}
            <div class="table-responsive mb-4">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Description</th>
                            <th class="text-end">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                {{ $invoice->sale->vehicle->make ?? '' }} {{ $invoice->sale->vehicle->model ?? '' }}
                                ({{ $invoice->sale->vehicle->registration_number ?? '' }})
                            </td>
                            <td class="text-end">Rs. {{ number_format($invoice->subtotal) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Totals --}}
            <div class="row">
                <div class="col-md-6"></div>
                <div class="col-md-6">
                    <table class="table table-borderless table-sm">
                        <tr>
                            <td>Subtotal</td>
                            <td class="text-end">Rs. {{ number_format($invoice->subtotal) }}</td>
                        </tr>
                        <tr>
                            <td>Tax</td>
                            <td class="text-end">Rs. {{ number_format($invoice->tax ?? 0) }}</td>
                        </tr>
                        <tr>
                            <td>Discount</td>
                            <td class="text-end">- Rs. {{ number_format($invoice->discount ?? 0) }}</td>
                        </tr>
                        <tr class="border-top">
                            <td class="fw-bold fs-5">Total</td>
                            <td class="text-end fw-bold fs-5 text-success">Rs. {{ number_format($invoice->total_amount) }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="mt-5 pt-4 border-top text-center text-muted small">
                Thank you for your business with Velora VMS — Vehicle Management System
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .btn, .card.mb-4, nav, aside, footer { display: none !important; }
    #printableInvoice { box-shadow: none !important; border: none !important; }
}
</style>
@endsection