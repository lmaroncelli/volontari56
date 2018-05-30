@extends('layouts.grafica.app')

@section('titolo')
    Documenti
@endsection


@section('header_css')
	<!-- Select2 -->
	<link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
@endsection


@section('briciole')
	<!-- Content Header (Page header) -->
	<section class="content-header">
	  @if ($doc->exists)
	  	<h1>Modifica attributi documento</h1>
	  @else
	  	<h1>Crea Nuovo documento</h1>
	  @endif
	  <ol class="breadcrumb">
	    <li><a href="{{ url('admin/home') }}"><i class="fa fa-dashboard"></i> Top</a></li>
	    <li class="active">Documenti</li>
	  </ol>
	</section>
@endsection



@section('content')
<div class="row">
  <!-- left column -->
  <div class="col-md-6">
    <!-- general form elements -->
    <div class="box box-primary">
		@if ($doc->exists)
    		<form role="form" action="{{ route('documenti.modifica', $doc->id) }}" method="POST">
		@else
			<form action="{{ route('documenti.upload') }}" method="POST" enctype="multipart/form-data">
    	@endif
		{!! csrf_field() !!}
		<div class="box-body">
			
			@if (!$doc->exists)
				<div class="form-group">
				  <label for="titolo">File</label>
				  <input type="file" class="form-control" name="file" id="file" placeholder="file" required="required">
				</div>
			@endif

			<div class="form-group">
			  <label for="titolo">Titolo</label>
			  <input type="titolo" class="form-control" name="titolo" id="titolo" placeholder="titolo" value="{{$doc->titolo}}" required="required">
			</div>

			<div class="form-group">
			  <label for="argomento">Argomento</label>
			  <input type="argomento" class="form-control" name="argomento" id="argomento" placeholder="argomento" value="{{$doc->argomento}}" required="required">
			</div>
			
			<div class="form-group">
			  <label for="note">Note</label>
			  <textarea class="form-control" rows="3" placeholder="note ..." name="note" id="note">@if(old('note') != ''){{ old('note') }}@else{{ $doc->note }}@endif</textarea>
			</div>

			<div class="form-group">
			  <label for="note">Tipo</label>
			  <select class="form-control" name="tipo" id="tipo">
			    @foreach (['documenti' => 'Documenti', 'circolari' => 'Circolari'] as $key => $nome)
			      <option value="{{$key}}" @if (old('tipo') != '' && old('tipo') == $key) selected="selected" @endif>{{$nome}}</option>
			    @endforeach
			  </select>
			</div>

		</div>
		<div class="box-footer">
		<button type="submit" class="btn btn-primary">
			@if ($doc->exists)
				Modifica
			@else
				Salva
			@endif
		</button>
		<a href="{{ url('admin/documenti') }}" title="Annulla" class="btn btn-warning pull-right">Annulla</a>
		</div>
	</form>
	</div> <!-- /.box -->
</div><!-- /.col -->
</div> <!-- /.row -->
@endsection