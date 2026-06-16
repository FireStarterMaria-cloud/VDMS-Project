@extends('layouts.app')
@section('title', 'Add Purchase')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4"><i class="bx bx-purchase-tag-alt me-2"></i> Add Purchase</h4>
    <div class="card">
        <div class="card-body">
            @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
            </div>
            @endif
            <form action="{{ route('purchases.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Vehicle <span class="text-danger">*</span></label>
                        <select name="vehicle_id" class="form-select" required>
                            <option value="">Select Vehicle</option>
                            @foreach($vehicles as $vehicle)
                            <option value="{{ $vehicle->id }}" {{ old('vehicle_id') == $vehicle->id ? 'selected' : '' }}>
                                {{ $vehicle->registration_number }} — {{ $vehicle->make }} {{ $vehicle->model }}
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
                        <label class="form-label">Supplier Name <span class="text-danger">*</span></label>
                        <input type="text" name="supplier_name" class="form-control" value="{{ old('supplier_name') }}" required />
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Supplier Contact</label>
                        <input type="text" name="supplier_contact" class="form-control" value="{{ old('supplier_contact') }}" />
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Purchase Price <span class="text-danger">*</span></label>
                        <input type="number" name="purchase_price" class="form-control" value="{{ old('purchase_price') }}" required />
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Payment Method <span class="text-danger">*</span></label>
                        <select name="payment_method" class="form-select" required>
                            <option value="cash">Cash</option>
                            <option value="cheque">Cheque</option>
                            <option value="bank_transfer">Bank Transfer</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Reference No</label>
                        <input type="text" name="reference_no" class="form-control" value="{{ old('reference_no') }}" />
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Purchase Date <span class="text-danger">*</span></label>
                        <input type="date" name="purchase_date" class="form-control" value="{{ old('purchase_date', date('Y-m-d')) }}" required />
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" class="form-control" rows="3">{{ old('notes') }}</textarea>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary me-2">Save</button>
                <a href="{{ route('purchases.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection