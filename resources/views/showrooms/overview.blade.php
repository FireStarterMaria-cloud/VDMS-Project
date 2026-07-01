@extends('layouts.app')
@section('title', 'Showrooms Overview')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                <i class="bx bx-buildings me-2" style="color:#696cff"></i>Showrooms Overview
            </h4>
            <p class="text-muted mb-0 small">Click any showroom to explore its branches</p>
        </div>
        <a href="{{ route('showrooms.create') }}" class="btn btn-primary btn-sm">
            <i class="bx bx-plus me-1"></i> Add Showroom
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if($showrooms->count() === 0)
    <div class="card text-center py-5">
        <div class="card-body">
            <i class="bx bx-buildings fs-1 text-muted mb-3 d-block"></i>
            <h5 class="text-muted">No showrooms yet</h5>
            <a href="{{ route('showrooms.create') }}" class="btn btn-primary mt-2">
                <i class="bx bx-plus me-1"></i> Add First Showroom
            </a>
        </div>
    </div>
    @else
    <div class="row g-4" id="showroomsGrid">
        @foreach($showrooms as $showroom)
        @php $color = $showroom->theme_color ?? '#696cff'; @endphp
        <div class="col-xl-4 col-md-6">
            <div class="showroom-card h-100"
                style="
                    background: rgba(255,255,255,0.03);
                    border: 1px solid {{ $color }}40;
                    border-radius: 20px;
                    overflow: hidden;
                    transition: transform .35s ease, box-shadow .35s ease, border-color .3s;
                    cursor: pointer;
                    position: relative;
                "
                onclick="goToBranches({{ $showroom->id }})"
                onmouseenter="hoverCard(this, '{{ $color }}')"
                onmouseleave="leaveCard(this, '{{ $color }}')">

                {{-- Top accent bar --}}
                <div style="height:4px;background:linear-gradient(90deg, {{ $color }}, {{ $color }}88);"></div>

                {{-- Glow orb background --}}
                <div style="position:absolute;top:-40px;right:-40px;width:160px;height:160px;background:radial-gradient(circle, {{ $color }}22 0%, transparent 70%);border-radius:50%;pointer-events:none;"></div>

                <div style="padding:1.8rem;">

                    {{-- Logo + Name row --}}
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div style="width:56px;height:56px;border-radius:14px;background:{{ $color }}18;border:1px solid {{ $color }}40;display:flex;align-items:center;justify-content:center;flex-shrink:0;overflow:hidden;">
                            @if($showroom->logo)
                                <img src="{{ asset('storage/' . $showroom->logo) }}"
                                    style="width:100%;height:100%;object-fit:contain;padding:6px;">
                            @else
                                <i class="bx bx-building-house" style="font-size:1.6rem;color:{{ $color }};"></i>
                            @endif
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold" style="color:#f0f0ff;font-size:1rem;">{{ $showroom->name }}</h5>
                            <small style="color:{{ $color }};letter-spacing:.06em;">{{ $showroom->city }}{{ $showroom->country ? ', ' . $showroom->country : '' }}</small>
                        </div>
                    </div>

                    {{-- Stats row --}}
                    <div class="d-flex gap-3 mb-3">
                        <div style="flex:1;background:{{ $color }}12;border-radius:10px;padding:.6rem .8rem;text-align:center;">
                            <div style="font-size:1.3rem;font-weight:700;color:{{ $color }};">{{ $showroom->branches_count }}</div>
                            <div style="font-size:.68rem;color:#9a9abf;text-transform:uppercase;letter-spacing:.08em;">Branches</div>
                        </div>
                        <div style="flex:1;background:{{ $color }}12;border-radius:10px;padding:.6rem .8rem;text-align:center;">
                            <div style="font-size:1.3rem;font-weight:700;color:{{ $color }};">{{ $showroom->users_count }}</div>
                            <div style="font-size:.68rem;color:#9a9abf;text-transform:uppercase;letter-spacing:.08em;">Staff</div>
                        </div>
                        <div style="flex:1;background:{{ $color }}12;border-radius:10px;padding:.6rem .8rem;text-align:center;">
                            <div style="font-size:.75rem;font-weight:600;color:{{ $showroom->is_active ? '#71dd37' : '#ff3e1d' }};">
                                {{ $showroom->is_active ? '● Active' : '● Inactive' }}
                            </div>
                            <div style="font-size:.68rem;color:#9a9abf;text-transform:uppercase;letter-spacing:.08em;">Status</div>
                        </div>
                    </div>

                    {{-- Contact info --}}
                    @if($showroom->phone || $showroom->email)
                    <div style="border-top:1px solid {{ $color }}25;padding-top:.8rem;margin-bottom:.8rem;">
                        @if($showroom->phone)
                        <div style="font-size:.78rem;color:#7a7a9a;margin-bottom:.2rem;">
                            <i class="bx bx-phone me-1" style="color:{{ $color }};"></i>{{ $showroom->phone }}
                        </div>
                        @endif
                        @if($showroom->email)
                        <div style="font-size:.78rem;color:#7a7a9a;">
                            <i class="bx bx-envelope me-1" style="color:{{ $color }};"></i>{{ $showroom->email }}
                        </div>
                        @endif
                    </div>
                    @endif

                    {{-- Action buttons --}}
                    <div class="d-flex gap-2 mt-3" onclick="event.stopPropagation()">
                        <a href="{{ route('showrooms.branches', $showroom) }}"
                            class="btn btn-sm flex-fill"
                            style="background:{{ $color }};color:#fff;border:none;border-radius:8px;font-size:.78rem;font-weight:500;">
                            <i class="bx bx-git-branch me-1"></i> View Branches
                        </a>
                        <a href="{{ route('showrooms.edit', $showroom) }}"
                            class="btn btn-sm"
                            style="background:{{ $color }}18;color:{{ $color }};border:1px solid {{ $color }}40;border-radius:8px;font-size:.78rem;">
                            <i class="bx bx-edit"></i>
                        </a>
                        <form action="{{ route('showrooms.destroy', $showroom) }}" method="POST"
                            onsubmit="return confirm('Delete {{ $showroom->name }}? This cannot be undone.')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm"
                                style="background:rgba(255,62,29,.12);color:#ff3e1d;border:1px solid rgba(255,62,29,.25);border-radius:8px;font-size:.78rem;">
                                <i class="bx bx-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>

<style>
.showroom-card:active { transform: scale(0.98) !important; }
</style>

<script>
function goToBranches(id) {
    const card = event.currentTarget;
    card.style.transform = 'scale(0.97)';
    card.style.opacity = '0.8';
    setTimeout(() => {
        window.location.href = '/showrooms/' + id + '/branches';
    }, 200);
}

function hoverCard(el, color) {
    el.style.transform = 'translateY(-6px)';
    el.style.boxShadow = '0 20px 50px ' + color + '30';
    el.style.borderColor = color + '80';
}

function leaveCard(el, color) {
    el.style.transform = '';
    el.style.boxShadow = '';
    el.style.borderColor = color + '40';
}
</script>
@endsection