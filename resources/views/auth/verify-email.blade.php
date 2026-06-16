@extends('layouts.guest')
@section('title', 'Verify Email')

@section('content')
<div class="card">
  <div class="card-body text-center">
    <div class="app-brand justify-content-center mb-4">
      <svg width="32" height="32" viewBox="0 0 32 32" fill="none">
        <circle cx="16" cy="16" r="16" fill="#EB0A1E"/>
        <text x="16" y="22" text-anchor="middle" fill="white" font-size="14" font-weight="bold" font-family="Arial">T</text>
      </svg>
    </div>

    <h4 class="mb-2">Verify Your Email ✉️</h4>
    <p class="text-muted mb-4">
      Thanks for signing up! Please verify your email by clicking the link we sent you.
    </p>

    @if(session('status') == 'verification-link-sent')
      <div class="alert alert-success mb-3">A new verification link has been sent!</div>
    @endif

    <form method="POST" action="{{ route('verification.send') }}">
      @csrf
      <button type="submit" class="btn btn-primary d-grid w-100 mb-3">
        Resend Verification Email
      </button>
    </form>

    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" class="btn btn-outline-secondary d-grid w-100">Logout</button>
    </form>
  </div>
</div>
@endsection