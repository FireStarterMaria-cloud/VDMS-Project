@extends('layouts.app')
@section('title', 'Customers')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold"><i class="bx bx-user me-2"></i> Customers</h4>
        @if(!auth()->user()->isAccountant())
        <a href="{{ route('customers.create') }}" class="btn btn-primary">
            <i class="bx bx-plus me-2"></i> Add Customer
        </a>
        @endif
    </div>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('customers.index') }}" class="row g-3">
                <div class="col-md-8">
                    <input type="text" name="search" class="form-control"
                        placeholder="Search by name, CNIC or phone..."
                        value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Search</button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('customers.index') }}" class="btn btn-secondary w-100">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>CNIC</th>
                            <th>Phone</th>
                            <th>City</th>
                            <th>Branch</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($customers as $customer)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><strong>{{ $customer->name }}</strong></td>
                            <td>{{ $customer->cnic ?? 'N/A' }}</td>
                            <td>{{ $customer->phone }}</td>
                            <td>{{ $customer->city ?? 'N/A' }}</td>
                            <td>{{ $customer->branch->city ?? 'N/A' }}</td>
                            <td>
                                <a href="{{ route('customers.show', $customer) }}" class="btn btn-sm btn-info"><i class="bx bx-show"></i></a>
                                @if(!auth()->user()->isAccountant())
                                <a href="{{ route('customers.edit', $customer) }}" class="btn btn-sm btn-warning"><i class="bx bx-edit"></i></a>
                                @endif
                                @if(auth()->user()->isHO())
                                <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Delete?')"><i class="bx bx-trash"></i></button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="text-center py-4 text-muted">No customers found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $customers->links() }}
        </div>
    </div>
</div>
@endsection