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
                  <form id="vehicleForm" action="{{ route('vehicles.store') }}" method="POST" enctype="multipart/form-data">
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
                                <input type="text" name="registration_number" class="form-control" required>
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

                            <div class="col-md-6 mb-3">
    <label class="form-label">Purchase Date</label>
    <input type="date" name="purchase_date" value="{{ old('purchase_date', $vehicle->purchase_date ?? '') }}" 
           class="form-control" id="purchase_date">
</div>

<div class="col-md-6 mb-3">
    <label class="form-label">Day</label>
    <input type="text" name="purchase_day" id="purchase_day" 
           value="{{ old('purchase_day', $vehicle->purchase_day ?? '') }}" 
           class="form-control" readonly>
</div>

<div class="col-md-6 mb-3">
    <label class="form-label">Profit / Loss Amount (Rs)</label>
    <input type="number" name="profit_amount" step="0.01" 
           value="{{ old('profit_amount', $vehicle->profit_amount ?? '') }}" 
           class="form-control">
</div>

<div class="col-md-6 mb-3">
    <label class="form-label">Profit Type</label>
    <select name="profit_type" class="form-select">
        <option value="">Select Type</option>
        <option value="profit" {{ old('profit_type', $vehicle->profit_type ?? '') == 'profit' ? 'selected' : '' }}>Profit</option>
        <option value="loss" {{ old('profit_type', $vehicle->profit_type ?? '') == 'loss' ? 'selected' : '' }}>Loss</option>
        <option value="break_even" {{ old('profit_type', $vehicle->profit_type ?? '') == 'break_even' ? 'selected' : '' }}>Break Even</option>
    </select>
</div>

                            <div class="col-md-6">
                                <label class="form-label">Purchase Price (Rs)</label>
                                <input type="number" name="purchase_price" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">VIN Number</label>
                                <input type="text" name="vin_number" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Condition</label>
                                <select name="condition" class="form-select">
                                    <option value="new">New</option>
                                    <option value="used" selected>Used</option>
                                </select>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Notes</label>
                                <textarea name="notes" class="form-control" rows="4"></textarea>
                            </div>
                        </div>

                        <hr>
<h5 class="mb-3"><i class="bx bx-images me-2"></i>Vehicle Photos</h5>
<div class="mb-3">
    <label class="form-label">Upload Photos (Front, Back, Side, Interior, etc.)</label>
    <div class="d-flex gap-2 mb-2">
        <input type="file" id="imageInput" multiple class="form-control" accept="image/*">
        <button type="button" class="btn btn-outline-primary" onclick="document.getElementById('imageCameraInput').click()">
            <i class="bx bx-camera"></i> Take Photo
        </button>
    </div>
    <input type="file" id="imageCameraInput" accept="image/*" capture="environment" style="display:none;">
    <small class="text-muted">First photo will be the primary/cover image</small>

    <div id="selectedImagesList" class="row g-2 mt-2"></div>
</div>

                        <hr>
                        <h5 class="mb-3"><i class="bx bx-folder-open me-2"></i>Vehicle Documents</h5>
                        <div class="mb-3">
                            <label class="form-label">Upload Documents (Registration Book, CNIC, etc.)</label>
                            <div class="d-flex gap-2 mb-2">
                                <input type="file" id="documentInput" multiple class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                                <button type="button" class="btn btn-outline-primary" onclick="document.getElementById('cameraInput').click()">
                                    <i class="bx bx-camera"></i> Take Photo
                                </button>
                            </div>
                            <input type="file" id="cameraInput" accept="image/*" capture="environment" style="display:none;">
                            <small class="text-muted">You can select multiple files (PDF, JPG, PNG) or take a photo directly</small>

                            <div id="selectedFilesList" class="mt-3"></div>
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
let selectedFiles = [];

document.getElementById('documentInput').addEventListener('change', function(e) {
    const newFiles = Array.from(e.target.files);
    selectedFiles = selectedFiles.concat(newFiles);
    renderFileList();
    syncFilesToForm();
    this.value = '';
});

document.getElementById('cameraInput').addEventListener('change', function(e) {
    if (e.target.files.length > 0) {
        const file = e.target.files[0];
        const renamedFile = new File([file], `document_${Date.now()}.jpg`, { type: file.type });
        selectedFiles.push(renamedFile);
        renderFileList();
        syncFilesToForm();
        this.value = '';
    }
});

function renderFileList() {
    const container = document.getElementById('selectedFilesList');
    container.innerHTML = '';

    if (selectedFiles.length === 0) return;

    const list = document.createElement('div');
    list.className = 'list-group';

    selectedFiles.forEach((file, index) => {
        const item = document.createElement('div');
        item.className = 'list-group-item d-flex justify-content-between align-items-center';
        item.innerHTML = `
            <span><i class="bx bx-file me-2"></i>${file.name} <small class="text-muted">(${(file.size/1024).toFixed(1)} KB)</small></span>
            <button type="button" class="btn btn-sm btn-icon text-danger" onclick="removeFile(${index})" title="Remove">
                <i class="bx bx-x fs-5"></i>
            </button>
        `;
        list.appendChild(item);
    });

    container.appendChild(list);
}

function removeFile(index) {
    selectedFiles.splice(index, 1);
    renderFileList();
    syncFilesToForm();
}

function syncFilesToForm() {
    const dt = new DataTransfer();
    selectedFiles.forEach(file => dt.items.add(file));

    let hiddenInput = document.getElementById('hiddenDocumentsInput');
    if (!hiddenInput) {
        hiddenInput = document.createElement('input');
        hiddenInput.type = 'file';
        hiddenInput.name = 'documents[]';
        hiddenInput.id = 'hiddenDocumentsInput';
        hiddenInput.multiple = true;
        hiddenInput.style.display = 'none';
        document.getElementById('vehicleForm').appendChild(hiddenInput);
    }
    hiddenInput.files = dt.files;
}

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('vehicleForm');
    if (!form) return;

    form.addEventListener('submit', function(e) {
        if (navigator.onLine) {
            return;
        }

        e.preventDefault();

        const formData = new FormData(this);
        const data = {};
        formData.forEach((value, key) => {
            if (key !== 'documents[]') {
                data[key] = value;
            }
        });

        const pending = JSON.parse(localStorage.getItem('pending_vehicles') || '[]');
        pending.push({
            data: data,
            timestamp: new Date().toISOString(),
            type: 'vehicle_create'
        });
        localStorage.setItem('pending_vehicles', JSON.stringify(pending));

        showOfflineAlert();
    });
});

function showOfflineAlert() {
    const existing = document.getElementById('offline-alert');
    if (existing) existing.remove();

    const alert = document.createElement('div');
    alert.id = 'offline-alert';
    alert.innerHTML = `
        <div style="position: fixed; top: 20px; right: 20px; z-index: 9999; background: white;
            border-radius: 12px; padding: 20px 24px; box-shadow: 0 8px 30px rgba(0,0,0,0.15);
            border-left: 4px solid #696cff; min-width: 320px;">
            <div style="display:flex; align-items:center; gap:12px; margin-bottom:8px;">
                <i class='bx bx-wifi-off' style="font-size:24px; color:#696cff;"></i>
                <strong style="color:#2b2c40; font-size:15px;">Saved Offline</strong>
            </div>
            <p style="color:#566a7f; font-size:13px; margin:0;">
                You are currently offline. Your vehicle data has been saved locally
                and will sync when internet is restored. <strong>Note: Documents will need to be re-uploaded once online.</strong>
            </p>
        </div>
    `;
    document.body.appendChild(alert);
    setTimeout(() => alert.remove(), 6000);
}

let selectedImages = [];

document.getElementById('imageInput').addEventListener('change', function(e) {
    const newFiles = Array.from(e.target.files);
    selectedImages = selectedImages.concat(newFiles);
    renderImageList();
    syncImagesToForm();
    this.value = '';
});

document.getElementById('imageCameraInput').addEventListener('change', function(e) {
    if (e.target.files.length > 0) {
        const file = e.target.files[0];
        const renamedFile = new File([file], `photo_${Date.now()}.jpg`, { type: file.type });
        selectedImages.push(renamedFile);
        renderImageList();
        syncImagesToForm();
        this.value = '';
    }
});

function renderImageList() {
    const container = document.getElementById('selectedImagesList');
    container.innerHTML = '';

    selectedImages.forEach((file, index) => {
        const url = URL.createObjectURL(file);
        const col = document.createElement('div');
        col.className = 'col-md-3 col-6';
        col.innerHTML = `
            <div class="position-relative">
                <img src="${url}" class="img-fluid rounded" style="height:100px; width:100%; object-fit:cover;">
                <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1" onclick="removeImage(${index})" style="padding:2px 6px;">
                    <i class="bx bx-x"></i>
                </button>
                ${index === 0 ? '<span class="badge bg-primary position-absolute bottom-0 start-0 m-1">Primary</span>' : ''}
                <input type="text" class="form-control form-control-sm mt-1" placeholder="e.g. Front view" name="image_captions[]" value="${index === 0 ? 'Front' : ''}">
            </div>
        `;
        container.appendChild(col);
    });
}

function removeImage(index) {
    selectedImages.splice(index, 1);
    renderImageList();
    syncImagesToForm();
}

function syncImagesToForm() {
    const dt = new DataTransfer();
    selectedImages.forEach(file => dt.items.add(file));

    let hiddenInput = document.getElementById('hiddenImagesInput');
    if (!hiddenInput) {
        hiddenInput = document.createElement('input');
        hiddenInput.type = 'file';
        hiddenInput.name = 'vehicle_images[]';
        hiddenInput.id = 'hiddenImagesInput';
        hiddenInput.multiple = true;
        hiddenInput.style.display = 'none';
        document.getElementById('vehicleForm').appendChild(hiddenInput);
    }
    hiddenInput.files = dt.files;
}


</script>


<script>
document.getElementById('purchase_date').addEventListener('change', function() {
    if (this.value) {
        const date = new Date(this.value);
        const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        document.getElementById('purchase_day').value = days[date.getDay()];
    }
});
</script>
@endsection