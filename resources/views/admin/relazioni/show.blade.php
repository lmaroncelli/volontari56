@extends('layouts.grafica.app')


@section('titolo')
    Relazione
@endsection



@section('header_css')
	<!-- bootstrap datepicker -->
	<link href="{{ asset('css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
	
	<!-- Bootstrap time Picker -->
	<link href="{{ asset('css/bootstrap-timepicker.min.css') }}" rel="stylesheet">

	<!-- Select2 -->
	<link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
@endsection



@section('briciole')
	<!-- Content Header (Page header) -->
	<section class="content-header">
	  	<h1>Relazione</h1>
	  @component('admin.breadcrumb')
        @slot('title')
            Relazioni
        @endslot
    @endcomponent
	</section>
@endsection


@section('content')

	@if ($relazione->trashed())
		<div class="callout callout-danger text-center">
			<h4><i class="icon fa fa-ban"></i> Attenzione</h4>
			<p>Elemento ANNULLATO</p>
		</div>
	@endif

    <div class="row">
      <!-- left column -->
      <div class="col-md-6">
        <!-- general form elements -->
        <div class="box box-primary">
				<div class="box-body">
					
					<div class="form-group">
					  <label>ID: </label>
					  {{$relazione->id}}
					</div>

					<div class="form-group">
					  <label>ID Preventivo: </label>
						{{$relazione->preventivo_id}}
					</div>
					
					<div class="form-group">
					  <label>Associazione</label>
					  {{$relazione->associazione->nome}}
					</div>
					
					<div class="form-group">
						<label>Volontari</label>
						{{$volontari_associati}}
					</div>

					
					{{-- UNICA RIGA --}}
					<div class="row form-group">
						
						<div class="col-md-12">
							<label>Date:</label>
							{{$relazione->dalle->format('d/m/Y')}}
						</div>
						
						<div class="col-md-12">
							<label>Dalle:</label>
							{{ $relazione->dalle->format('H:i') }}
						</div>
						
						<div class="col-md-12">
							<label>Alle:</label>
							{{$relazione->alle->format('H:i') }}
						</div>

					</div>

					<div class="form-group">
					  <label for="rapporto">Rapporto</label>
					  {{ $relazione->rapporto }}
					</div>

					<div class="form-group">
					  <label for="note">Note</label>
					  {{ $relazione->note }}
					</div>


					<div class="form-group">
					  <label for="auto">Auto</label>
					  {{ $relazione->auto }}
					</div>


					<div class="form-group">
					  <label for="km">Km</label>
					  {{$relazione->km}}
					</div>	

				</div> <!-- /.box-body -->
				
				@if (!$relazione->trashed())
				<div class="box-footer">
					<a href="{{ url('admin/relazioni') }}" title="Annulla" class="btn btn-warning pull-right">Annulla</a>
				</div>
				@endif

      	</div> <!-- /.box -->
      </div><!-- /.col -->
     </div> <!-- /.row -->

 	 @if ($relazione->exists && !$relazione->trashed())
     <div class="row">
      	<!-- left column -->
      	<div class="col-md-6">
      	  <!-- general form elements -->
      	 <div class="box-operations">
				
 	     		<a href="{{ route('relazioni.stampa', $relazione->id) }}" target="_blank" title="Stampa la relazione di servizio" class="btn btn-success pull-right">
 	     			Stampa la relazione di servizio
 	     		</a>
 	     	</div> <!-- /.box -->
 	 	</div><!-- /.col -->
 	</div> <!-- /.row -->
 	@endif
@endsection
