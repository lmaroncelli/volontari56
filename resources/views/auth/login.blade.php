@extends('layouts.grafica.app_login')

@section('content')

<div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>

    <form method="POST" action="{{ route('login_post') }}">
    {{ csrf_field() }}
        
        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }} has-feedback">
          <input type="username" class="form-control" placeholder="username" name="username" value="{{ old('username') }}" required autofocus>
          <span class="glyphicon glyphicon-user form-control-feedback"></span>
          @if ($errors->has('username'))
              <span class="help-block">
                  <strong>{{ $errors->first('username') }}</strong>
              </span>
          @endif
        </div>

        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} has-feedback">
          <input type="password" class="form-control" placeholder="Password"  name="password" required>
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          @if ($errors->has('password'))
              <span class="help-block">
                  <strong>{{ $errors->first('password') }}</strong>
              </span>
          @endif
        </div>

        <div class="row">
          <div class="col-xs-8">
            <div class="checkbox icheck">
              <label>
                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-xs-4">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Login</button>
          </div>
          <a class="btn btn-link" href="{{ route('password.request') }}">
              {{ __('Password dimenticata ?') }}
          </a>
          <!-- /.col -->
        </div>
    </form>
    

    <!-- /.social-auth-links -->
    {{-- <a href="{{ route('password.request') }}">Forgot Your Password?</a><br> --}}
  
 </div>
  <!-- /.login-box-body -->


@endsection


@section('script_footer')
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' /* optional */
        });
      });
    </script>
@endsection

