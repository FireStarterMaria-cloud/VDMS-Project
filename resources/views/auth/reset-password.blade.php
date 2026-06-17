@extends('layouts.guest')

@section('title', 'Reset Password')

@section('content')
<div class="card">
  <div class="card-body">
    <h4 class="mb-2">Reset Password</h4>

    <form method="POST" action="{{ route('password.update') }}">
      @csrf

      <input type="hidden" name="token" value="{{ $token }}">

      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required>
        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      <div class="mb-3">
        <label class="form-label">New Password</label>
        <div class="position-relative">
          <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required>
          <span class="toggle-password position-absolute top-50 end-0 translate-middle-y me-3" style="cursor: pointer; color: #697a8d;">
            <i class="bx bx-hide fs-4"></i>
          </span>
        </div>
        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      <div class="mb-4">
        <label class="form-label">Confirm New Password</label>
        <div class="position-relative">
          <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
          <span class="toggle-password position-absolute top-50 end-0 translate-middle-y me-3" style="cursor: pointer; color: #697a8d;">
            <i class="bx bx-hide fs-4"></i>
          </span>
        </div>
      </div>

      <button type="submit" class="btn btn-primary d-grid w-100">Reset Password</button>
    </form>
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