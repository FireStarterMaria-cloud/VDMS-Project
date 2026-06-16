@extends('layouts.app')
@section('title', 'Edit Purchase')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4">Edit Purchase</h4>
    <div class="card">
        <div class="card-body">
            @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
            </div>
            @endif
            <form action="{{ route('purchases.update', $purchase) }}" method="POST">
                @csrf @method('PUT')
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Vehicle</label>
                        <select name="vehicle_id" class="form-select" required>
                            @foreach($vehicles as $vehicle)
                            <option value="{{ $vehicle->id }}" {{ $purchase->vehicle_id == $vehicle->id ? 'selected' : '' }}>
                                {{ $vehicle->registration_number }} — {{ $vehicle->make }} {{ $vehicle->model }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Branch</label>
                        <select name="branch_id" class="form-select" required>
                            @foreach($branches as $branch)
                            <option value="{{ $branch->id }}" {{ $purchase->branch_id == $branch->id ? 'selected' : '' }}>
                                {{ $branch->city }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Supplier Name</label>
                        <input type="text" name="supplier_name" class="form-control" value="{{ old('supplier_name', $purchase->supplier_name) }}" required />
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Supplier Contact</label>
                        <input type="text" name="supplier_contact" class="form-control" value="{{ old('supplier_contact', $purchase->supplier_contact) }}" />
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Purchase Price</label>
                        <input type="number" name="purchase_price" class="form-control" value="{{ old('purchase_price', $purchase->purchase_price) }}" required />
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Payment Method</label>
                        <select name="payment_method" class="form-select" required>
                            <option value="cash" {{ $purchase->payment_method == 'cash' ? 'selected' : '' }}>Cash</option>
                            <option value="cheque" {{ $purchase->payment_method == 'cheque' ? 'selected' : '' }}>Cheque</option>
                            <option value="bank_transfer" {{ $purchase->payment_method == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Reference No</label>
                        <input type="text" name="reference_no" class="form-control" value="{{ old('reference_no', $purchase->reference_no) }}" />
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Purchase Date</label>
                        <input type="date" name="purchase_date" class="form-control" value="{{ old('purchase_date', \Carbon\Carbon::parse($purchase->purchase_date)->format('Y-m-d')) }}" required />
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" class="form-control" rows="3">{{ old('notes', $purchase->notes) }}</textarea>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary me-2">Update</button>
                <a href="{{ route('purchases.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection