@extends('layouts.guest')
@section('title', 'Forgot Password')

@section('content')
<div class="card">
  <div class="card-body">
    <div class="app-brand justify-content-center mb-4">
      <a href="/" class="app-brand-link gap-2">
        <svg width="32" height="32" viewBox="0 0 32 32" fill="none">
          <circle cx="16" cy="16" r="16" fill="#EB0A1E"/>
          <text x="16" y="22" text-anchor="middle" fill="white" font-size="14" font-weight="bold" font-family="Arial">T</text>
        </svg>
        <span class="app-brand-text demo fw-bolder ms-1">VDMS</span>
      </a>
    </div>

    <h4 class="mb-2">Forgot Password? 🔒</h4>
    <p class="mb-4 text-muted">Enter your email to receive a reset link</p>

    @if(session('status'))
      <div class="alert alert-success mb-3">{{ session('status') }}</div>
    @endif

    @if($errors->any())
      <div class="alert alert-danger mb-3">
        @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
      </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
      @csrf
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" value="{{ old('email') }}"
          class="form-control" placeholder="Enter your email" required />
      </div>
      <button type="submit" class="btn btn-primary d-grid w-100">Send Reset Link</button>
    </form>

    <p class="text-center mt-3">
      <a href="{{ route('login') }}">← Back to Login</a>
    </p>
  </div>
</div>
@endsection