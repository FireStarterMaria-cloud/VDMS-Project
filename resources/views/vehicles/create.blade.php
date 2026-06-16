@extends('layouts.app')

@section('title', 'Add New Vehicle')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bx bx-car me-2"></i> Add New Vehicle</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('vehicles.store') }}" method="POST">
                        @csrf

                        <div class="row g-4">
                            <!-- Branch -->
                            <div class="col-md-6">
                                <label class="form-label">Branch <span class="text-danger">*</span></label>
                                <select name="branch_id" class="form-select @error('branch_id') is-invalid @enderror" required>
                                    <option value="">Select Branch</option>
                                    @foreach($branches as $branch)
                                        <option value="{{ $branch->id }}">{{ $branch->city }} Branch</option>
                                    @endforeach
                                </select>
                                @error('branch_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Registration No -->
                            <div class="col-md-6">
                                <label class="form-label">Registration No <span class="text-danger">*</span></label>
                                <input type="text" name="registration_no" class="form-control @error('registration_no') is-invalid @enderror" required>
                                @error('registration_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Make -->
                            <div class="col-md-6">
                                <label class="form-label">Make <span class="text-danger">*</span></label>
                                <input type="text" name="make" value="Toyota" class="form-control" required>
                            </div>

                            <!-- Model -->
                            <div class="col-md-6">
                                <label class="form-label">Model <span class="text-danger">*</span></label>
                                <input type="text" name="model" class="form-control @error('model') is-invalid @enderror" required>
                                @error('model')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Year, Colour, Status -->
                            <div class="col-md-4">
                                <label class="form-label">Year <span class="text-danger">*</span></label>
                                <input type="number" name="year" class="form-control" value="2024" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Colour <span class="text-danger">*</span></label>
                                <input type="text" name="colour" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-select">
                                    <option value="available" selected>Available</option>
                                    <option value="reserved">Reserved</option>
                                    <option value="sold">Sold</option>
                                </select>
                            </div>

                            <!-- Selling Price -->
                            <div class="col-md-6">
                                <label class="form-label">Selling Price (Rs) <span class="text-danger">*</span></label>
                                <input type="number" name="selling_price" class="form-control" required>
                            </div>

                            <!-- Description -->
                            <div class="col-12">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="4"></textarea>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary me-2">Save Vehicle</button>
                            <a href="{{ route('vehicles.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection