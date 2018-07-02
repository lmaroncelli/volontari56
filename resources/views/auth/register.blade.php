@extends('layouts.grafica.app')


@section('titolo')
    Crea un nuovo utente Admin
@endsection


@section('briciole')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      @if ($user->exists)
        <h1>Modifica Admin</h1>
      @else
        <h1>Crea Nuovo Admin</h1>
      @endif
      @component('admin.breadcrumb')
          @slot('title')
              Admin
          @endslot
      @endcomponent
    </section>
@endsection

@section('content')
    

    <div class="row">
      <!-- left column -->
      <div class="col-md-6">
        <!-- general form elements -->
        <div class="box box-primary">
            @if ($user->exists)
                <form method="POST" action="{{ route('utenti.modifica',$user->id) }}">
                {{-- Questo parametro serve nella validazione per escludere l'utente corrente dalle unicità --}}
                <input type="hidden" name="utente_id" value="{{$user->id}}">
            @else
                <form method="POST" action="{{ route('register') }}">
            @endif
               @csrf
               
            <div class="box-body">
               
               <div class="form-group has-feedback">        
                   <input id="name" type="text" placeholder="nome" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" @if ($user->exists) value="{{ old('name') != '' ? old('name') : $user->name }}" @else value="{{ old('name')}}" @endif" required autofocus>
                   <span class="glyphicon glyphicon-user form-control-feedback"></span> 
               </div>


               @include('auth._subform_register_user')
              
            </div> <!-- /.box-body -->

            <div class="box-footer">
               <div class="form-group row mb-0">
                   <div class="col-md-6 offset-md-4">
                       <button type="submit" class="btn btn-primary">
                           {{ __('Register') }}
                       </button>
                   </div>
               </div>
            </div>
           </form>
        </div> <!-- /.box -->
      </div><!-- /.col -->
     </div> <!-- /.row -->
@endsection
