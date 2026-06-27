@extends('layouts.app')

@section('title', 'Dashboard - VDMS')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <i class="bx bxs-dashboard me-2"></i> Dashboard - VDMS
    </h4>

    {{-- Sync Status Widget --}}
    <div id="sync-status-widget" style="display:none;" class="alert alert-warning d-flex align-items-center justify-content-between mb-4">
        <div class="d-flex align-items-center gap-2">
            <i class="bx bx-cloud-upload fs-4"></i>
            <div>
                <strong id="sync-count-text">0 items pending sync</strong>
                <div class="small text-muted" id="sync-detail-text"></div>
            </div>
        </div>
        <button class="btn btn-sm btn-warning" onclick="manualSyncNow()">
            <i class="bx bx-refresh"></i> Sync Now
        </button>
    </div>

    @if(auth()->user()->isHO() && isset($needsReviewInvoices) && $needsReviewInvoices->count() > 0)
<div class="alert alert-info d-flex align-items-center justify-content-between mb-4">
    <div class="d-flex align-items-center gap-2">
        <i class="bx bx-shield-quarter fs-4"></i>
        <div>
            <strong>{{ $needsReviewInvoices->count() }} invoice(s) flagged for review</strong>
            <div class="small text-muted">
                @foreach($needsReviewInvoices as $inv)
                    <a href="{{ route('invoices.show', $inv) }}" class="text-info">{{ $inv->invoice_no }}</a>@if(!$loop->last), @endif
                @endforeach
            </div>
        </div>
    </div>
    <a href="{{ route('invoices.index') }}" class="btn btn-sm btn-info">View All</a>
