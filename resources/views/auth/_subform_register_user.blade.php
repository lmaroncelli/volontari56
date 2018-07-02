

<div class="form-group has-feedback">   
    <input id="email" type="email" placeholder="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" @if ($user->exists) value="{{ old('email') != '' ? old('email') : $user->email }}" @else value="{{ old('email')}}" @endif" required>
    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
    {{-- @if ($errors->has('email'))
        <span class="invalid-feedback">
            <strong>{{ $errors->first('email') }}</strong>
        </span>
    @endif --}}
</div>

<div class="form-group has-feedback">        
    <input id="username" type="text" placeholder="username"  class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" @if ($user->exists) value="{{ old('username') != '' ? old('username') : $user->username }}" @else value="{{ old('username')}}" @endif" required autofocus>
    <span class="glyphicon glyphicon-text-size form-control-feedback"></span>
</div>

@if ($user->exists)
    <div class="box-header">
      Lascia vuoti questi campi se NON vuoi MODIFICARE la password
    </div>
@endif

<div class="form-group has-feedback">
    <input id="password" type="password"  placeholder="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" @if (!$user->exists) required @endif>
    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
</div>

<div class="form-group has-feedback">
    <input id="password-confirm" type="password" placeholder="conferma password"  class="form-control" name="password_confirmation" @if (!$user->exists) required @endif>
    <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
</div>