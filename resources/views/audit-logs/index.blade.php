@extends('layouts.app')
@section('title', 'Audit Logs')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4"><i class="bx bx-list-check me-2"></i> Audit Logs</h4>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>User</th>
                            <th>Action</th>
                            <th>Model</th>
                            <th>Record ID</th>
                            <th>Branch</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $log->user->name ?? 'System' }}</td>
                            <td><span class="badge bg-{{ $log->action == 'create' ? 'success' : ($log->action == 'update' ? 'warning' : 'danger') }}">{{ ucfirst($log->action) }}</span></td>
                            <td>{{ $log->model_type ?? 'N/A' }}</td>
                            <td>{{ $log->model_id ?? 'N/A' }}</td>
                            <td>{{ $log->branch->city ?? 'N/A' }}</td>
                            <td>{{ $log->created_at->format('d M Y H:i') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="text-center py-4 text-muted">No logs found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $logs->links() }}
        </div>
    </div>
</div>
@endsection