</div>
@endif

    {{-- Quick Actions --}}
    <div class="d-flex gap-2 mb-4 flex-wrap">
        @if(!auth()->user()->isAccountant())
        <a href="{{ route('vehicles.create') }}" class="btn btn-primary btn-sm">
            <i class="bx bx-plus me-1"></i> Add Vehicle
        </a>
        @endif
        @if(!auth()->user()->isAccountant())
        <a href="{{ route('sales.create') }}" class="btn btn-outline-primary btn-sm">
            <i class="bx bx-receipt me-1"></i> New Sale
        </a>
        @endif
        @if(!auth()->user()->isAccountant())
        <a href="{{ route('customers.create') }}" class="btn btn-outline-primary btn-sm">
            <i class="bx bx-user-plus me-1"></i> New Customer
        </a>
        @endif
        <a href="{{ route('vehicles.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bx bx-search me-1"></i> Browse Vehicles
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar flex-shrink-0">
                            <i class="bx bx-car fs-1"></i>
                        </div>
                        <div class="ms-3">
                            <h5 class="mb-0">Total Vehicles</h5>
                            <h3 class="mb-0 fw-bold">{{ $stats['total_vehicles'] ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar flex-shrink-0">
                            <i class="bx bx-check-circle fs-1"></i>
                        </div>
                        <div class="ms-3">
                            <h5 class="mb-0">Available Now</h5>
                            <h3 class="mb-0 fw-bold">{{ $stats['available'] ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar flex-shrink-0">
                            <i class="bx bx-buildings fs-1"></i>
                        </div>
                        <div class="ms-3">
                            <h5 class="mb-0">Branches</h5>
                            <h3 class="mb-0 fw-bold">{{ $stats['total_branches'] ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar flex-shrink-0">
                            <i class="bx bx-user fs-1"></i>
                        </div>
                        <div class="ms-3">
                            <h5 class="mb-0">Total Users</h5>
                            <h3 class="mb-0 fw-bold">{{ $stats['total_users'] ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <!-- Recent Vehicles -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Recent Vehicles</h5>
                    <a href="{{ route('vehicles.index') }}" class="btn btn-sm btn-primary">View All Vehicles</a>
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Registration No</th>
                                <th>Make & Model</th>
                                <th>Year</th>
                                <th>Branch</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentVehicles as $vehicle)
                            <tr>
                                <td><strong>{{ $vehicle->registration_number ?? 'N/A' }}</strong></td>
                                <td>
                                    {{ $vehicle->make ?? 'Toyota' }} {{ $vehicle->model }}
                                    <small class="text-muted">({{ $vehicle->variant ?? '' }})</small>
                                </td>
                                <td>{{ $vehicle->year }}</td>
                                <td>{{ $vehicle->branch->city ?? 'N/A' }} Branch</td>
                                <td>
                                    @if($vehicle->status == 'available')
                                        <span class="badge bg-success">Available</span>
                                    @elseif($vehicle->status == 'reserved')
                                        <span class="badge bg-warning">Reserved</span>
                                    @elseif($vehicle->status == 'sold')
                                        <span class="badge bg-danger">Sold</span>
                                    @else
                                        <span class="badge bg-secondary">{{ ucfirst($vehicle->status) }}</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">No recent vehicles found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Recent Sales -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Recent Sales</h5>
                    <a href="{{ route('sales.index') }}" class="btn btn-sm btn-primary">View All</a>
                </div>
                <div class="list-group list-group-flush">
                    @forelse($recentSales ?? [] as $sale)
                    <div class="list-group-item">
                        <div class="d-flex justify-content-between">
                            <div>
                                <strong>{{ $sale->customer->name ?? 'N/A' }}</strong>
                                <div class="small text-muted">
                                    {{ $sale->vehicle->make ?? '' }} {{ $sale->vehicle->model ?? '' }}
                                </div>
                            </div>
                            <div class="text-end">
                                <span class="fw-bold text-success">Rs. {{ number_format($sale->final_price) }}</span>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="list-group-item text-center text-muted py-4">No recent sales.</div>
                    @endforelse
                </div>
            </div>

            <!-- Revenue Card -->
            <div class="card bg-label-success">
                <div class="card-body text-center">
                    <i class="bx bx-trending-up fs-1 text-success"></i>
                    <h5 class="mt-2 mb-0">Total Revenue</h5>
                    <h3 class="fw-bold text-success">Rs. {{ number_format($totalRevenue ?? 0) }}</h3>
                </div>
            </div>
        </div>
    </div>

{{-- Branch Performance + Mini Chart (HO only) --}}
@if(auth()->user()->isHO())
<div class="row mt-2">
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header"><h5 class="mb-0">Branch Performance</h5></div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead class="table-light">
                            <tr><th>Branch</th><th>Vehicles</th><th>Available</th></tr>
                        </thead>
                        <tbody>
                           @foreach(\App\Models\Branch::withCount(['vehicles', 'vehicles as available_count' => function($q) { $q->where('status', 'available'); }])->when(!auth()->user()->isChairwoman(), function($q) { $q->where('showroom_id', auth()->user()->showroom_id); })->get() as $b)
                                <td>{{ $b->city }}</td>
                                <td>{{ $b->vehicles_count }}</td>
                                <td><span class="badge bg-{{ $b->available_count < 3 ? 'danger' : 'success' }}">{{ $b->available_count }}</span></td>
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
            <div class="card-header"><h5 class="mb-0">Vehicle Status Overview</h5></div>
            <div class="card-body">
                <div id="dashStatusChart"></div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
<script>
new ApexCharts(document.querySelector("#dashStatusChart"), {
    series: [{{ $stats['available'] }}, {{ $stats['total_vehicles'] - $stats['available'] }}],
    chart: { type: 'donut', height: 250 },
    labels: ['Available', 'Other (Sold/Reserved)'],
    colors: ['#71dd37', '#ffab00'],
    legend: { position: 'bottom' }
}).render();
</script>
@endif



</div>

<script>
function checkPendingSync() {
    const pending = JSON.parse(localStorage.getItem('pending_vehicles') || '[]');
    const widget = document.getElementById('sync-status-widget');
    const countText = document.getElementById('sync-count-text');
    const detailText = document.getElementById('sync-detail-text');

    if (pending.length > 0) {
        widget.style.display = 'flex';
        countText.textContent = pending.length + ' item(s) pending sync';
        const lastItem = pending[pending.length - 1];
        const time = new Date(lastItem.timestamp).toLocaleString();
        detailText.textContent = 'Last saved offline: ' + time + ' — will sync when online';
    } else {
        widget.style.display = 'none';
    }
}

function manualSyncNow() {
    if (!navigator.onLine) {
        alert('You are still offline. Please connect to the internet to sync.');
        return;
    }
    const pending = JSON.parse(localStorage.getItem('pending_vehicles') || '[]');
    if (pending.length === 0) return;
    syncAllPending(pending);
}

async function syncAllPending(pending) {
    const synced = [];
    for (const item of pending) {
        try {
            const formData = new FormData();
            Object.keys(item.data).forEach(key => {
                formData.append(key, item.data[key]);
            });
            const response = await fetch('{{ route("vehicles.store") }}', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: formData
            });
            if (response.ok || response.redirected) {
                synced.push(item);
            }
        } catch (err) {
            console.log('Sync failed:', err);
        }
    }
    const remaining = pending.filter(p => !synced.includes(p));
    localStorage.setItem('pending_vehicles', JSON.stringify(remaining));
    checkPendingSync();
    if (synced.length > 0) {
        alert(synced.length + ' vehicle(s) synced successfully!');
        location.reload();
    }
}

document.addEventListener('DOMContentLoaded', checkPendingSync);
window.addEventListener('online', () => {
    setTimeout(checkPendingSync, 1000);
});
</script>
@endsection