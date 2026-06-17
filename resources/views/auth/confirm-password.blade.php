@extends('layouts.guest')

@section('title', 'Confirm Password')

@section('content')
<div class="card">
  <div class="card-body">
    <h4 class="mb-2">Confirm Password 🔐</h4>
    <p class="mb-4 text-muted">Please confirm your password before continuing.</p>

    @if($errors->any())
      <div class="alert alert-danger mb-3">
        @foreach($errors->all() as $error)
          <div>{{ $error }}</div>
        @endforeach
      </div>
    @endif

    <form method="POST" action="{{ route('password.confirm') }}">
      @csrf

      <div class="mb-4">
        <label class="form-label">Password</label>
        <div class="position-relative">
          <input type="password" 
                 name="password" 
                 id="password" 
                 class="form-control @error('password') is-invalid @enderror" 
                 required autofocus>
          <span class="toggle-password position-absolute top-50 end-0 translate-middle-y me-3" 
                style="cursor: pointer; color: #697a8d;">
            <i class="bx bx-hide fs-4"></i>
          </span>
        </div>
        @error('password')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <button type="submit" class="btn btn-primary d-grid w-100">Confirm</button>
    </form>
  </div>
</div>
@endsection

@section('page-scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggleIcons = document.querySelectorAll('.toggle-password');
    
    toggleIcons.forEach(icon => {
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