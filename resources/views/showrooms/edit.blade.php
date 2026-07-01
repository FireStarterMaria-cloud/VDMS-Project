@extends('layouts.app')
@section('title', 'Edit Showroom')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0"><i class="bx bx-edit me-2"></i>Edit Showroom</h4>
        <a href="{{ route('showrooms.overview') }}" class="btn btn-secondary btn-sm">
            <i class="bx bx-arrow-back"></i> Back
        </a>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h5 class="mb-0">Showroom Information</h5></div>
                <div class="card-body">
                    <form action="{{ route('showrooms.update', $showroom) }}" method="POST" enctype="multipart/form-data">
                        @csrf @method('PUT')

                        @if($errors->any())
                        <div class="alert alert-danger">
                            @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
                        </div>
                        @endif

                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">Showroom Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $showroom->name) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">City <span class="text-danger">*</span></label>
                                <input type="text" name="city" class="form-control" value="{{ old('city', $showroom->city) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Country</label>
                                <input type="text" name="country" class="form-control" value="{{ old('country', $showroom->country) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Phone</label>
                                <input type="text" name="phone" class="form-control" value="{{ old('phone', $showroom->phone) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email', $showroom->email) }}">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Address</label>
                                <textarea name="address" class="form-control" rows="2">{{ old('address', $showroom->address) }}</textarea>
                            </div>

                            {{-- LOGO UPLOAD --}}
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="bx bx-image me-1"></i> Showroom Logo
                                </label>
                                @if($showroom->logo)
                                <div class="mb-2 d-flex align-items-center gap-3">
                                    <img src="{{ asset('storage/' . $showroom->logo) }}"
                                        id="logoImg"
                                        style="height:50px;border-radius:8px;border:1px solid #dee2e6;">
                                    <small class="text-muted">Current logo</small>
                                </div>
                                @else
                                <div class="mb-2" id="logoPreview" style="display:none;">
                                    <img id="logoImg" src="" style="height:50px;border-radius:8px;border:1px solid #dee2e6;">
                                </div>
                                @endif
                                <input type="file" name="logo" class="form-control" accept="image/*" onchange="previewLogo(this)">
                                <small class="text-muted">Upload new logo to replace current — PNG, JPG, SVG max 2MB</small>
                            </div>

                            {{-- THEME COLOR PICKER --}}
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="bx bx-palette me-1"></i> Brand Color
                                </label>
                                <div class="d-flex align-items-center gap-3">
                                    <input type="color" name="theme_color" id="themeColorPicker"
                                        value="{{ old('theme_color', $showroom->theme_color ?? '#696cff') }}"
                                        style="width:48px;height:40px;border-radius:8px;border:1px solid #dee2e6;padding:2px;cursor:pointer;">
                                    <input type="text" id="themeColorHex" class="form-control"
                                        value="{{ old('theme_color', $showroom->theme_color ?? '#696cff') }}"
                                        placeholder="#696cff"
                                        style="max-width:120px;"
                                        oninput="syncColorFromText(this.value)">
                                    <span class="text-muted small">Pick any color</span>
                                </div>
                                <div class="mt-2 d-flex gap-2 flex-wrap">
                                    @foreach(['#696cff','#9155fd','#f0c060','#03c3ec','#71dd37','#ff3e1d','#2b2c40','#e83e8c'] as $c)
                                    <div onclick="setColor('{{ $c }}')"
                                        style="width:24px;height:24px;border-radius:50%;background:{{ $c }};cursor:pointer;border:2px solid transparent;transition:border .2s;"
                                        onmouseenter="this.style.border='2px solid #fff'"
                                        onmouseleave="this.style.border='2px solid transparent'"
                                        title="{{ $c }}"></div>
                                    @endforeach
                                </div>
                                <small class="text-muted">Used as showroom accent color</small>
                            </div>

                            <div class="col-12">
                                <div class="form-check">
                                    <input type="checkbox" name="is_active" id="is_active"
                                        class="form-check-input" {{ $showroom->is_active ? 'checked' : '' }}>
                                    <label for="is_active" class="form-check-label">Active</label>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary me-2">Update Showroom</button>
                            <a href="{{ route('showrooms.overview') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function previewLogo(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            const img = document.getElementById('logoImg');
            const preview = document.getElementById('logoPreview');
            img.src = e.target.result;
            if(preview) preview.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function setColor(hex) {
    document.getElementById('themeColorPicker').value = hex;
    document.getElementById('themeColorHex').value = hex;
}

function syncColorFromText(val) {
    if (/^#[0-9A-Fa-f]{6}$/.test(val)) {
        document.getElementById('themeColorPicker').value = val;
    }
}

document.getElementById('themeColorPicker').addEventListener('input', function() {
    document.getElementById('themeColorHex').value = this.value;
});
</script>
@endsection