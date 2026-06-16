@extends('layouts.app')
@section('title', 'Edit User')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4">Edit User</h4>
    <div class="card">
        <div class="card-body">
            @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
            </div>
            @endif
            <form action="{{ route('users.update', $user) }}" method="POST">
                @csrf @method('PUT')
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required />
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required />
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">New Password <small class="text-muted">(leave blank to keep)</small></label>
                        <input type="password" name="password" class="form-control" />
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control" />
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-select" required>
                            @foreach($roles as $role)
                            <option value="{{ $role->value }}" {{ $user->role?->value == $role->value ? 'selected' : '' }}>
                                {{ $role->label() }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Branch</label>
                        <select name="branch_id" class="form-select">
                            <option value="">Head Office</option>
                            @foreach($branches as $branch)
                            <option value="{{ $branch->id }}" {{ $user->branch_id == $branch->id ? 'selected' : '' }}>
                                {{ $branch->city }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}" />
                    </div>
                    <div class="col-md-6 mb-3 d-flex align-items-end">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" {{ $user->is_active ? 'checked' : '' }} />
                            <label class="form-check-label" for="is_active">Active User</label>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary me-2">Update</button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection