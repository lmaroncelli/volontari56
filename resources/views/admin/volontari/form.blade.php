@extends('layouts.grafica.app')



@section('header_css')
	<!-- bootstrap datepicker -->
	<link href="{{ asset('css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
	<!-- Select2 -->
	<link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
@endsection



@section('briciole')
	<!-- Content Header (Page header) -->
	<section class="content-header">
	  @if ($volontario->exists)
	  	<h1>Modifica Volontario</h1>
	  @else
	  	<h1>Crea Nuova Volontario</h1>
	  @endif
	  <ol class="breadcrumb">
	    <li><a href="#"><i class="fa fa-dashboard"></i> Top</a></li>
	    <li class="active">Volontari</li>
	  </ol>
	</section>
@endsection


@section('content')
    <div class="row">
      <!-- left column -->
      <div class="col-md-6">
        <!-- general form elements -->
        <div class="box box-primary">
	  		@if ($volontario->exists)
	        	<form role="form" action="{{ route('volontari.update', $volontario->id) }}" method="POST">
	        	{{ method_field('PUT') }}
			@else
	        	<form role="form" action="{{ route('volontari.store') }}" method="POST">
	        @endif
	        	{!! csrf_field() !!}
				<div class="box-body">
					
					<div class="form-group">
					  <label for="nome">Nome</label>
					  <input type="nome" class="form-control" name="nome" id="nome" placeholder="nome" value="{{$volontario->nome}}">
					</div>
					
					<div class="form-group">
					  <label for="cognome">Cognome</label>
					  <input type="cognome" class="form-control" name="cognome" id="cognome" placeholder="cognome" value="{{$volontario->cognome}}">
					</div>

					<div class="form-group">
					  <label for="registro">Registro</label>
					  <input type="registro" class="form-control" name="registro" id="registro" placeholder="registro" value="{{$volontario->registro}}">
					</div>
					<div class="form-group">
					  <label for="data_nascita">Data di nascita</label>
					  <div class="input-group date">
					    <div class="input-group-addon">
					      <i class="fa fa-calendar"></i>
					    </div>
					    <input type="text" class="form-control pull-right" id="datepicker" name="data_nascita" id="data_nascita" value="{{$volontario->data_nascita}}">
					  </div>
					  <!-- /.input group -->
					</div>
					
					<div class="form-group">
					  <label for="nota">Nota</label>
					  <textarea class="form-control" rows="3" placeholder="Nota ..." name="nota" id="nota"></textarea>
					</div>

					<div class="form-group">
					  <label for="associazione_id">Associazione</label>
					  <select class="form-control select2" style="width: 100%;" name="associazione_id" id="associazione_id">
					    @foreach ($assos as $id => $nome)
					    	<option value="{{$id}}" @if ($volontario->associazione_id == $id) selected="selected" @endif>{{$nome}}</option>
					    @endforeach
					  </select>
					</div>
				</div> <!-- /.box-body -->
				<div class="box-footer">
				<button type="submit" class="btn btn-primary">
					@if ($volontario->exists)
						Modifica
					@else
						Crea
					@endif
				</button>
				</div>
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


<script type="text/javascript">
	$(function () {
	    //Initialize Select2 Elements
	    //$('.select2').select2();
	});

	//Date picker
	$('#datepicker').datepicker({
		format: 'dd/mm/yyyy',
	  	autoclose: true,
	});

</script>


@endsection
