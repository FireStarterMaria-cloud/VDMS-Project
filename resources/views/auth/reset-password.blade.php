@extends('layouts.guest')
@section('title', 'Reset Password')

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

    <h4 class="mb-2">Reset Password 🔑</h4>
    <p class="mb-4 text-muted">Enter your new password below</p>

    @if($errors->any())
      <div class="alert alert-danger mb-3">
        @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
      </div>
    @endif

    <form method="POST" action="{{ route('password.store') }}">
      @csrf
      <input type="hidden" name="token" value="{{ $request->route('token') }}" />
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" value="{{ old('email', $request->email) }}"
          class="form-control @error('email') is-invalid @enderror" required />
        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      <div class="mb-3">
        <label class="form-label">New Password</label>
        <input type="password" name="password"
          class="form-control @error('password') is-invalid @enderror" required />
        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      <div class="mb-4">
        <label class="form-label">Confirm New Password</label>
        <input type="password" name="password_confirmation" class="form-control" required />
      </div>
      <button type="submit" class="btn btn-primary d-grid w-100">Reset Password</button>
    </form>
  </div>
</div>
@endsection