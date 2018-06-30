

<div class="form-group has-feedback">   
    <input id="email" type="email" placeholder="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
    {{-- @if ($errors->has('email'))
        <span class="invalid-feedback">
            <strong>{{ $errors->first('email') }}</strong>
        </span>
    @endif --}}
</div>

<div class="form-group has-feedback">        
    <input id="username" type="text" placeholder="username"  class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" required autofocus>
    <span class="glyphicon glyphicon-text-size form-control-feedback"></span> 
    {{-- @if ($errors->has('username'))
        <span class="invalid-feedback">
            <strong>{{ $errors->first('username') }}</strong>
        </span>
    @endif --}}
</div>


<div class="form-group has-feedback">
    <input id="password" type="password"  placeholder="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
   {{--  @if ($errors->has('password'))
        <span class="invalid-feedback">
            <strong>{{ $errors->first('password') }}</strong>
        </span>
    @endif --}}
</div>

<div class="form-group has-feedback">
    <input id="password-confirm" type="password" placeholder="conferma password"  class="form-control" name="password_confirmation" required>
    <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
</div>