@extends('layouts.grafica.app')



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
	  @if ($preventivo->exists)
	  	<h1>Modifica Preventivo</h1>
	  @else
	  	<h1>Crea Nuova Preventivo</h1>
	  @endif
	  <ol class="breadcrumb">
	    <li><a href="#"><i class="fa fa-dashboard"></i> Top</a></li>
	    <li class="active">Preventivi</li>
	  </ol>
	</section>
@endsection


@section('content')
	
	@if ($preventivo->exists)
	  <form action="{{ route('preventivi.destroy', $preventivo->id) }}" method="POST" id="record_delete">
	  	{{ method_field('DELETE') }}
	    {!! csrf_field() !!}
	    <input type="hidden" name="id" value="{{$preventivo->id}}">
	  </form>
	@endif

    <div class="row">
      <!-- left column -->
      <div class="col-md-6">
        <!-- general form elements -->
        <div class="box box-primary">
	  		@if ($preventivo->exists)
	        	<form role="form" action="{{ route('preventivi.update', $preventivo->id) }}" method="POST">
	        	{{ method_field('PUT') }}
			@else
	        	<form role="form" action="{{ route('preventivi.store') }}" method="POST">
	        @endif
	        	{!! csrf_field() !!}
				<div class="box-body">
					
					<div class="form-group">
					  <label for="associazione_id">Associazione</label>
					  <select class="form-control" style="width: 100%;" name="associazione_id" id="associazione_id">
					    @foreach ($assos as $id => $nome)
					    	<option value="{{$id}}" @if ($preventivo->associazione_id == $id) selected="selected" @endif>{{$nome}}</option>
					    @endforeach
					  </select>
					</div>
					
					<div class="form-group" id="volontari_select">
						@include('admin.preventivi.inc_volontari_select')
					</div>

					
					{{-- UNICA RIGA --}}
					<div class="row form-group">
						
						<div class="col-md-4">
							<label>Date:</label>

							<div class="input-group date">
							  <div class="input-group-addon">
							    <i class="fa fa-calendar"></i>
							  </div>
							  <input type="text" name="data" @if ($preventivo->exists) value="{{$preventivo->dalle->format('d/m/Y')}}" @endif class="form-control pull-right" id="datepicker">
							</div>
						</div>
						
						<div class="col-md-4 bootstrap-timepicker">
							<label>Dalle:</label>
							<div class="input-group">
							  <input type="text" name="dal" @if ($preventivo->exists) value="{{$preventivo->dalle->format('H:i')}}" @endif class="form-control timepicker">

							  <div class="input-group-addon">
							    <i class="fa fa-clock-o"></i>
							  </div>
							</div>
						</div>
						
						<div class="col-md-4 bootstrap-timepicker">
							<label>Alle:</label>
							<div class="input-group">
							  <input type="text" name="al" @if ($preventivo->exists) value="{{$preventivo->alle->format('H:i')}}" @endif class="form-control timepicker">

							  <div class="input-group-addon">
							    <i class="fa fa-clock-o"></i>
							  </div>
							</div>
						</div>

					</div>

					<div class="form-group">
					  <label for="localita">Località</label>
					  <textarea class="form-control" rows="3" placeholder="Località ..." name="localita" id="localita"></textarea>
					</div>

					<div class="form-group">
					  <label for="motivazione">Motivazione</label>
					  <textarea class="form-control" rows="3" placeholder="Motivazione ..." name="motivazione" id="motivazione"></textarea>
					</div>

				</div> <!-- /.box-body -->
				<div class="box-footer">
				<button type="submit" class="btn btn-primary">
					@if ($preventivo->exists)
						Modifica
					@else
						Crea
					@endif
				</button>
				@if ($preventivo->exists)
					@include('admin.admin_inc_delete_button')
				@endif
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
	    //Initialize Select2 Elements
	    $('.select2').select2();

	    $('#associazione_id').change(function(){
	    	var associazione_id = this.value;
	    	var preventivo_id = '{{$preventivo->id}}';
	    	jQuery.ajax({
	    	        url: '<?=url("admin/preventivi/carica_volontari_ajax") ?>',
	    	        type: "post",
	    	        async: false,
	    	        data : { 
	    	               'associazione_id': associazione_id, 
	    	               'preventivo_id': preventivo_id,
	    	               '_token': jQuery('input[name=_token]').val()
	    	               },
	    	       	success: function(data) {
	    	         jQuery("#volontari_select").html(data);
	    	         $('.select2').select2();
	    	       }
	    	 });
	    });

	});

	$("#datepicker").datepicker({
		format: 'dd/mm/yyyy',
	  	autoclose: true,
	});

	//Timepicker
	$('.timepicker').timepicker({
	  showInputs: false,
	  showMeridian: false
	})

</script>


@endsection
