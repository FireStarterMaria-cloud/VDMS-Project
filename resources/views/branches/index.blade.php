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
                            <th>Phone</th>
                            <th>Status</th>
                            <th class="text-center">Actions</th>
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
                            <td>{{ $branch->phone ?? 'N/A' }}</td>
                            <td>
                                <span class="badge bg-{{ $branch->is_active ? 'success' : 'danger' }}">
                                    {{ $branch->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('branches.show', $branch) }}" class="btn btn-sm btn-icon text-info" title="View">
                                        <i class="bx bx-show fs-5"></i>
                                    </a>
                                    <a href="{{ route('branches.edit', $branch) }}" class="btn btn-sm btn-icon text-warning" title="Edit">
                                        <i class="bx bx-edit fs-5"></i>
                                    </a>
                                    @if(auth()->user()->isSuperAdmin())
                                    <form action="{{ route('branches.destroy', $branch) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Delete this branch?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-icon text-danger" title="Delete">
                                            <i class="bx bx-trash fs-5"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
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