@extends('layouts.app')
@section('title', 'Invoices')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold"><i class="bx bx-file me-2"></i> Invoices</h4>
       @if(auth()->user()->isHO() || auth()->user()->isAccountant() || auth()->user()->isBranchManager())
        <a href="{{ route('invoices.create') }}" class="btn btn-primary">
            <i class="bx bx-plus me-2"></i> Create Invoice
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
                            <th>Invoice No</th>
                            <th>Sale</th>
                            <th>Branch</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                            <th>Issue Date</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($invoices as $invoice)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><strong>{{ $invoice->invoice_no }}</strong></td>
                            <td>Sale #{{ $invoice->sale_id }}</td>
                            <td>{{ $invoice->branch->city ?? 'N/A' }}</td>
                            <td>Rs. {{ number_format($invoice->total_amount) }}</td>
                            <td>
                                <span class="badge bg-{{ $invoice->status == 'paid' ? 'success' : ($invoice->status == 'issued' ? 'info' : ($invoice->status == 'draft' ? 'warning' : 'danger')) }}">
                                    {{ ucfirst($invoice->status) }}
                                </span>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($invoice->issue_date)->format('d M Y') }}</td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('invoices.show', $invoice) }}" class="btn btn-sm btn-icon text-info" title="View">
                                        <i class="bx bx-show fs-5"></i>
                                    </a>
                                @if(auth()->user()->isHO() || auth()->user()->isAccountant())
<a href="{{ route('invoices.edit', $invoice) }}" class="btn btn-sm btn-icon text-warning" title="Edit">
    <i class="bx bx-edit fs-5"></i>
</a>
@endif
                                    @if(auth()->user()->isHO())
                                    <form action="{{ route('invoices.destroy', $invoice) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Delete this invoice?')">
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
                        <tr><td colspan="8" class="text-center py-4 text-muted">No invoices found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $invoices->links() }}
        </div>
    </div>
</div>
@endsection