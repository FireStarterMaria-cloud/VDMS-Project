@extends('layouts.app')
@section('title', 'Edit Invoice')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4">Edit Invoice</h4>
    <div class="card">
        <div class="card-body">
            @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
            </div>
            @endif
            <form action="{{ route('invoices.update', $invoice) }}" method="POST">
                @csrf @method('PUT')
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Sale</label>
                        <select name="sale_id" class="form-select" required>
                            @foreach($sales as $sale)
                            <option value="{{ $sale->id }}" {{ $invoice->sale_id == $sale->id ? 'selected' : '' }}>Sale #{{ $sale->id }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Branch</label>
                        <select name="branch_id" class="form-select" required>
                            @foreach($branches as $branch)
                            <option value="{{ $branch->id }}" {{ $invoice->branch_id == $branch->id ? 'selected' : '' }}>{{ $branch->city }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Invoice No</label>
                        <input type="text" name="invoice_no" class="form-control" value="{{ old('invoice_no', $invoice->invoice_no) }}" required />
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="draft" {{ $invoice->status == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="issued" {{ $invoice->status == 'issued' ? 'selected' : '' }}>Issued</option>
                            <option value="paid" {{ $invoice->status == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="cancelled" {{ $invoice->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Subtotal</label>
                        <input type="number" name="subtotal" class="form-control" value="{{ old('subtotal', $invoice->subtotal) }}" required />
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Tax</label>
                        <input type="number" name="tax" class="form-control" value="{{ old('tax', $invoice->tax) }}" />
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Discount</label>
                        <input type="number" name="discount" class="form-control" value="{{ old('discount', $invoice->discount) }}" />
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Total Amount</label>
                        <input type="number" name="total_amount" class="form-control" value="{{ old('total_amount', $invoice->total_amount) }}" required />
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Issue Date</label>
                        <input type="date" name="issue_date" class="form-control" value="{{ old('issue_date', \Carbon\Carbon::parse($invoice->issue_date)->format('Y-m-d')) }}" required />
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Due Date</label>
                        <input type="date" name="due_date" class="form-control" value="{{ old('due_date', $invoice->due_date ? \Carbon\Carbon::parse($invoice->due_date)->format('Y-m-d') : '') }}" />
                    </div>
                </div>
                <button type="submit" class="btn btn-primary me-2">Update</button>
                <a href="{{ route('invoices.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection