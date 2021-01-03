@extends('layouts.app')
@section('content')
<form method='POST' action="{{ route('register') }}">
  @csrf
  <div class="form-group">
    <label for="">Name</label>
    <input name="name" type="text" value="{{ old('name') }}" required class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}">
    @if($errors->has('name') ? ' is-invalid' : '')
    <span class="invalid-feedback">
      <strong>{{ $errors->first('name') }}</strong>
    </span>
    @endif
  </div>
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
    <label for="">Confirm password</label>
    <input name="password_confirmation" type="password" required class='form-control'>
  </div>

  <button type='submit' class="btn btn-primary btn-block">Register!</button>
</form>
@endsection('content')