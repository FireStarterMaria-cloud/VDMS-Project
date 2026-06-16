@extends('layouts.app')
@section('title', 'Branches')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold"><i class="bx bx-buildings me-2"></i> Branches</h4>
        <a href="{{ route('branches.create') }}" class="btn btn-primary">
            <i class="bx bx-plus me-2"></i> Add Branch
        </a>
    </div>
    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>City</th>
                            <th>Country</th>
                            <th>Currency</th>
                            <th>Vehicles</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($branches as $branch)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><strong>{{ $branch->name }}</strong></td>
                            <td>{{ $branch->city }}</td>
                            <td>{{ $branch->country ?? 'Pakistan' }}</td>
                            <td>{{ $branch->currency ?? 'PKR' }}</td>
                            <td>{{ $branch->vehicles_count }}</td>
                            <td>
                                <span class="badge bg-{{ $branch->is_active ? 'success' : 'danger' }}">
                                    {{ $branch->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('branches.show', $branch) }}" class="btn btn-sm btn-info"><i class="bx bx-show"></i></a>
                                <a href="{{ route('branches.edit', $branch) }}" class="btn btn-sm btn-warning"><i class="bx bx-edit"></i></a>
                                @if(auth()->user()->isSuperAdmin())
                                <form action="{{ route('branches.destroy', $branch) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Delete?')"><i class="bx bx-trash"></i></button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="8" class="text-center py-4 text-muted">No branches found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $branches->links() }}
        </div>
    </div>
</div>
@endsection