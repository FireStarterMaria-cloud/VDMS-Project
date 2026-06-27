@extends('layouts.app')
@section('title', 'Showrooms Management')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0"><i class="bx bx-buildings me-2"></i>Showrooms Management</h4>
        <a href="{{ route('showrooms.create') }}" class="btn btn-primary">
            <i class="bx bx-plus me-1"></i> Add Showroom
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width:40px"></th>
                            <th>Showroom</th>
                            <th>City</th>
                            <th>Contact</th>
                            <th class="text-center">Branches</th>
                            <th class="text-center">Users</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($showrooms as $showroom)
                        {{-- Main Row --}}
                        <tr style="cursor:pointer" onclick="toggleBranches({{ $showroom->id }})">
                            <td class="text-center">
                                <i class="bx bx-chevron-right fs-5 text-muted" id="arrow-{{ $showroom->id }}" style="transition:transform .2s"></i>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div style="width:38px;height:38px;background:linear-gradient(135deg,#696cff,#9155fd);border-radius:10px;display:flex;align-items:center;justify-content:center">
                                        <i class="bx bx-buildings text-white"></i>
                                    </div>
                                    <div>
                                        <strong>{{ $showroom->name }}</strong>
                                        <div class="small text-muted">{{ $showroom->email ?? 'No email' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td><i class="bx bx-map-pin me-1 text-muted"></i>{{ $showroom->city }}, {{ $showroom->country }}</td>
                            <td>{{ $showroom->phone ?? 'N/A' }}</td>
                            <td class="text-center">
                                <span class="badge bg-label-primary fs-6">{{ $showroom->branches_count }}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-label-success fs-6">{{ $showroom->users_count }}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge {{ $showroom->is_active ? 'bg-success' : 'bg-danger' }}">
                                    {{ $showroom->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="text-center" onclick="event.stopPropagation()">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('showrooms.show', $showroom) }}" class="btn btn-sm btn-icon text-info" title="View">
                                        <i class="bx bx-show fs-5"></i>
                                    </a>
                                    <a href="{{ route('showrooms.edit', $showroom) }}" class="btn btn-sm btn-icon text-warning" title="Edit">
                                        <i class="bx bx-edit fs-5"></i>
                                    </a>
                                    <form action="{{ route('showrooms.destroy', $showroom) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this showroom?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-icon text-danger" title="Delete">
                                            <i class="bx bx-trash fs-5"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        {{-- Branches Dropdown Row --}}
                        <tr id="branches-{{ $showroom->id }}" style="display:none;background:#f8f8ff">
                            <td colspan="8" class="p-0">
                                <div style="padding:16px 24px 16px 60px">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="mb-0 text-primary"><i class="bx bx-git-branch me-2"></i>Branches of {{ $showroom->name }}</h6>
                                        <a href="{{ route('branches.create') }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bx bx-plus me-1"></i> Add Branch
                                        </a>
                                    </div>
                                    @php
                                        $branches = \App\Models\Branch::withCount('vehicles')
                                            ->where('showroom_id', $showroom->id)
                                            ->get();
                                    @endphp
                                    @if($branches->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered mb-0 bg-white rounded">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Branch Name</th>
                                                    <th>City</th>
                                                    <th>Phone</th>
                                                    <th class="text-center">Vehicles</th>
                                                    <th class="text-center">Status</th>
                                                    <th class="text-center">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($branches as $branch)
                                                <tr>
                                                    <td><i class="bx bx-store me-1 text-muted"></i>{{ $branch->name }}</td>
                                                    <td>{{ $branch->city }}</td>
                                                    <td>{{ $branch->phone ?? 'N/A' }}</td>
                                                    <td class="text-center"><span class="badge bg-label-info">{{ $branch->vehicles_count }}</span></td>
                                                    <td class="text-center">
                                                        <span class="badge {{ $branch->is_active ? 'bg-success' : 'bg-danger' }}">
                                                            {{ $branch->is_active ? 'Active' : 'Inactive' }}
                                                        </span>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="btn-group btn-group-sm">
                                                            <a href="{{ route('branches.show', $branch) }}" class="btn btn-sm btn-icon text-info" title="View">
                                                                <i class="bx bx-show fs-5"></i>
                                                            </a>
                                                            <a href="{{ route('branches.edit', $branch) }}" class="btn btn-sm btn-icon text-warning" title="Edit">
                                                                <i class="bx bx-edit fs-5"></i>
                                                            </a>
                                                            <form action="{{ route('branches.destroy', $branch) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete branch?')">
                                                                @csrf @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-icon text-danger" title="Delete">
                                                                    <i class="bx bx-trash fs-5"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @else
                                    <div class="text-center text-muted py-3">
                                        <i class="bx bx-store fs-2 d-block mb-2"></i>
                                        No branches yet.
                                        <a href="{{ route('branches.create') }}">Add first branch</a>
                                    </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="bx bx-buildings fs-1 d-block mb-3"></i>
                                No showrooms found.
                                <a href="{{ route('showrooms.create') }}">Add your first showroom</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function toggleBranches(id) {
    const row = document.getElementById('branches-' + id);
    const arrow = document.getElementById('arrow-' + id);
    const isOpen = row.style.display !== 'none';
    row.style.display = isOpen ? 'none' : 'table-row';
    arrow.style.transform = isOpen ? 'rotate(0deg)' : 'rotate(90deg)';
}
</script>
@endsection