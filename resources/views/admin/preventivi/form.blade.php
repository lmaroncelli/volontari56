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
    <div class="row">
      <!-- left column -->
      <div class="col-md-6">
        <!-- general form elements -->
        <div class="box box-primary">
	  		@if ($preventivo->exists)
	        	<form role="form" action="{{ route('volontari.update', $preventivo->id) }}" method="POST">
	        	{{ method_field('PUT') }}
			@else
	        	<form role="form" action="{{ route('volontari.store') }}" method="POST">
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

	//Date picker
	$('#datepicker').datepicker({
		format: 'dd/mm/yyyy',
	  	autoclose: true,
	});

</script>


@endsection
