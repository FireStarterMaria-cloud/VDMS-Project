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
                <div class="card-header"><h5 class="mb-0">Monthly Sales Trend</h5></div>
                <div class="card-body">
                    <div id="monthlySalesChart"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header"><h5 class="mb-0">Vehicle Status Distribution</h5></div>
                <div class="card-body">
                    <div id="statusDonutChart"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header"><h5 class="mb-0">Vehicles by Branch</h5></div>
                <div class="card-body">
                    <div id="vehiclesBranchChart"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header"><h5 class="mb-0">Revenue by Branch</h5></div>
                <div class="card-body">
                    <div id="revenueBranchChart"></div>
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

<script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
<script>
// Monthly Sales Trend (Line Chart)
new ApexCharts(document.querySelector("#monthlySalesChart"), {
    series: [{
        name: 'Sales Count',
        data: {!! json_encode($monthlySales->pluck('count')) !!}
    }],
    chart: { type: 'line', height: 280, toolbar: { show: false } },
    colors: ['#696cff'],
    stroke: { curve: 'smooth', width: 3 },
    xaxis: { categories: {!! json_encode($monthlySales->pluck('month')) !!} },
    grid: { borderColor: '#f0f0f0' }
}).render();

// Vehicle Status Distribution (Donut)
new ApexCharts(document.querySelector("#statusDonutChart"), {
    series: {!! json_encode($statusDistribution->pluck('count')) !!},
    chart: { type: 'donut', height: 280 },
    labels: {!! json_encode($statusDistribution->pluck('status')->map(fn($s) => ucfirst($s))) !!},
    colors: ['#71dd37', '#ffab00', '#ff3e1d', '#696cff'],
    legend: { position: 'bottom' }
}).render();

// Vehicles by Branch (Bar Chart)
new ApexCharts(document.querySelector("#vehiclesBranchChart"), {
    series: [{
        name: 'Available',
        data: {!! json_encode($vehiclesByBranch->pluck('available')) !!}
    }, {
        name: 'Sold',
        data: {!! json_encode($vehiclesByBranch->pluck('sold')) !!}
    }],
    chart: { type: 'bar', height: 280, toolbar: { show: false }, stacked: true },
    colors: ['#71dd37', '#ff3e1d'],
    xaxis: { categories: {!! json_encode($vehiclesByBranch->pluck('city')) !!} },
    plotOptions: { bar: { borderRadius: 4, columnWidth: '50%' } },
    legend: { position: 'bottom' }
}).render();

// Revenue by Branch (Bar Chart)
new ApexCharts(document.querySelector("#revenueBranchChart"), {
    series: [{
        name: 'Revenue (Rs.)',
        data: {!! json_encode($salesByBranch->pluck('total_revenue')->map(fn($v) => $v ?? 0)) !!}
    }],
    chart: { type: 'bar', height: 280, toolbar: { show: false } },
    colors: ['#03c3ec'],
    xaxis: { categories: {!! json_encode($salesByBranch->pluck('city')) !!} },
    plotOptions: { bar: { borderRadius: 4, columnWidth: '40%' } }
}).render();
</script>
@endsection