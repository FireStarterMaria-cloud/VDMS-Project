@extends('layouts.app')

@section('title', 'Edit Vehicle')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bx bx-edit me-2"></i> Edit Vehicle
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('vehicles.update', $vehicle) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-4">
                            <!-- Branch -->
                            <div class="col-md-6">
                                <label class="form-label">Branch <span class="text-danger">*</span></label>
                                <select name="branch_id" class="form-select" required>
                                    @foreach($branches as $branch)
                                        <option value="{{ $branch->id }}" 
                                            {{ $vehicle->branch_id == $branch->id ? 'selected' : '' }}>
                                            {{ $branch->city }} Branch
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Registration No -->
                            <div class="col-md-6">
                                <label class="form-label">Registration No <span class="text-danger">*</span></label>
                                <input type="text" name="registration_no" 
                                       value="{{ $vehicle->registration_no }}" 
                                       class="form-control" required>
                            </div>

                            <!-- Make -->
                            <div class="col-md-6">
                                <label class="form-label">Make <span class="text-danger">*</span></label>
                                <input type="text" name="make" value="{{ $vehicle->make }}" 
                                       class="form-control" required>
                            </div>

                            <!-- Model -->
                            <div class="col-md-6">
                                <label class="form-label">Model <span class="text-danger">*</span></label>
                                <input type="text" name="model" value="{{ $vehicle->model }}" 
                                       class="form-control" required>
                            </div>

                            <!-- Year, Colour, Status -->
                            <div class="col-md-4">
                                <label class="form-label">Year <span class="text-danger">*</span></label>
                                <input type="number" name="year" value="{{ $vehicle->year }}" 
                                       class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Colour <span class="text-danger">*</span></label>
                                <input type="text" name="colour" value="{{ $vehicle->colour }}" 
                                       class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-select">
                                    <option value="available" {{ $vehicle->status == 'available' ? 'selected' : '' }}>Available</option>
                                    <option value="reserved" {{ $vehicle->status == 'reserved' ? 'selected' : '' }}>Reserved</option>
                                    <option value="sold" {{ $vehicle->status == 'sold' ? 'selected' : '' }}>Sold</option>
                                </select>
                            </div>

                            <!-- Selling Price -->
                            <div class="col-md-6">
                                <label class="form-label">Selling Price (Rs) <span class="text-danger">*</span></label>
                                <input type="number" name="selling_price" 
                                       value="{{ $vehicle->selling_price }}" 
                                       class="form-control" required>
                            </div>

                            <!-- Description -->
                            <div class="col-12">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="4">{{ $vehicle->description }}</textarea>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary me-2">Update Vehicle</button>
                            <a href="{{ route('vehicles.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection