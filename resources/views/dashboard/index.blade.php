@extends('layouts.app')

@section('title', 'Dashboard - VDMS')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <i class="bx bxs-dashboard me-2"></i> Dashboard - VDMS
    </h4>

    <!-- Stats Cards -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar flex-shrink-0">
                            <i class="bx bx-car fs-1"></i>
                        </div>
                        <div class="ms-3">
                            <h5 class="mb-0">Total Vehicles</h5>
                            <h3 class="mb-0 fw-bold">{{ $stats['total_vehicles'] ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar flex-shrink-0">
                            <i class="bx bx-check-circle fs-1"></i>
                        </div>
                        <div class="ms-3">
                            <h5 class="mb-0">Available Now</h5>
                            <h3 class="mb-0 fw-bold">{{ $stats['available'] ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar flex-shrink-0">
                            <i class="bx bx-buildings fs-1"></i>
                        </div>
                        <div class="ms-3">
                            <h5 class="mb-0">Branches</h5>
                            <h3 class="mb-0 fw-bold">{{ $stats['total_branches'] ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar flex-shrink-0">
                            <i class="bx bx-user fs-1"></i>
                        </div>
                        <div class="ms-3">
                            <h5 class="mb-0">Total Users</h5>
                            <h3 class="mb-0 fw-bold">{{ $stats['total_users'] ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Vehicles -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Recent Vehicles</h5>
            <a href="{{ route('vehicles.index') }}" class="btn btn-sm btn-primary">View All Vehicles</a>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Registration No</th>
                        <th>Make & Model</th>
                        <th>Year</th>
                        <th>Branch</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentVehicles as $vehicle)
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
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">No recent vehicles found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection