@extends('layouts.app')

@section('title', 'Access Denied')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="text-center py-5">
        <h1 style="font-size: 80px; color: #EB0A1E;">403</h1>
        <h2 class="mb-3">Access Denied 🔒</h2>
        <p class="text-muted mb-4">
            You don't have permission to access this page.<br>
            Contact your administrator if you think this is a mistake.
        </p>
        <a href="{{ route('dashboard') }}" class="btn btn-primary">
            <i class="bx bx-home me-1"></i> Back to Dashboard
        </a>
    </div>
</div>
@endsection