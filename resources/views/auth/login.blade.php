@extends('layouts.guest')
@section('title', 'Login')

@section('content')
<div class="card">
  <div class="card-body">
    <div class="app-brand justify-content-center mb-4">
      <a href="/" class="app-brand-link gap-2">
        <img src="{{ asset('assets/img/logo/velora_logo.svg') }}" alt="Velora" style="height:36px;">
<span class="app-brand-text demo fw-bolder ms-1">VELORA</span>
      </a>
    </div>

    <h4 class="mb-2">Welcome to VDMS! 👋</h4>
    <p class="mb-4 text-muted">Velora Vehicle Management System</p>

    @if(session('status'))
      <div class="alert alert-success mb-3">{{ session('status') }}</div>
    @endif

    @if($errors->any())
      <div class="alert alert-danger mb-3">
        @foreach($errors->all() as $error)
          <div>{{ $error }}</div>
        @endforeach
      </div>
    @endif

    <form action="{{ route('login') }}" method="POST">
      @csrf
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" value="{{ old('email') }}"
          class="form-control" placeholder="Enter your email" autofocus required />
      </div>
    <div class="mb-3">
  <label class="form-label">Password</label>
  <div style="position: relative;">
    <input type="password" id="password" name="password"
      class="form-control" placeholder="············" required
      style="padding-right: 40px;" />
    <span id="togglePass" style="position:absolute; right:12px; top:50%; transform:translateY(-50%); cursor:pointer;">
      <i class="bx bx-hide" style="font-size:18px; color:#6c757d;"></i>
    </span>
  </div>
</div>
      <div class="mb-3 d-flex justify-content-between align-items-center">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="remember" id="remember" />
          <label class="form-check-label" for="remember">Remember Me</label>
        </div>
        @if(Route::has('password.request'))
          <a href="{{ route('password.request') }}" class="small">Forgot Password?</a>
        @endif
      </div>
      <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
    </form>
  </div>
</div>
@endsection
@section('page-scripts')
<script>
  document.getElementById('togglePass').addEventListener('click', function() {
    const input = document.getElementById('password');
    const icon = this.querySelector('i');
    if(input.type === 'password') {
      input.type = 'text';
      icon.classList.remove('bx-hide');
      icon.classList.add('bx-show');
    } else {
      input.type = 'password';
      icon.classList.remove('bx-show');
      icon.classList.add('bx-hide');
    }
  });
</script>
@endsection