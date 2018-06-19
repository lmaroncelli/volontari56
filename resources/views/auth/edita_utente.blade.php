@extends('layouts.grafica.app')


@section('titolo')
    Modifica utente
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <div class="register-box-body">
                <p class="login-box-msg">Modifica utente {{ $utente->name }}</p>
                <form method="POST" action="{{ route('utenti.modifica',$utente->id) }}">
                    @csrf
                    <input type="hidden" name="utente_id" value="{{$utente->id}}">
                    <div class="form-group has-feedback form-inline">        
                        <label for="ruolo">Ruolo:</label>
                        {{ $utente->ruolo }}
                    </div>
                    <hr>

                    @if ($utente->hasRole('admin'))
                    <div class="form-group has-feedback">        
                        <label for="name">Nome</label>
                        <input id="name" type="text" placeholder="nome" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" 
                            value="{{ old('name') != '' ? old('name') : $utente->name }}" 
                            required autofocus>
                    </div>
                    @endif
                    
                    <div class="form-group has-feedback">   
                        <label for="email">Email</label>
                        <input id="email" type="email" placeholder="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') != '' ? old('email') : $utente->email }}" 
                        required>
                    </div>

                    <div class="form-group has-feedback">        
                        <label for="username">Username</label>

                        <input id="username" type="text" placeholder="username"  class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" 
                        value="{{ old('username') != '' ? old('username') : $utente->username }}" 
                        required autofocus>
                        
                    </div>
                    

                    <div class="box-header">
                      Lascia vuoti questi campi se NON vuoi MODIFICARE la password
                    </div>
                    
                    <div class="form-group has-feedback">
                        <label for="password">Password</label>
                        
                        <input id="password" type="password"  placeholder="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password">
                    </div>

                    <div class="form-group has-feedback">
                        <label for="password-confirm">Conferma password</label>
                        
                        <input id="password-confirm" type="password" placeholder="conferma password"  class="form-control" name="password_confirmation">
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                Modifica
                            </button>
                        </div>
                    </div>
                </form>
            </div> {{-- register-box-body  --}}
        </div> {{-- col-xs-12 --}}
    </div>{{-- row justify-content-center --}}
</div>{{-- container --}}
                
@endsection
