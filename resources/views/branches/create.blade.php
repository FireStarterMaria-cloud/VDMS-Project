@extends('layouts.app')
@section('title', 'Add Branch')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4">Add Branch</h4>
    <div class="card">
        <div class="card-body">
            @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
            </div>
            @endif
            <form action="{{ route('branches.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Branch Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required />
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">City <span class="text-danger">*</span></label>
                        <input type="text" name="city" class="form-control" value="{{ old('city') }}" required />
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Country</label>
                        <input type="text" name="country" class="form-control" value="{{ old('country', 'Pakistan') }}" />
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" />
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" />
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Currency</label>
                        <input type="text" name="currency" class="form-control" value="{{ old('currency', 'PKR') }}" />
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Exchange Rate</label>
                        <input type="number" step="0.01" name="exchange_rate" class="form-control" value="{{ old('exchange_rate', 1) }}" />
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-control" rows="2">{{ old('address') }}</textarea>
                    </div>
                    <div class="col-md-12 mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" checked />
                            <label class="form-check-label" for="is_active">Active Branch</label>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary me-2">Save Branch</button>
                <a href="{{ route('branches.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection