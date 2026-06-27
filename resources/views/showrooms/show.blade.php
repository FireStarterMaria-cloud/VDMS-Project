@extends('layouts.app')
@section('title', 'Showroom Details')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0"><i class="bx bx-buildings me-2"></i>{{ $showroom->name }}</h4>
        <a href="{{ route('showrooms.index') }}" class="btn btn-secondary btn-sm">
            <i class="bx bx-arrow-back"></i> Back
        </a>
    </div>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header"><h5 class="mb-0">Showroom Info</h5></div>
                <div class="card-body">
                    <p><strong>Name:</strong> {{ $showroom->name }}</p>
                    <p><strong>City:</strong> {{ $showroom->city }}</p>
                    <p><strong>Country:</strong> {{ $showroom->country }}</p>
                    <p><strong>Phone:</strong> {{ $showroom->phone ?? 'N/A' }}</p>
                    <p><strong>Email:</strong> {{ $showroom->email ?? 'N/A' }}</p>
                    <p><strong>Address:</strong> {{ $showroom->address ?? 'N/A' }}</p>
                    <p><strong>Status:</strong>
                        <span class="badge {{ $showroom->is_active ? 'bg-success' : 'bg-danger' }}">
                            {{ $showroom->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header"><h5 class="mb-0">Branches ({{ $showroom->branches->count() }})</h5></div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr><th>Branch</th><th>City</th><th>Vehicles</th><th>Status</th></tr>
                        </thead>
                        <tbody>
                            @forelse($showroom->branches as $branch)
                            <tr>
                                <td>{{ $branch->name }}</td>
                                <td>{{ $branch->city }}</td>
                                <td>{{ $branch->vehicles->count() }}</td>
                                <td><span class="badge {{ $branch->is_active ? 'bg-success' : 'bg-danger' }}">{{ $branch->is_active ? 'Active' : 'Inactive' }}</span></td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center text-muted">No branches yet</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-header"><h5 class="mb-0">Users ({{ $showroom->users->count() }})</h5></div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr><th>Name</th><th>Email</th><th>Role</th></tr>
                        </thead>
                        <tbody>
                            @forelse($showroom->users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td><span class="badge bg-label-primary">{{ $user->role?->label() }}</span></td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="text-center text-muted">No users yet</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection