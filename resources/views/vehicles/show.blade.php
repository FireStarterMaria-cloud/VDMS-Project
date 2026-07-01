@extends('layouts.app')

@section('title', 'Vehicle Details')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bx bx-car me-2"></i>
                        {{ $vehicle->make }} {{ $vehicle->model }} ({{ $vehicle->year }})
                    </h5>
                    <a href="{{ route('vehicles.index') }}" class="btn btn-secondary btn-sm">
                        <i class="bx bx-arrow-back"></i> Back
                    </a>
                </div>
                <div class="card-body">

                    {{-- Vehicle Photos --}}
                    @if($vehicle->images->count() > 0)
                    <div class="mb-4">
                        <h6 class="text-muted mb-2">Photos</h6>
                        <div class="row g-2">
                            @foreach($vehicle->images as $img)
                            <div class="col-md-3 col-6">
                                <a href="{{ asset('storage/' . $img->image_url) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $img->image_url) }}" class="img-fluid rounded shadow-sm" style="height:150px; width:100%; object-fit:cover;">
                                </a>
                                <small class="text-muted d-block text-center mt-1">
                                    {{ $img->image_name }}
                                    @if($img->is_primary)<span class="badge bg-primary ms-1">Primary</span>@endif
                                </small>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @else
                    <div class="alert alert-light border mb-4 text-center text-muted">
                        <i class="bx bx-image fs-1 d-block mb-2"></i>
                        No photos uploaded for this vehicle yet.
                    </div>
                    @endif

                    <div class="row">
                        <!-- Left Side - Details -->
                        <div class="col-md-7">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <strong>Registration No:</strong><br>
                                    <span class="fw-bold">{{ $vehicle->registration_number ?? 'N/A' }}</span>
                                </div>
                                <div class="col-md-6">
                                    <strong>Status:</strong><br>
                                    <span class="badge @if($vehicle->status == 'available') bg-success @elseif($vehicle->status == 'reserved') bg-warning @elseif($vehicle->status == 'sold') bg-danger @else bg-secondary @endif">
                                        {{ ucfirst($vehicle->status) }}
                                    </span>
                                </div>

                                <div class="col-md-6">
                                    <strong>Branch:</strong><br>
                                    {{ $vehicle->branch->city ?? 'N/A' }}
                                </div>
                                <div class="col-md-6">
                                    <strong>Colour:</strong><br>
                                    {{ $vehicle->colour ?? 'N/A' }}
                                </div>

                                <div class="col-md-6">
                                    <strong>VIN Number:</strong><br>
                                    {{ $vehicle->vin_number ?? 'N/A' }}
                                </div>
                                <div class="col-md-6">
                                    <strong>Variant:</strong><br>
                                    {{ $vehicle->variant ?? 'N/A' }}
                                </div>

                                <div class="col-md-6">
                                    <strong>Selling Price:</strong><br>
                                    Rs. {{ number_format($vehicle->selling_price ?? 0) }}
                                </div>
                                <div class="col-md-6">
                                    <strong>Purchase Price:</strong><br>
                                    Rs. {{ number_format($vehicle->purchase_price ?? 0) }}
                                </div>

                                <div class="col-md-6">
                                    <strong>Condition:</strong><br>
                                    {{ ucfirst($vehicle->condition ?? 'N/A') }}
                                </div>
                                <div class="col-md-6">
                                    <strong>Mileage:</strong><br>
                                    {{ $vehicle->mileage ? number_format($vehicle->mileage) . ' km' : 'N/A' }}
                                </div>

                                <div class="col-md-6">
                                    <strong>Transmission:</strong><br>
                                    {{ ucfirst($vehicle->transmission ?? 'N/A') }}
                                </div>
                                <div class="col-md-6">
                                    <strong>Fuel Type:</strong><br>
                                    {{ ucfirst($vehicle->fuel_type ?? 'N/A') }}
                                </div>

                                <div class="col-12">
                                    <strong>Notes:</strong><br>
                                    <p>{{ $vehicle->notes ?? 'No notes available.' }}</p>
                                </div>

                               <div class="col-12">
                                    <strong>Documents:</strong>
                                    <span class="badge bg-label-secondary ms-1" style="font-size:10px;">
                                        <i class="bx bx-lock-alt"></i> Confidential — visible only to uploader & supervisors
                                    </span>
                                    <br>
                                    @if($visibleDocuments->count() > 0)
                                    <ul class="list-group mt-2">
                                        @foreach($visibleDocuments as $doc)
                                        <li class="list-group-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank">
                                                    <i class="bx bx-file me-1"></i> {{ $doc->file_name }}
                                                </a>
                                                <div class="d-flex align-items-center gap-2">
                                                    @if($doc->is_verified)
                                                        <span class="badge bg-success"><i class="bx bx-check-shield me-1"></i>Verified</span>
                                                    @else
                                                        <span class="badge bg-warning">Pending Verification</span>
                                                        @if(!auth()->user()->isSalesStaff() && !auth()->user()->isAccountant())
                                                        <form action="{{ route('vehicle-documents.verify', $doc) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-success">
                                                                <i class="bx bx-check"></i> Verify
                                                            </button>
                                                        </form>
                                                        @endif
                                                    @endif
                                                    <a href="{{ asset('storage/' . $doc->file_path) }}" download class="btn btn-sm btn-outline-primary">
                                                        <i class="bx bx-download"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <small class="text-muted">
                                                Uploaded by {{ $doc->uploadedBy->name ?? 'Unknown' }}
                                                @if($doc->is_verified)
                                                    · Verified by {{ $doc->verifiedBy->name ?? 'N/A' }} on {{ $doc->verified_at?->format('d M Y') }}
                                                @endif
                                            </small>
                                        </li>
                                        @endforeach
                                    </ul>
                                    @else
                                    <p class="text-muted mt-2">
                                        @if($vehicle->documents->count() > 0)
                                            Documents exist for this vehicle but are restricted to the uploader and their supervisors.
                                        @else
                                            No documents uploaded.
                                        @endif
                                    </p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Right Side - QR Code -->
                        <div class="col-md-5">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Vehicle QR Code</h6>
                                </div>
                                <div class="card-body text-center py-4">
                                    {!! $vehicle->qr_code !!}
                                    <p class="text-muted small mt-3">
                                        Scan this QR code to view complete details on mobile
                                    </p>
                                    <button onclick="window.print()" class="btn btn-sm btn-outline-primary">
                                        <i class="bx bx-printer"></i> Print QR Code
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection