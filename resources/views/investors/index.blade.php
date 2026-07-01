@extends('layouts.app')
@section('title', 'Investment Inquiries')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">
            <i class="bx bx-line-chart me-2" style="color:#696cff"></i>Investment Inquiries
        </h4>
        <span class="badge bg-label-primary">{{ $inquiries->count() }} total</span>
    </div>

    @if($inquiries->count() === 0)
    <div class="card text-center py-5">
        <div class="card-body">
            <i class="bx bx-inbox fs-1 text-muted mb-3 d-block"></i>
            <h5 class="text-muted">No inquiries yet</h5>
            <p class="text-muted small">When investors submit the form on the Investor page, their inquiries will appear here.</p>
        </div>
    </div>
    @else
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">All Investment Inquiries</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Company</th>
                        <th>Investment Range</th>
                        <th>Interested In</th>
                        <th>Message</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($inquiries as $i => $inq)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td><strong>{{ $inq->name }}</strong></td>
                        <td><a href="mailto:{{ $inq->email }}">{{ $inq->email }}</a></td>
                        <td>{{ $inq->phone ?? '—' }}</td>
                        <td>{{ $inq->company_name ?? '—' }}</td>
                        <td>
                            {{ $inq->investment_range ?? '—' }}
                            @if($inq->custom_amount)
                            <br><small class="text-muted">Custom: {{ $inq->custom_amount }}</small>
                            @endif
                        </td>
                        <td>
                            @if($inq->investment_targets)
                                @foreach($inq->investment_targets as $target)
                                <span class="badge bg-label-primary mb-1">{{ $target }}</span><br>
                                @endforeach
                            @else
                                —
                            @endif
                        </td>
                        <td>
                            @if($inq->message)
                            <span title="{{ $inq->message }}" style="cursor:help;">
                                {{ Str::limit($inq->message, 40) }}
                            </span>
                            @else
                            —
                            @endif
                        </td>
                        <td>
                            <span class="badge
                                @if($inq->status === 'new') bg-warning
                                @elseif($inq->status === 'contacted') bg-info
                                @else bg-success
                                @endif">
                                {{ ucfirst($inq->status) }}
                            </span>
                        </td>
                        <td>{{ $inq->created_at->format('d M Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
@endsection