@extends('layouts.app')
@section('title', 'Create Invoice')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4">Create Invoice</h4>
    <div class="card">
        <div class="card-body">
            @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
            </div>
            @endif
            <form action="{{ route('invoices.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Sale <span class="text-danger">*</span></label>
                        <select name="sale_id" class="form-select" required>
                            <option value="">Select Sale</option>
                            @foreach($sales as $sale)
                            <option value="{{ $sale->id }}" {{ old('sale_id') == $sale->id ? 'selected' : '' }}>
                                Sale #{{ $sale->id }} — {{ $sale->customer->name ?? 'N/A' }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Branch <span class="text-danger">*</span></label>
                        <select name="branch_id" class="form-select" required>
                            <option value="">Select Branch</option>
                            @foreach($branches as $branch)
                            <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                                {{ $branch->city }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Invoice No <span class="text-danger">*</span></label>
                        <input type="text" name="invoice_no" class="form-control" value="{{ old('invoice_no', 'INV-' . date('Ymd') . '-' . rand(100,999)) }}" required />
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select" required>
                            <option value="draft">Draft</option>
                            <option value="issued">Issued</option>
                            <option value="paid">Paid</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Subtotal <span class="text-danger">*</span></label>
                        <input type="number" name="subtotal" class="form-control" value="{{ old('subtotal') }}" required />
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Tax</label>
                        <input type="number" name="tax" class="form-control" value="{{ old('tax', 0) }}" />
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Discount</label>
                        <input type="number" name="discount" class="form-control" value="{{ old('discount', 0) }}" />
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Total Amount <span class="text-danger">*</span></label>
                        <input type="number" name="total_amount" class="form-control" value="{{ old('total_amount') }}" required />
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Issue Date <span class="text-danger">*</span></label>
                        <input type="date" name="issue_date" class="form-control" value="{{ old('issue_date', date('Y-m-d')) }}" required />
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Due Date</label>
                        <input type="date" name="due_date" class="form-control" value="{{ old('due_date') }}" />
                    </div>
                </div>
                <button type="submit" class="btn btn-primary me-2">Create Invoice</button>
                <a href="{{ route('invoices.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection