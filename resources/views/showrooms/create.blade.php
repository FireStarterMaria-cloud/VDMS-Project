@extends('layouts.app')
@section('title', 'Add Showroom')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0"><i class="bx bx-plus me-2"></i>Add New Showroom</h4>
        <a href="{{ route('showrooms.index') }}" class="btn btn-secondary btn-sm">
            <i class="bx bx-arrow-back"></i> Back
        </a>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header"><h5 class="mb-0">Showroom Information</h5></div>
                <div class="card-body">
                    <form action="{{ route('showrooms.store') }}" method="POST">
                        @csrf
                        @if($errors->any())
                        <div class="alert alert-danger">
                            @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
                        </div>
                        @endif

                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">Showroom Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">City <span class="text-danger">*</span></label>
                                <input type="text" name="city" class="form-control" value="{{ old('city') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Country</label>
                                <input type="text" name="country" class="form-control" value="{{ old('country', 'Pakistan') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Phone</label>
                                <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Address</label>
                                <textarea name="address" class="form-control" rows="2">{{ old('address') }}</textarea>
                            </div>
                        </div>

                        <hr class="my-4">
                        <h6 class="mb-3"><i class="bx bx-user me-2"></i>Showroom Admin Account</h6>
                        <p class="text-muted small mb-3">A superadmin account will be created for this showroom automatically.</p>

                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">Admin Name <span class="text-danger">*</span></label>
                                <input type="text" name="admin_name" class="form-control" value="{{ old('admin_name') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Admin Email <span class="text-danger">*</span></label>
                                <input type="email" name="admin_email" class="form-control" value="{{ old('admin_email') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Admin Password <span class="text-danger">*</span></label>
                                <input type="password" name="admin_password" class="form-control" required>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary me-2">Create Showroom</button>
                            <a href="{{ route('showrooms.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection