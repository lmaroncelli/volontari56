@extends('layouts.grafica.app')



@section('header_css')
	<!-- bootstrap datepicker -->
	<link href="{{ asset('css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
	<!-- Select2 -->
	<link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">

	{{-- bootstrap toogle button --}}
	<link href="{{ asset('css/bootstrap-toggle.min.css') }}" rel="stylesheet">

@endsection



@section('briciole')
	<!-- Content Header (Page header) -->
	<section class="content-header">
	  @if ($volontario->exists)
	  	<h1>Modifica Volontario</h1>
	  @else
	  	<h1>Crea Nuova Volontario</h1>
	  @endif
	  @component('admin.breadcrumb')
          @slot('title')
              Volontari
          @endslot
      @endcomponent
	</section>
@endsection


@section('content')
	

	@if ($volontario->trashed())
		<div class="callout callout-danger text-center">
			<h4><i class="icon fa fa-ban"></i> Attenzione</h4>
			<p>Elemento ANNULLATO - nessuna operazione possibile</p>
		</div>
	@endif

    <div class="row">
      <!-- left column -->
      <div class="col-md-6">
        <!-- general form elements -->
        <div class="box box-primary">
	  			@if ($volontario->exists)
	  				<form method="POST" action="{{ route('utenti.modifica',$volontario->utente->id) }}">
	  				<input type="hidden" name="utente_id" value="{{$volontario->utente->id}}">
					@else
	        	{{-- registro nuovo utente volontario --}}
	        	<form method="POST" action="{{ route('register') }}">
	        @endif
	        	<input type="hidden" name="user" value="volontario">
	        	{!! csrf_field() !!}
				<div class="box-body">
					
					@if ($volontario->exists)

						<div class="form-group has-feedback">        
							<label class="checkbox-inline">
							  <input type="checkbox" name="login_capabilities" value="1" @if ($volontario->utente->hasLoginCapabilites()) checked @endif data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-width="150" data-height="25" data-off="Login Disabilitato" data-on="Login Abilitato"> <b>LOGIN</b>
							</label>
						</div>

						<div class="input-group form-group">
	            <div class="input-group-btn">
	              <button type="button" class="btn btn-danger">Ruolo</button>
	            </div>
	            <select class="form-control" name="ruolo" id="ruolo">
									@foreach (['Referente Associazione','GGV Avanzato','GGV Semplice','Polizia'] as $ruolo)
						    		<option value="{{$ruolo}}" @if ($volontario->utente->ruolo == $ruolo || old('ruolo') == $ruolo) selected="selected" @endif>{{$ruolo}}</option>
									@endforeach									  		
							</select>
	          </div>

					@endif
					
					<div class="form-group has-feedback">        
					    <input id="nome" type="text" placeholder="nome" class="form-control{{ $errors->has('nome') ? ' is-invalid' : '' }}" name="nome" @if ($volontario->exists) value="{{ old('nome') != '' ? old('nome') : $volontario->nome }}" @else value="{{ old('nome')}}" @endif required autofocus>
					    <span class="glyphicon glyphicon-user form-control-feedback"></span> 
					</div>

					<div class="form-group has-feedback">        
					    <input id="cognome" type="text" placeholder="cognome" class="form-control{{ $errors->has('cognome') ? ' is-invalid' : '' }}" name="cognome" @if ($volontario->exists) value="{{ old('cognome') != '' ? old('cognome') : $volontario->cognome }}" @else value="{{ old('cognome')}}" @endif  required autofocus>
					    <span class="glyphicon glyphicon-user form-control-feedback"></span> 
					</div>

					@include('auth._subform_register_volontario')

					<div class="form-group">
					  <label for="registro">Registro</label>
					  <input type="registro" class="form-control" name="registro" id="registro" placeholder="registro" @if ($volontario->exists) value="{{ old('registro') != '' ? old('registro') : $volontario->registro }}" @else value="{{ old('registro')}}" @endif>
					</div>
					<div class="form-group">
					  <label for="data_nascita">Data di nascita</label>
					  <div class="input-group date">
					    <div class="input-group-addon">
					      <i class="fa fa-calendar"></i>
					    </div>
					    <input type="text" class="form-control pull-right" id="datepicker" name="data_nascita" id="data_nascita" @if ($volontario->exists) value="{{ old('data_nascita') != '' ? old('data_nascita') : $volontario->data_nascita }}" @else value="{{ old('data_nascita')}}" @endif>
					  </div>
					  <!-- /.input group -->
					</div>
					@if ($volontario->exists && !$volontario->trashed())
					<div class="form-group">
		            <div class="checkbox">
		              <label>
		                <input type="checkbox" id="elimina" name="elimina" value="1" > Elimina
		              </label>
		            </div>
					</div>
					@endif

					<div class="form-group">
					  <label for="nota">Nota</label>
					  <textarea class="form-control" rows="3" placeholder="Nota ..." name="nota" id="nota">@if(old('nota') != ''){{ old('nota') }}@else{{ $volontario->nota }}@endif</textarea>
					</div>

					<div class="form-group">
					  <label for="associazione_id">Associazione</label>
					  <select class="form-control select2" style="width: 100%;" name="associazione_id" id="associazione_id">
					    @foreach ($assos as $id => $nome)
					    	<option value="{{$id}}" @if ($volontario->associazione_id == $id || old('associazione_id') == $id) selected="selected" @endif>{{$nome}}</option>
					    @endforeach
					  </select>
					</div>
				</div> <!-- /.box-body -->

				@if (!$volontario->trashed())
				<div class="box-footer">
				<button type="submit" class="btn btn-primary">
					@if ($volontario->exists)
						Modifica
					@else
						Crea
					@endif
				</button>
				</div>
				@endif
        	</form>
      	</div> <!-- /.box -->
      </div><!-- /.col -->
     </div> <!-- /.row -->
@endsection



@section('script_footer')

<!-- Select2 -->
<script src="{{ asset('js/select2.full.min.js') }}"></script>

<!-- bootstrap datepicker -->
<script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-datepicker.it.js') }}"></script>


{{-- bootstrap toogle button --}}
<script src="{{ asset('js/bootstrap-toggle.min.js') }}"></script>


<script type="text/javascript">
	$(function () {
	    $("#elimina").change(function(){
	    	if($(this).is(":checked")) {
	    		alert("ATTENZIONE: specifica nelle note se il volontario è escluso o revocato e poi clicca il pulsante 'Modifica' per Eliminare questo elemento !");
	    		$("#nota").focus();
	    	};
	    });
	});

	//Date picker
	$('#datepicker').datepicker({
		format: 'dd/mm/yyyy',
	  	autoclose: true,
	});

</script>


@endsection
