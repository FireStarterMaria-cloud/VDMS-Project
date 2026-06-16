@extends('layouts.app')
@section('title', 'User Details')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4">User Details</h4>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3"><label class="text-muted">Name</label><p class="fw-bold">{{ $user->name }}</p></div>
                <div class="col-md-6 mb-3"><label class="text-muted">Email</label><p class="fw-bold">{{ $user->email }}</p></div>
                <div class="col-md-6 mb-3"><label class="text-muted">Role</label><p><span class="badge bg-label-primary">{{ ucfirst(str_replace('_', ' ', $user->role?->value ?? '')) }}</span></p></div>
                <div class="col-md-6 mb-3"><label class="text-muted">Branch</label><p class="fw-bold">{{ $user->branch->city ?? 'Head Office' }}</p></div>
                <div class="col-md-6 mb-3"><label class="text-muted">Phone</label><p class="fw-bold">{{ $user->phone ?? 'N/A' }}</p></div>
                <div class="col-md-6 mb-3"><label class="text-muted">Status</label><p><span class="badge bg-{{ $user->is_active ? 'success' : 'danger' }}">{{ $user->is_active ? 'Active' : 'Inactive' }}</span></p></div>
            </div>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">← Back</a>
            <a href="{{ route('users.edit', $user) }}" class="btn btn-warning ms-2">Edit</a>
        </div>
    </div>
</div>
@endsection