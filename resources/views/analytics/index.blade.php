@extends('layouts.app')
@section('title', 'Analytics')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4"><i class="bx bx-line-chart me-2"></i> Analytics</h4>

    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5>Total Vehicles</h5>
                    <h3 class="fw-bold">{{ $totalVehicles }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5>Total Sales</h5>
                    <h3 class="fw-bold">{{ $totalSales }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5>Total Customers</h5>
                    <h3 class="fw-bold">{{ $totalCustomers }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h5>Total Revenue</h5>
                    <h3 class="fw-bold">Rs. {{ number_format($totalRevenue) }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header"><h5 class="mb-0">Vehicles by Branch</h5></div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr><th>Branch</th><th>Total</th><th>Available</th><th>Sold</th></tr>
                            </thead>
                            <tbody>
                                @foreach($vehiclesByBranch as $row)
                                <tr>
                                    <td>{{ $row->city }}</td>
                                    <td>{{ $row->total }}</td>
                                    <td><span class="badge bg-success">{{ $row->available }}</span></td>
                                    <td><span class="badge bg-danger">{{ $row->sold }}</span></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header"><h5 class="mb-0">Sales by Branch</h5></div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr><th>Branch</th><th>Sales</th><th>Revenue</th></tr>
                            </thead>
                            <tbody>
                                @foreach($salesByBranch as $row)
                                <tr>
                                    <td>{{ $row->city }}</td>
                                    <td>{{ $row->total_sales }}</td>
                                    <td>Rs. {{ number_format($row->total_revenue) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header"><h5 class="mb-0">Recent Sales (Last 10)</h5></div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr><th>Vehicle</th><th>Customer</th><th>Branch</th><th>Amount</th><th>Date</th></tr>
                    </thead>
                    <tbody>
                        @foreach($recentSales as $sale)
                        <tr>
                            <td>{{ $sale->vehicle->make ?? '' }} {{ $sale->vehicle->model ?? 'N/A' }}</td>
                            <td>{{ $sale->customer->name ?? 'N/A' }}</td>
                            <td>{{ $sale->branch->city ?? 'N/A' }}</td>
                            <td>Rs. {{ number_format($sale->final_price) }}</td>
                            <td>{{ $sale->sale_date?->format('d M Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection