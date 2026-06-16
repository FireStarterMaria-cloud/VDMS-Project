@extends('layouts.guest')
@section('title', 'Register')

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

    <h4 class="mb-2">Create Account</h4>
    <p class="mb-4 text-muted">Join VDMS Team</p>

    @if($errors->any())
      <div class="alert alert-danger mb-3">
        @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
      </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
      @csrf
      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="form-label">Name</label>
          <input type="text" name="name" value="{{ old('name') }}"
            class="form-control @error('name') is-invalid @enderror" required />
          @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label">Email</label>
          <input type="email" name="email" value="{{ old('email') }}"
            class="form-control @error('email') is-invalid @enderror" required />
          @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
      </div>
     <div class="mb-3">
  <label class="form-label">Password</label>
  <div style="position:relative;">
    <input type="password" id="password" name="password"
      class="form-control @error('password') is-invalid @enderror"
      placeholder="············" required style="padding-right:40px;" />
    <span class="toggle-password" style="position:absolute;right:12px;top:50%;transform:translateY(-50%);cursor:pointer;">
      <i class="bx bx-hide" style="font-size:18px;color:#6c757d;"></i>
    </span>
  </div>
  @error('password')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
</div>

<div class="mb-4">
  <label class="form-label">Confirm Password</label>
  <div style="position:relative;">
    <input type="password" id="password_confirmation" name="password_confirmation"
      class="form-control" placeholder="············" required style="padding-right:40px;" />
    <span class="toggle-password" style="position:absolute;right:12px;top:50%;transform:translateY(-50%);cursor:pointer;">
      <i class="bx bx-hide" style="font-size:18px;color:#6c757d;"></i>
    </span>
  </div>
</div>
      <button type="submit" class="btn btn-primary d-grid w-100">Create Account</button>
    </form>

    <p class="text-center mt-3">
      <a href="{{ route('login') }}">Already have an account? Login</a>
    </p>
  </div>
</div>
@section('page-scripts')
<script>
document.querySelectorAll('.toggle-password').forEach(function(toggle) {
    toggle.addEventListener('click', function() {
        const input = this.previousElementSibling;
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
});
</script>
@endsection

@endsection