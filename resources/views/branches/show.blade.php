@extends('layouts.app')
@section('title', 'Branch Details')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4">{{ $branch->name }}</h4>
    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header"><h5 class="mb-0">Branch Info</h5></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6 mb-3"><label class="text-muted">City</label><p class="fw-bold">{{ $branch->city }}</p></div>
                        <div class="col-6 mb-3"><label class="text-muted">Country</label><p class="fw-bold">{{ $branch->country ?? 'Pakistan' }}</p></div>
                        <div class="col-6 mb-3"><label class="text-muted">Phone</label><p class="fw-bold">{{ $branch->phone ?? 'N/A' }}</p></div>
                        <div class="col-6 mb-3"><label class="text-muted">Email</label><p class="fw-bold">{{ $branch->email ?? 'N/A' }}</p></div>
                        <div class="col-6 mb-3"><label class="text-muted">Currency</label><p class="fw-bold">{{ $branch->currency ?? 'PKR' }}</p></div>
                        <div class="col-6 mb-3"><label class="text-muted">Status</label><p><span class="badge bg-{{ $branch->is_active ? 'success' : 'danger' }}">{{ $branch->is_active ? 'Active' : 'Inactive' }}</span></p></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header"><h5 class="mb-0">Stats</h5></div>
                <div class="card-body">
                    <p>Total Vehicles: <strong>{{ $branch->vehicles->count() }}</strong></p>
                    <p>Total Users: <strong>{{ $branch->users->count() }}</strong></p>
                </div>
            </div>
        </div>
    </div>
    <a href="{{ route('branches.index') }}" class="btn btn-secondary">← Back</a>
    <a href="{{ route('branches.edit', $branch) }}" class="btn btn-warning ms-2">Edit</a>
</div>
@endsection