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
                            <td>
                                <strong>{{ $log->user?->name ?? 'System' }}</strong>
                            </td>
                            <td>
                               <span class="badge 
    @if($log->action == 'create') bg-success 
    @elseif($log->action == 'update') bg-warning 
    @elseif($log->action == 'delete') bg-danger 
    @else bg-secondary @endif">
                                    {{ ucfirst($log->action) }}
                                </span>
                            </td>
                            <td>{{ class_basename($log->model_type ?? 'N/A') }}</td>
                            <td><strong>#{{ $log->model_id ?? 'N/A' }}</strong></td>
                            <td>{{ $log->branch?->city ?? 'N/A' }}</td>
                           <td>
    {{ $log->performed_at ? \Carbon\Carbon::parse($log->performed_at)->format('d M Y H:i') : 'N/A' }}
</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">No audit logs found yet.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end mt-3">
                {{ $logs->links() }}
            </div>
        </div>
    </div>
</div>
@endsection