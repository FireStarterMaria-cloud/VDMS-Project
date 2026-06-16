@extends('layouts.guest')
@section('title', 'Confirm Password')

@section('content')
<div class="card">
  <div class="card-body">
    <h4 class="mb-2">Confirm Password 🔐</h4>
    <p class="mb-4 text-muted">Please confirm your password before continuing.</p>

    @if($errors->any())
      <div class="alert alert-danger mb-3">
        @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
      </div>
    @endif

    <form method="POST" action="{{ route('password.confirm') }}">
      @csrf
      <div class="mb-4">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" required />
      </div>
      <button type="submit" class="btn btn-primary d-grid w-100">Confirm</button>
    </form>
  </div>
</div>
@endsection