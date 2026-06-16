@extends('layouts.app')
@section('title', 'Payments')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold"><i class="bx bx-money me-2"></i> Payments</h4>
        @if(auth()->user()->isHO() || auth()->user()->isAccountant())
        <a href="{{ route('payments.create') }}" class="btn btn-primary">
            <i class="bx bx-plus me-2"></i> Add Payment
        </a>
        @endif
    </div>
    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Sale</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $payment)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>Sale #{{ $payment->sale_id }}</td>
                            <td>Rs. {{ number_format($payment->amount) }}</td>
                            <td>{{ ucfirst($payment->payment_method) }}</td>
                            <td>
                                <span class="badge bg-{{ $payment->status == 'completed' ? 'success' : ($payment->status == 'pending' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($payment->status) }}
                                </span>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('payments.show', $payment) }}" class="btn btn-sm btn-info"><i class="bx bx-show"></i></a>
                                @if(auth()->user()->isHO() || auth()->user()->isAccountant())
                                <a href="{{ route('payments.edit', $payment) }}" class="btn btn-sm btn-warning"><i class="bx bx-edit"></i></a>
                                @endif
                                @if(auth()->user()->isHO())
                                <form action="{{ route('payments.destroy', $payment) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Delete?')"><i class="bx bx-trash"></i></button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="text-center py-4 text-muted">No payments found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $payments->links() }}
        </div>
    </div>
</div>
@endsection