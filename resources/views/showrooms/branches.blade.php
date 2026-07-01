@extends('layouts.app')
@section('title', '{{ $showroom->name }} — Branches')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    @php $color = $showroom->theme_color ?? '#696cff'; @endphp

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center gap-3">
            <div style="width:48px;height:48px;border-radius:12px;background:{{ $color }}18;border:1px solid {{ $color }}40;display:flex;align-items:center;justify-content:center;overflow:hidden;">
                @if($showroom->logo)
                    <img src="{{ asset('storage/' . $showroom->logo) }}" style="width:100%;height:100%;object-fit:contain;padding:6px;">
                @else
                    <i class="bx bx-building-house" style="font-size:1.4rem;color:{{ $color }};"></i>
                @endif
            </div>
            <div>
                <h4 class="fw-bold mb-0" style="color:#f0f0ff;">{{ $showroom->name }}</h4>
                <small style="color:{{ $color }};">{{ $showroom->city }}{{ $showroom->country ? ', ' . $showroom->country : '' }} — Branches</small>
            </div>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('branches.create') }}?showroom_id={{ $showroom->id }}"
                class="btn btn-sm"
                style="background:{{ $color }};color:#fff;border:none;">
                <i class="bx bx-plus me-1"></i> Add Branch
            </a>
            <a href="{{ route('showrooms.overview') }}" class="btn btn-secondary btn-sm">
                <i class="bx bx-arrow-back"></i> Back
            </a>
        </div>
    </div>

    {{-- Quick actions for this showroom --}}
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <a href="{{ route('users.index') }}?showroom_id={{ $showroom->id }}"
                class="btn btn-sm"
                style="background:{{ $color }}18;color:{{ $color }};border:1px solid {{ $color }}40;">
                <i class="bx bx-group me-1"></i> Manage Staff
            </a>
        </div>
        <div class="col-auto">
            <a href="{{ route('vehicles.index') }}"
                class="btn btn-sm"
                style="background:{{ $color }}18;color:{{ $color }};border:1px solid {{ $color }}40;">
                <i class="bx bx-car me-1"></i> View Vehicles
            </a>
        </div>
        <div class="col-auto">
            <a href="{{ route('analytics.index') }}"
                class="btn btn-sm"
                style="background:{{ $color }}18;color:{{ $color }};border:1px solid {{ $color }}40;">
                <i class="bx bx-bar-chart-alt-2 me-1"></i> Analytics
            </a>
        </div>
        <div class="col-auto">
            <a href="{{ route('showrooms.edit', $showroom) }}"
                class="btn btn-sm"
                style="background:{{ $color }}18;color:{{ $color }};border:1px solid {{ $color }}40;">
                <i class="bx bx-edit me-1"></i> Edit Showroom
            </a>
        </div>
    </div>

    {{-- Branches grid --}}
    @if($showroom->branches->count() === 0)
    <div class="card text-center py-5">
        <div class="card-body">
            <i class="bx bx-git-branch fs-1 text-muted mb-3 d-block"></i>
            <h5 class="text-muted">No branches yet for this showroom</h5>
            <a href="{{ route('branches.create') }}" class="btn btn-primary mt-2">
                <i class="bx bx-plus me-1"></i> Add First Branch
            </a>
        </div>
    </div>
    @else
    <div class="row g-4">
        @foreach($showroom->branches as $branch)
        <div class="col-xl-4 col-md-6 branch-card-wrap">
            <div class="h-100"
                style="
                    background:rgba(255,255,255,0.03);
                    border:1px solid {{ $color }}35;
                    border-radius:16px;
                    overflow:hidden;
                    transition:transform .3s, box-shadow .3s, border-color .3s;
                    position:relative;
                "
                onmouseenter="this.style.transform='translateY(-5px)';this.style.boxShadow='0 16px 40px {{ $color }}25';this.style.borderColor='{{ $color }}70';"
                onmouseleave="this.style.transform='';this.style.boxShadow='';this.style.borderColor='{{ $color }}35';">

                <div style="height:3px;background:linear-gradient(90deg,{{ $color }},{{ $color }}60);"></div>

                <div style="padding:1.5rem;">
                    <div class="d-flex align-items-start justify-content-between mb-3">
                        <div>
                            <h6 class="fw-bold mb-1" style="color:#f0f0ff;">{{ $branch->name }}</h6>
                            <small style="color:{{ $color }};"><i class="bx bx-map-pin me-1"></i>{{ $branch->city }}</small>
                        </div>
                        <span style="background:{{ $branch->is_active ? 'rgba(113,221,55,.15)' : 'rgba(255,62,29,.12)' }};color:{{ $branch->is_active ? '#71dd37' : '#ff3e1d' }};padding:3px 10px;border-radius:20px;font-size:.7rem;font-weight:600;">
                            {{ $branch->is_active ? '● Active' : '● Inactive' }}
                        </span>
                    </div>

                    {{-- Stats --}}
                    <div class="d-flex gap-2 mb-3">
                        <div style="flex:1;background:{{ $color }}10;border-radius:8px;padding:.5rem;text-align:center;">
                            <div style="font-size:1.2rem;font-weight:700;color:{{ $color }};">{{ $branch->vehicles_count }}</div>
                            <div style="font-size:.65rem;color:#9a9abf;text-transform:uppercase;">Vehicles</div>
                        </div>
                        @if($branch->phone)
                        <div style="flex:2;background:{{ $color }}10;border-radius:8px;padding:.5rem;">
                            <div style="font-size:.75rem;color:#7a7a9a;"><i class="bx bx-phone me-1" style="color:{{ $color }};"></i>{{ $branch->phone }}</div>
                        </div>
                        @endif
                    </div>

                    @if($branch->address)
                    <div style="font-size:.75rem;color:#7a7a9a;margin-bottom:1rem;">
                        <i class="bx bx-map me-1" style="color:{{ $color }};"></i>{{ $branch->address }}
                    </div>
                    @endif

                    {{-- Actions --}}
                    <div class="d-flex gap-2">
                        <a href="{{ route('vehicles.index') }}?branch_id={{ $branch->id }}"
                            class="btn btn-sm flex-fill"
                            style="background:{{ $color }};color:#fff;border:none;border-radius:8px;font-size:.75rem;">
                            <i class="bx bx-car me-1"></i> Vehicles
                        </a>
                        <a href="{{ route('users.index') }}?branch_id={{ $branch->id }}"
                            class="btn btn-sm"
                            style="background:{{ $color }}18;color:{{ $color }};border:1px solid {{ $color }}40;border-radius:8px;font-size:.75rem;">
                            <i class="bx bx-group"></i>
                        </a>
                        <a href="{{ route('branches.edit', $branch) }}"
                            class="btn btn-sm"
                            style="background:{{ $color }}18;color:{{ $color }};border:1px solid {{ $color }}40;border-radius:8px;font-size:.75rem;">
                            <i class="bx bx-edit"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>

<style>
.branch-card-wrap > div { animation: fadeSlideUp .4s ease both; }
@keyframes fadeSlideUp {
    from { opacity:0; transform:translateY(20px); }
    to   { opacity:1; transform:translateY(0); }
}
.branch-card-wrap:nth-child(1) > div { animation-delay:.05s; }
.branch-card-wrap:nth-child(2) > div { animation-delay:.1s; }
.branch-card-wrap:nth-child(3) > div { animation-delay:.15s; }
.branch-card-wrap:nth-child(4) > div { animation-delay:.2s; }
.branch-card-wrap:nth-child(5) > div { animation-delay:.25s; }
</style>
@endsection