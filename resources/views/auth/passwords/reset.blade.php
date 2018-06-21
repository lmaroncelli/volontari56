@extends('layouts.grafica.app_login')


@section('content')

@include('layouts.errors')


<div class="login-box-body">
    <p class="login-box-msg">Reimposta la tua password</p>
    <form method="POST" action="{{ route('password.request') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }} has-feedback">
          <input id="username" type="text" placeholder="username"  class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ $username or old('username') }}" required autofocus>
          <span class="glyphicon glyphicon-user form-control-feedback"></span>
          {{-- @if ($errors->has('username'))
              <span class="help-block">
                  <strong>{{ $errors->first('username') }}</strong>
              </span>
          @endif --}}
        </div>

        <div class="form-group has-feedback">
            <input id="password" type="password"  placeholder="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            {{-- @if ($errors->has('password'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif --}}
        </div>

        <div class="form-group has-feedback">
            <input id="password-confirm" type="password"  placeholder="ripeti password"  class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" name="password_confirmation" required>
            <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
            {{-- @if ($errors->has('password_confirmation'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                </span>
            @endif --}}
        </div>

        <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    {{ __('Reimposta Password') }}
                </button>
            </div>
        </div>
    </form>
 </div>
  <!-- /.login-box-body -->
@endsection
