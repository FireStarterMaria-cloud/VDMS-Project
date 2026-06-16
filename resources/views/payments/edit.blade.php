@extends('layouts.app')
@section('title', 'Edit Payment')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4">Edit Payment</h4>
    <div class="card">
        <div class="card-body">
            @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
            </div>
            @endif
            <form action="{{ route('payments.update', $payment) }}" method="POST">
                @csrf @method('PUT')
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Sale</label>
                        <select name="sale_id" class="form-select" required>
                            @foreach($sales as $sale)
                            <option value="{{ $sale->id }}" {{ $payment->sale_id == $sale->id ? 'selected' : '' }}>
                                Sale #{{ $sale->id }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Branch</label>
                        <select name="branch_id" class="form-select" required>
                            @foreach($branches as $branch)
                            <option value="{{ $branch->id }}" {{ $payment->branch_id == $branch->id ? 'selected' : '' }}>
                                {{ $branch->city }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Amount</label>
                        <input type="number" name="amount" class="form-control" value="{{ old('amount', $payment->amount) }}" required />
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Payment Method</label>
                        <select name="payment_method" class="form-select" required>
                            <option value="cash" {{ $payment->payment_method == 'cash' ? 'selected' : '' }}>Cash</option>
                            <option value="cheque" {{ $payment->payment_method == 'cheque' ? 'selected' : '' }}>Cheque</option>
                            <option value="bank_transfer" {{ $payment->payment_method == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                            <option value="jazzcash" {{ $payment->payment_method == 'jazzcash' ? 'selected' : '' }}>JazzCash</option>
                            <option value="stripe" {{ $payment->payment_method == 'stripe' ? 'selected' : '' }}>Stripe</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="pending" {{ $payment->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="completed" {{ $payment->status == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="failed" {{ $payment->status == 'failed' ? 'selected' : '' }}>Failed</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Reference No</label>
                        <input type="text" name="reference_no" class="form-control" value="{{ old('reference_no', $payment->reference_no) }}" />
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Payment Date</label>
                        <input type="date" name="payment_date" class="form-control" value="{{ old('payment_date', \Carbon\Carbon::parse($payment->payment_date)->format('Y-m-d')) }}" required />
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" class="form-control" rows="3">{{ old('notes', $payment->notes) }}</textarea>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary me-2">Update</button>
                <a href="{{ route('payments.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection