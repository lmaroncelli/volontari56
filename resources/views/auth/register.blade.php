@extends('layouts.grafica.app')


@section('titolo')
    Crea un nuovo utente
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <div class="register-box-body">
                <p class="login-box-msg">Crea un utente di tipo Associazione o di tipo Admin</p>
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    
                    <div class="form-group has-feedback form-inline">        
                        <label for="ruolo">Ruolo:</label>
                        <select class="form-control" name="ruolo" id="ruolo">
                          @foreach (['admin' => 'Admin', 'associazione' => 'Associazione'] as $key => $nome)
                            <option value="{{$key}}" @if (old('ruolo') != '' && old('ruolo') == $key) selected="selected" @endif>{{$nome}}</option>
                          @endforeach
                        </select>
                    </div>
                    <hr>


                    <div class="form-group has-feedback">        
                        <input id="name" type="text" placeholder="nome" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>
                        <span class="glyphicon glyphicon-user form-control-feedback"></span> 
                        {{-- @if ($errors->has('name'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif --}}
                    </div>
                    
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

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Register') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div> {{-- register-box-body  --}}
        </div> {{-- col-xs-12 --}}
    </div>{{-- row justify-content-center --}}
</div>{{-- container --}}
                
@endsection
