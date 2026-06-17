@extends('layouts.app')
@section('title', 'Settings')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4"><i class="bx bx-cog me-2"></i> Settings</h4>
    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header"><h5 class="mb-0">My Profile</h5></div>
                <div class="card-body">
                    <p><strong>Name:</strong> {{ auth()->user()->name }}</p>
                    <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
                    <p><strong>Role:</strong> {{ ucfirst(str_replace('_', ' ', auth()->user()->role?->value ?? '')) }}</p>
                    <p><strong>Branch:</strong> {{ auth()->user()->branch->city ?? 'Head Office' }}</p>
                    <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                        <i class="bx bx-edit me-1"></i> Edit Profile
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header"><h5 class="mb-0">System Info</h5></div>
                <div class="card-body">
                    <p><strong>System:</strong> VDMS v1.0.0</p>
                    <p><strong>Framework:</strong> Laravel 12</p>
                    <p><strong>Template:</strong> Sneat Bootstrap 5</p>
                    <p><strong>Total Branches:</strong> {{ \App\Models\Branch::count() }}</p>
                    <p><strong>Total Users:</strong> {{ \App\Models\User::count() }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection