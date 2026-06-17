@extends('layouts.guest')

@section('title', 'Register')

@section('content')
<div class="card">
  <div class="card-body">
    <h4 class="mb-2">Create Account</h4>
    <p class="mb-4 text-muted">Join VDMS Team</p>

    <form method="POST" action="{{ route('register') }}">
      @csrf

      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="form-label">Name</label>
          <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required>
          @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label">Email</label>
          <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required>
          @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
      </div>

      <div class="mb-3">
        <label class="form-label">Password</label>
        <div class="position-relative">
          <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required>
          <span class="toggle-password position-absolute top-50 end-0 translate-middle-y me-3" style="cursor: pointer; color: #697a8d;">
            <i class="bx bx-hide fs-4"></i>
          </span>
        </div>
        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      <div class="mb-4">
        <label class="form-label">Confirm Password</label>
        <div class="position-relative">
          <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
          <span class="toggle-password position-absolute top-50 end-0 translate-middle-y me-3" style="cursor: pointer; color: #697a8d;">
            <i class="bx bx-hide fs-4"></i>
          </span>
        </div>
      </div>

      <button type="submit" class="btn btn-primary d-grid w-100">Create Account</button>
    </form>

    <p class="text-center mt-3">
      <a href="{{ route('login') }}" class="text-decoration-none">Already have an account? Login</a>
    </p>
  </div>
</div>
@endsection

@section('page-scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.toggle-password').forEach(function(icon) {
        icon.addEventListener('click', function() {
            const input = this.previousElementSibling;
            if (input.type === "password") {
                input.type = "text";
                this.innerHTML = '<i class="bx bx-show fs-4"></i>';
            } else {
                input.type = "password";
                this.innerHTML = '<i class="bx bx-hide fs-4"></i>';
            }
        });
    });
});
</script>
@endsection