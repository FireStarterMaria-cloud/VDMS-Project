@extends('layouts.app')
@section('title', 'Edit Sale')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4"><i class="bx bx-receipt me-2"></i> Edit Sale</h4>
    <div class="card">
        <div class="card-body">
            @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
            </div>
            @endif
            <form action="{{ route('sales.update', $sale) }}" method="POST">
                @csrf @method('PUT')
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Vehicle</label>
                        <select name="vehicle_id" class="form-select" required>
                            @foreach($vehicles as $vehicle)
                            <option value="{{ $vehicle->id }}" {{ $sale->vehicle_id == $vehicle->id ? 'selected' : '' }}>
                                {{ $vehicle->registration_number }} — {{ $vehicle->make }} {{ $vehicle->model }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Customer</label>
                        <select name="customer_id" class="form-select" required>
                            @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" {{ $sale->customer_id == $customer->id ? 'selected' : '' }}>
                                {{ $customer->name }} — {{ $customer->phone }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Branch</label>
                        <select name="branch_id" class="form-select" required>
                            @foreach($branches as $branch)
                            <option value="{{ $branch->id }}" {{ $sale->branch_id == $branch->id ? 'selected' : '' }}>
                                {{ $branch->city }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Sale Date</label>
                        <input type="date" name="sale_date" class="form-control" value="{{ $sale->sale_date?->format('Y-m-d') }}" required />
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Sale Price</label>
                        <input type="number" name="sale_price" class="form-control" value="{{ $sale->sale_price }}" required />
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Discount</label>
                        <input type="number" name="discount" class="form-control" value="{{ $sale->discount }}" />
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Final Price</label>
                        <input type="number" name="final_price" class="form-control" value="{{ $sale->final_price }}" required />
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="pending" {{ $sale->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="completed" {{ $sale->status == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ $sale->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" class="form-control" rows="3">{{ $sale->notes }}</textarea>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary me-2">Update</button>
                <a href="{{ route('sales.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection