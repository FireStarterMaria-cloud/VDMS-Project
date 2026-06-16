@extends('layouts.app')

@section('title', 'Vehicles Management')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">
            <i class="bx bx-car me-2"></i> Vehicles Management
        </h4>
        @if(auth()->user()->isSuperAdmin() || auth()->user()->isHOAdmin() || auth()->user()->isBranchManager())
<a href="{{ route('vehicles.create') }}" class="btn btn-primary">
    <i class="bx bx-plus me-2"></i> Add New Vehicle
</a>
@endif
    </div>

    <!-- Search & Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('vehicles.index') }}" class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" 
                           placeholder="Search by Registration, Model or VIN..." 
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Available</option>
                        <option value="reserved" {{ request('status') == 'reserved' ? 'selected' : '' }}>Reserved</option>
                        <option value="sold" {{ request('status') == 'sold' ? 'selected' : '' }}>Sold</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="branch_id" class="form-select">
                        <option value="">All Branches</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                                {{ $branch->city }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('vehicles.index') }}" class="btn btn-secondary w-100">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Vehicles Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-hover table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Registration No</th>
                            <th>Make & Model</th>
                            <th>Year</th>
                            <th>Branch</th>
                            <th>Status</th>
                            <th>Selling Price</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($vehicles as $vehicle)
                        <tr>
                                            <td><strong>{{ $vehicle->registration_number ?? 'N/A' }}</strong></td>
                            <td>
                                {{ $vehicle->make ?? 'Toyota' }} {{ $vehicle->model }}
                                <small class="text-muted">({{ $vehicle->variant ?? '' }})</small>
                            </td>
                            <td>{{ $vehicle->year }}</td>
                            <td>{{ $vehicle->branch->city ?? 'N/A' }} Branch</td>
                            <td>
                                @if($vehicle->status == 'available')
                                    <span class="badge bg-success">Available</span>
                                @elseif($vehicle->status == 'reserved')
                                    <span class="badge bg-warning">Reserved</span>
                                @elseif($vehicle->status == 'sold')
                                    <span class="badge bg-danger">Sold</span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst($vehicle->status) }}</span>
                                @endif
                            </td>
                            <td class="fw-semibold">Rs. {{ number_format($vehicle->selling_price ?? 0, 0) }}</td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('vehicles.show', $vehicle) }}" class="btn btn-sm btn-icon text-info" title="View">
                                        <i class="bx bx-show fs-5"></i>
                                    </a>
                                    <a href="{{ route('vehicles.edit', $vehicle) }}" class="btn btn-sm btn-icon text-warning" title="Edit">
                                        <i class="bx bx-edit fs-5"></i>
                                    </a>
                                    <form action="{{ route('vehicles.destroy', $vehicle) }}" method="POST" class="d-inline" 
                                          onsubmit="return confirm('Delete this vehicle?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-icon text-danger" title="Delete">
                                            <i class="bx bx-trash fs-5"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">No vehicles found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-3">
                {{ $vehicles->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
