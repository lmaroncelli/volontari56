@extends('layouts.grafica.app')

@section('titolo')
    Preventivo
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
	  <h1>Preventivo</h1>
	  <ol class="breadcrumb">
	    <li><a href="#"><i class="fa fa-dashboard"></i> Top</a></li>
	    <li class="active">Preventivi</li>
	  </ol>
	</section>
@endsection


@section('content')
    <div class="row">
      <!-- left column -->
      <div class="col-md-6">
        <!-- general form elements -->
        <div class="box box-primary">
	  
				<div class="box-body">
					
					<div class="form-group">
					  <label for="associazione_id">Associazione</label>
					  {{$preventivo->associazione->nome}}
					</div>
					
					<div class="form-group" id="volontari_select">
						{{implode(', ', $volontari)}}
					</div>

					
					{{-- UNICA RIGA --}}
					<div class="row form-group">
						
						<div class="col-md-4">
							<label>Data:</label>
							 {{$preventivo->dalle->format('d/m/Y')}}
						</div>
						
						<div class="col-md-3 bootstrap-timepicker">
							<label>Dalle:</label>
							{{$preventivo->dalle->format('H:i')}}
						</div>
						
						<div class="col-md-3 bootstrap-timepicker">
							<label>Alle:</label>
							{{$preventivo->alle->format('H:i')}}
						</div>

						<div class="col-md-2 bootstrap-timepicker">
							{{Utility::diff_dalle_alle($preventivo->dalle, $preventivo->alle)}}
						</div>

					</div>

					<div class="form-group">
					  <label for="localita">Località</label>
					  {{$preventivo->localita}}
					</div>

					<div class="form-group">
					  <label for="motivazione">Motivazione</label>
					  {{$preventivo->motivazioni}}
					</div>

				</div> <!-- /.box-body -->
				<div class="box-footer">
				<form role="form" action="{{ route('volontari.store') }}" method="POST">
					<button type="submit" class="btn btn-primary">
						@if ($preventivo->exists)
							Modifica
						@else
							Crea
						@endif
					</button>
				</form>
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

<!-- bootstrap time picker -->
<script src="{{ asset('js/bootstrap-timepicker.min.js') }}"></script>


<script type="text/javascript">
	$(function () {
	    

	});

	

</script>


@endsection
