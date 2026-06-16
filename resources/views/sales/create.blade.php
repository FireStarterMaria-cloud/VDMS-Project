@extends('layouts.app')
@section('title', 'Add Sale')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4"><i class="bx bx-receipt me-2"></i> Add New Sale</h4>

    <div class="card">
        <div class="card-body">
            @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
            </div>
            @endif

            <form action="{{ route('sales.store') }}" method="POST">
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
                        <label class="form-label">Customer <span class="text-danger">*</span></label>
                        <select name="customer_id" class="form-select" required>
                            <option value="">Select Customer</option>
                            @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                {{ $customer->name }} — {{ $customer->phone }}
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
                        <label class="form-label">Sale Date <span class="text-danger">*</span></label>
                        <input type="date" name="sale_date" class="form-control" value="{{ old('sale_date', date('Y-m-d')) }}" required />
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Sale Price (Rs.) <span class="text-danger">*</span></label>
                        <input type="number" name="sale_price" class="form-control" value="{{ old('sale_price') }}" required />
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Discount (Rs.)</label>
                        <input type="number" name="discount" class="form-control" value="{{ old('discount', 0) }}" />
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Final Price (Rs.) <span class="text-danger">*</span></label>
                        <input type="number" name="final_price" class="form-control" value="{{ old('final_price') }}" required />
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select" required>
                            <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" class="form-control" rows="3">{{ old('notes') }}</textarea>
                    </div>
                </div>
                <div class="mt-2">
                    <button type="submit" class="btn btn-primary me-2">Save Sale</button>
                    <a href="{{ route('sales.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection