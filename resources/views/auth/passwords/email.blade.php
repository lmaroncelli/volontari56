@extends('layouts.grafica.app_login')


@section('content')
@if (session('status'))
    <div class="alert alert-info">
          {{ session('status') }}
    </div>
@endif
<div class="login-box-body">
    <p class="login-box-msg">Risetta la tua password</p>

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }} has-feedback">
          <input id="username" type="text" placeholder="username"  class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" required autofocus>
          <span class="glyphicon glyphicon-user form-control-feedback"></span>
          @if ($errors->has('username'))
              <span class="help-block">
                  <strong>{{ $errors->first('username') }}</strong>
              </span>
          @endif
        </div>

        <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    {{ __('Send Password Reset Link') }}
                </button>
                <a class="btn btn-link" href="{{ route('login') }}">
                    {{ __('Torna al login') }}
                </a>
            </div>
        </div>
    </form>
 </div>
  <!-- /.login-box-body -->
               
@endsection
