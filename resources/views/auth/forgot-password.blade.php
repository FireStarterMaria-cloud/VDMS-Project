@extends('layouts.guest')

@section('title', 'Forgot Password')

@section('content')
<div class="card">
  <div class="card-body">
    <h4 class="mb-2">Forgot Password?</h4>
    <p class="mb-4 text-muted">Enter your email address and we'll send you a link to reset your password.</p>

    @if (session('status'))
      <div class="alert alert-success">
        {{ session('status') }}
      </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
      @csrf

      <div class="mb-4">
        <label class="form-label">Email Address</label>
        <input type="email" 
               name="email" 
               value="{{ old('email') }}" 
               class="form-control @error('email') is-invalid @enderror" 
               placeholder="superadmin@vdms.com" 
               required autofocus>
        @error('email')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <button type="submit" class="btn btn-primary d-grid w-100">
        Send Password Reset Link
      </button>
    </form>

    <p class="text-center mt-3">
      <a href="{{ route('login') }}" class="text-decoration-none">Back to Login</a>
    </p>
  </div>
</div>
@endsection