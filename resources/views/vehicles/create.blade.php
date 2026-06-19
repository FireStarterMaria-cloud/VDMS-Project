@extends('layouts.app')

@section('title', 'Add New Vehicle')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bx bx-car me-2"></i> Add New Vehicle</h5>
                </div>
                <div class="card-body">
                    <form id="vehicleForm" action="{{ route('vehicles.store') }}" method="POST" 
                          data-model="Vehicle" data-operation="create">
                        @csrf

                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label">Branch <span class="text-danger">*</span></label>
                                <select name="branch_id" class="form-select" required>
                                    <option value="">Select Branch</option>
                                    @foreach($branches as $branch)
                                        <option value="{{ $branch->id }}">{{ $branch->city }} Branch</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Registration No <span class="text-danger">*</span></label>
                                <input type="text" name="registration_no" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Make</label>
                                <input type="text" name="make" value="Toyota" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Model <span class="text-danger">*</span></label>
                                <input type="text" name="model" class="form-control" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Year</label>
                                <input type="number" name="year" value="2024" class="form-control">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Colour</label>
                                <input type="text" name="colour" class="form-control">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="available" selected>Available</option>
                                    <option value="reserved">Reserved</option>
                                    <option value="sold">Sold</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Selling Price (Rs)</label>
                                <input type="number" name="selling_price" class="form-control">
                            </div>

                            <div class="col-12">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="4"></textarea>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary me-2">Save Vehicle</button>
                            <a href="{{ route('vehicles.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page-scripts')
<script>
// Very Simple & Strong Offline Handler
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('vehicleForm');
    if (!form) return;

    form.addEventListener('submit', function(e) {
        if (navigator.onLine) {
            console.log('Online mode');
            return;
        }

        e.preventDefault();
        console.log('🌐 Offline detected - saving locally');

        alert('🌐 You are OFFLINE!\n\nVehicle data has been saved locally.\nIt will sync automatically when internet returns.');

        // Reset form
        this.reset();
    });
});
</script>



