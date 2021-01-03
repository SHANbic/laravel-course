@extends('layouts.app')
@section('content')
<form method='POST' action="{{ route('login') }}">
  @csrf
  <div class="form-group">
    <label for="">Email</label>
    <input name="email" type="email" value="{{ old('email') }}" required class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}">
    @if($errors->has('email') ? ' is-invalid' : '')
    <span class="invalid-feedback">
      <strong>{{ $errors->first('email') }}</strong>
    </span>
    @endif
  </div>
  <div class="form-group">
    <label for="">Password</label>
    <input name="password" type="password" required class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}">
    @if($errors->has('password') ? ' is-invalid' : '')
    <span class="invalid-feedback">
      <strong>{{ $errors->first('password') }}</strong>
    </span>
    @endif
  </div>

  <div class="form-group">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" name="remember" id="remember" value="{{ old('remember') ? 'checked' : '' }}">
      <label for="remember" class="form-check-label">remember me</label>
    </div>
  </div>

  <button type='submit' class="btn btn-primary btn-block">Login!</button>
</form>
@endsection('content')