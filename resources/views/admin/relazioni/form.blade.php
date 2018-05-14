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
	  @if ($relazione->exists)
	  	<h1>Modifica Relazione</h1>
	  @else
	  	<h1>Crea Nuova Relazione</h1>
	  @endif
	  <ol class="breadcrumb">
	    <li><a href="#"><i class="fa fa-dashboard"></i> Top</a></li>
	    <li class="active">Relazioni</li>
	  </ol>
	</section>
@endsection


@section('content')
	
	@if ($relazione->exists)
	  <form action="{{ route('preventivi.destroy', $relazione->id) }}" method="POST" id="record_delete">
	  	{{ method_field('DELETE') }}
	    {!! csrf_field() !!}
	    <input type="hidden" name="id" value="{{$relazione->id}}">
	  </form>
	@endif

    <div class="row">
      <!-- left column -->
      <div class="col-md-6">
        <!-- general form elements -->
        <div class="box box-primary">
	  		@if ($relazione->exists)
	        	{{-- <form role="form" action="{{ route('relazioni.update', $relazione->id) }}" method="POST">
	        	{{ method_field('PUT') }} --}}
	        	<form role="form" action="{{ route('relazioni.index') }}" method="GET">
				<fieldset disabled="disabled">
			@else
	        	<form role="form" action="{{ route('relazioni.store') }}" method="POST">
	        @endif
	        	{!! csrf_field() !!}
				<div class="box-body">
					
					<div class="form-group">
					  <label for="associazione_id">Associazione</label>
					  <select class="form-control" style="width: 100%;" name="associazione_id" id="associazione_id">
					    @foreach ($assos as $id => $nome)
					    	<option value="{{$id}}" @if ($relazione->associazione_id == $id) selected="selected" @endif>{{$nome}}</option>
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
							  <input type="text" name="data" @if ($relazione->exists) value="{{$relazione->dalle->format('d/m/Y')}}" @endif class="form-control pull-right" id="datepicker">
							</div>
						</div>
						
						<div class="col-md-4 bootstrap-timepicker">
							<label>Dalle:</label>
							<div class="input-group">
							  <input type="text" name="dal" @if ($relazione->exists) value="{{$relazione->dalle->format('H:i')}}" @endif class="form-control timepicker">

							  <div class="input-group-addon">
							    <i class="fa fa-clock-o"></i>
							  </div>
							</div>
						</div>
						
						<div class="col-md-4 bootstrap-timepicker">
							<label>Alle:</label>
							<div class="input-group">
							  <input type="text" name="al" @if ($relazione->exists) value="{{$relazione->alle->format('H:i')}}" @endif class="form-control timepicker">

							  <div class="input-group-addon">
							    <i class="fa fa-clock-o"></i>
							  </div>
							</div>
						</div>

					</div>

					<div class="form-group">
					  <label for="note">Note</label>
					  <textarea class="form-control" rows="3" placeholder="Note ..." name="note" id="note">{{$relazione->note}}</textarea>
					</div>

					<div class="form-group">
					  <label for="rapporto">Rapporto</label>
					  <textarea class="form-control" rows="3" placeholder="Rapporto ..." name="rapporto" id="rapporto">{{$relazione->rapporto}}</textarea>
					</div>

					<div class="form-group">
					  <label for="auto">Auto</label>
					  <textarea class="form-control" rows="3" placeholder="Auto ..." name="auto" id="auto">{{$relazione->auto}}</textarea>
					</div>

				</div> <!-- /.box-body -->
				<div class="box-footer">
				<button type="submit" class="btn btn-primary">
					@if ($relazione->exists)
						Modifica
					@else
						Crea
					@endif
				</button>
				</div>
			@if ($relazione->exists)
				</fieldset>
        	@endif
        	</form>
      	</div> <!-- /.box -->
      </div><!-- /.col -->
     </div> <!-- /.row -->

 	 @if ($relazione->exists)
     <div class="row">
      	<!-- left column -->
      	<div class="col-md-6">
      	  <!-- general form elements -->
      	  <div class="box-operations">
				@include('admin.admin_inc_delete_button')
 	     		<a href="{{ route('relazioni.stampa', $relazione->id) }}" title="Stampa la relazione di servizio" class="btn btn-success pull-right">
 	     			Stampa la relazione di servizio
 	     		</a>
 	     	</div> <!-- /.box -->
 	 	</div><!-- /.col -->
 	</div> <!-- /.row -->
 	@endif
@endsection



@section('script_footer')

<!-- Select2 -->
<script src="{{ asset('js/select2.full.min.js') }}"></script>

<!-- bootstrap datepicker -->
<script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>

<!-- bootstrap time picker -->
<script src="{{ asset('js/bootstrap-timepicker.min.js') }}"></script>


<script type="text/javascript">
	@if (!$relazione->exists)
	$(function () {
	    //Initialize Select2 Elements
	    $('.select2').select2();

	    $('#associazione_id').change(function(){
	    	var associazione_id = this.value;
	    	var relazione_id = '{{$relazione->id}}';
	    	jQuery.ajax({
	    	        url: '<?=url("admin/preventivi/carica_volontari_ajax") ?>',
	    	        type: "post",
	    	        async: false,
	    	        data : { 
	    	               'associazione_id': associazione_id, 
	    	               'relazione_id': relazione_id,
	    	               '_token': jQuery('input[name=_token]').val()
	    	               },
	    	       	success: function(data) {
	    	         jQuery("#volontari_select").html(data);
	    	         $('.select2').select2();
	    	       }
	    	 });
	    });

	});
	@endif

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