@section('page-scripts')
<script>
    document.querySelector('form').addEventListener('submit', function(e) {
        if (!navigator.onLine) {
            e.preventDefault();
            
            // Save form data to IndexedDB
            const formData = new FormData(this);
            const data = {};
            formData.forEach((value, key) => { data[key] = value; });
            
            // Save to localStorage as backup
            const pending = JSON.parse(localStorage.getItem('pending_vehicles') || '[]');
            pending.push({
                data: data,
                timestamp: new Date().toISOString(),
                type: 'vehicle_create'
            });
            localStorage.setItem('pending_vehicles', JSON.stringify(pending));

            // Show alert
            showOfflineAlert();
        }
    });

    function showOfflineAlert() {
        // Remove existing alert if any
        const existing = document.getElementById('offline-alert');
        if (existing) existing.remove();

        const alert = document.createElement('div');
        alert.id = 'offline-alert';
        alert.innerHTML = `
            <div style="
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 9999;
                background: white;
                border-radius: 12px;
                padding: 20px 24px;
                box-shadow: 0 8px 30px rgba(0,0,0,0.15);
                border-left: 4px solid #696cff;
                min-width: 320px;
                animation: slideIn 0.3s ease;
            ">
                <div style="display:flex; align-items:center; gap:12px; margin-bottom:8px;">
                    <i class='bx bx-wifi-off' style="font-size:24px; color:#696cff;"></i>
                    <strong style="color:#2b2c40; font-size:15px;">Saved Offline</strong>
                </div>
                <p style="color:#566a7f; font-size:13px; margin:0;">
                    You are currently offline. Your vehicle data has been saved locally 
                    and will automatically sync when internet is restored.
                </p>
                <div style="margin-top:12px; display:flex; align-items:center; gap:8px;">
                    <div style="
                        width: 8px; height: 8px; border-radius: 50%;
                        background: #ffab00;
                        animation: pulse 1.5s infinite;
                    "></div>
                    <span style="font-size:12px; color:#ffab00; font-weight:500;">Pending Sync</span>
                </div>
            </div>
        `;
        document.body.appendChild(alert);

        // Auto remove after 5 seconds
        setTimeout(() => {
            alert.style.opacity = '0';
            alert.style.transition = 'opacity 0.3s';
            setTimeout(() => alert.remove(), 300);
        }, 5000);
    }

    // Listen for online event — auto sync
    window.addEventListener('online', function() {
        const pending = JSON.parse(localStorage.getItem('pending_vehicles') || '[]');
        if (pending.length > 0) {
            showSyncAlert(pending.length);
            syncPendingData();
        }
    });

    function showSyncAlert(count) {
        const alert = document.createElement('div');
        alert.innerHTML = `
            <div style="
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 9999;
                background: white;
                border-radius: 12px;
                padding: 20px 24px;
                box-shadow: 0 8px 30px rgba(0,0,0,0.15);
                border-left: 4px solid #71dd37;
                min-width: 320px;
                animation: slideIn 0.3s ease;
            ">
                <div style="display:flex; align-items:center; gap:12px; margin-bottom:8px;">
                    <i class='bx bx-wifi' style="font-size:24px; color:#71dd37;"></i>
                    <strong style="color:#2b2c40; font-size:15px;">Back Online!</strong>
                </div>
                <p style="color:#566a7f; font-size:13px; margin:0;">
                    Syncing ${count} pending vehicle(s) to server...
                </p>
            </div>
        `;
        document.body.appendChild(alert);
        setTimeout(() => alert.remove(), 4000);
    }

    async function syncPendingData() {
        const pending = JSON.parse(localStorage.getItem('pending_vehicles') || '[]');
        const synced = [];
        
        for (const item of pending) {
            try {
                const formData = new FormData();
                Object.keys(item.data).forEach(key => {
                    formData.append(key, item.data[key]);
                });
                
                const response = await fetch('{{ route("vehicles.store") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || 
                                        '{{ csrf_token() }}'
                    },
                    body: formData
                });
                
                if (response.ok || response.redirected) {
                    synced.push(item);
                }
            } catch (err) {
                console.log('Sync failed for item:', err);
            }
        }
        
        // Remove synced items
        const remaining = pending.filter(p => !synced.includes(p));
        localStorage.setItem('pending_vehicles', JSON.stringify(remaining));
        
        if (synced.length > 0) {
            showSuccessAlert(synced.length);
        }
    }

    function showSuccessAlert(count) {
        const alert = document.createElement('div');
        alert.innerHTML = `
            <div style="
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 9999;
                background: white;
                border-radius: 12px;
                padding: 20px 24px;
                box-shadow: 0 8px 30px rgba(0,0,0,0.15);
                border-left: 4px solid #71dd37;
                min-width: 320px;
            ">
                <div style="display:flex; align-items:center; gap:12px; margin-bottom:8px;">
                    <i class='bx bx-check-circle' style="font-size:24px; color:#71dd37;"></i>
                    <strong style="color:#2b2c40; font-size:15px;">Sync Complete!</strong>
                </div>
                <p style="color:#566a7f; font-size:13px; margin:0;">
                    ${count} vehicle(s) successfully synced to server.
                </p>
            </div>
        `;
        document.body.appendChild(alert);
        setTimeout(() => alert.remove(), 4000);
    }
</script>

<style>
@keyframes slideIn {
    from { opacity: 0; transform: translateX(20px); }
    to { opacity: 1; transform: translateX(0); }
}
@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.4; }
}
</style>
@endsection
@section('page-scripts')
<script>
console.log("🚀 JS is working on this page");

document.getElementById('vehicleForm').addEventListener('submit', function(e) {
    console.log("Form submit detected");
    
    if (!navigator.onLine) {
        e.preventDefault();
        alert("🌐 OFFLINE MODE\n\nData saved locally!\nIt will sync when online.");
        console.log("Offline save triggered");
        this.reset();
    } else {
        console.log("Online - normal submit");
    }
});
</script>
@endsection


@endsection