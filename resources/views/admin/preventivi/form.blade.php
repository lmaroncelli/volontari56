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
	  @if ($preventivo->exists)
	  	<h1>Modifica Preventivo</h1>
	  @else
	  	<h1>Crea Nuova Preventivo</h1>
	  @endif
	  @component('admin.breadcrumb')
	        @slot('title')
	            Preventivi
	        @endslot
	    @endcomponent
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

	@if ($preventivo->trashed())
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
	  		@if ($preventivo->exists)
	  				@isAdmin
		        	<form role="form" action="{{ route('preventivi.update', $preventivo->id) }}" method="POST">
		        	{{ method_field('PUT') }}
	        	@else
	        		{{-- se non c'è una relazione lo può ancora modificare anche l'associato --}}
	        		@if ( is_null($preventivo->relazione) )
	        			<form role="form" action="{{ route('preventivi.update', $preventivo->id) }}" method="POST">
		        		{{ method_field('PUT') }}
	        		@else
			        	<form role="form" action="{{ route('preventivi.index') }}" method="GET">
			        	<fieldset disabled="disabled">
	        		@endif
	        	@endisAdmin
								
				@else
	      
	        <form role="form" action="{{ route('preventivi.store') }}" method="POST">
	      @endif
	        	{!! csrf_field() !!}
				<div class="box-body">
					
					<div class="form-group">
					  <label for="associazione_id">Associazione</label>
					  <select class="form-control" style="width: 100%;" name="associazione_id" id="associazione_id">
					    @foreach ($assos as $id => $nome)
					    	<option value="{{$id}}" @if ($preventivo->associazione_id == $id || old('associazione_id') == $id) selected="selected" @endif>{{$nome}}</option>
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
							  <input type="text" name="data" @if ($preventivo->exists) value="{{ old('data') != '' ? old('data') : $preventivo->dalle->format('d/m/Y') }}" @else value="{{ old('data')}}" @endif class="form-control pull-right" id="datepicker">
							</div>
						</div>
						
						<div class="col-md-4 bootstrap-timepicker">
							<label>Dalle:</label>
							<div class="input-group">
							  <input type="text" name="dal" @if ($preventivo->exists) value="{{ old('dal') != '' ? old('dal') : $preventivo->dalle->format('H:i')}}" @endif class="form-control timepicker">

							  <div class="input-group-addon">
							    <i class="fa fa-clock-o"></i>
							  </div>
							</div>
						</div>
						
						<div class="col-md-4 bootstrap-timepicker">
							<label>Alle:</label>
							<div class="input-group">
							  <input type="text" name="al" @if ($preventivo->exists) value="{{old('al') != ''  ? old('al') : $preventivo->alle->format('H:i')}}" @endif class="form-control timepicker">

							  <div class="input-group-addon">
							    <i class="fa fa-clock-o"></i>
							  </div>
							</div>
						</div>

					</div>

					<div class="form-group">
					  <label for="localita">Località</label>
					  <textarea class="form-control" rows="3" placeholder="Località ..." name="localita" id="localita">@if(old('localita') != ''){{ old('localita') }}@else{{ $preventivo->localita }}@endif</textarea>
					</div>

					<div class="form-group">
					  <label for="mappa_localita">Seleziona la località dalla mappa (doppio click)</label>
					  <div id="map"></div>
					</div>

					<div class="form-group">
					  <label for="motivazioni">Motivazione</label>
					  <textarea class="form-control" rows="3" placeholder="Motivazione ..." name="motivazioni" id="motivazioni">@if(old('motivazioni') != ''){{ old('motivazioni') }}@else{{ $preventivo->motivazioni }}@endif</textarea>
					</div>

				</div> <!-- /.box-body -->
				
				@if (!$preventivo->trashed())
				<div class="box-footer">
					<button type="submit" class="btn btn-primary">
						@if ($preventivo->exists)
							Modifica
						@else
							Crea
						@endif
					</button>
					<a href="{{ url('admin/preventivi') }}" title="Annulla" class="btn btn-warning pull-right">Annulla</a>
				</div>
				@endif
				
			@if ($preventivo->exists)
				@isAssoc
				</fieldset>
				@endisAssoc
        	@endif
        	</form>
      	</div> <!-- /.box -->
      </div><!-- /.col -->
    </div> <!-- /.row -->
	@if ($preventivo->exists && !$preventivo->trashed())
	   <div class="row">
	     	<!-- left column -->
	     <div class="col-md-6">
	     	 <!-- general form elements -->
	     	 <div class="box-operations">
					
					{{-- se non c'è la relazione associata posso cancellare il preventivo --}}
	     	 	@if (is_null($preventivo->relazione))
	     			@include('admin.admin_inc_delete_button')
	     		@else
	     		 	{{-- visualizzo il preventivo con un link per modificarlo (probabilmente per cancellarlo) --}}
	     		 	<a class="btn btn-success" href="{{ route('relazioni.edit', $preventivo->relazione->id) }}" data-toggle="tooltip"  title="Modifica relazione">
	     		 	    {{$preventivo->relazione->id}}
	     		 	</a>
	     	 	@endif
	     		
	     		@if (Auth::user()->hasRole('admin') && !$preventivo->isInTime())
	     			<a href="{{ route('preventivi.apri', $preventivo->id) }}" class="btn bg-navy btn-flat" id="apri_preventivo">Il preventivo è chiuso ! Vuoi aprirlo ?  	<i class="fa fa-unlock"></i></a>
	     		@elseif($preventivo->isAperto()) 
        			<button type="button" class="btn bg-navy btn-flat">Riaperto</button>
	     		@endif

	     		@if ( (!Auth::user()->hasRole('admin') && !$preventivo->isInTime()) || !is_null($preventivo->relazione) )
	     			<button type="button" class="btn btn-success pull-right disabled" data-toggle="tooltip" title="Preventivo scaduto o esiste già la relazione">Crea una relazione di servizio</button>
	     		@else
		     		<a href="{{ route('relazioni.crea-da-preventivo', $preventivo->id) }}" data-toggle="tooltip" title="Crea una relazione di servizio" class="btn btn-success pull-right">
		     			Crea una relazione di servizio
		     		</a>
	     		@endif
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
<script src="{{ asset('js/bootstrap-datepicker.it.js') }}"></script>

<!-- bootstrap time picker -->
<script src="{{ asset('js/bootstrap-timepicker.min.js') }}"></script>



<script type="text/javascript">

	function caricaVolontari(val) {
		var associazione_id = val;
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
	}

	
	@if (!$preventivo->exists || ($preventivo->exists && Auth::user()->hasRole('admin')) )
		
		$(function () {
		    //Initialize Select2 Elements
		    $('.select2').select2();

		    var associazione_id = $("#associazione_id").val();

		    caricaVolontari(associazione_id);

		    $('#associazione_id').change(function(){
		    	caricaVolontari(this.value);
		    });


		    $("#apri_preventivo").click(function(e){
				return window.confirm("Il preventivo verrà riaperto e sarà possibile creare la relazione. Sei sicuro ?")
		    });


		    ////////////////////////////////////////
		    // retrieve selected elements select2 //
		    ////////////////////////////////////////
		    @if ( count(collect(old('volontari')))  ) 
		    $('#volontari').val({{  str_replace('"',' ', collect(old('volontari'))) }}); // Select the option with a value of value
				$('#volontari').trigger('change'); // Notify any JS components that the value changed		    	
		    @endif



		});

	@endif

	var _jsonObjDate = {language: "it", format: 'dd/mm/yyyy', autoclose: true};

	@isAssoc
	_jsonObjDate.startDate = '0d'; // non posso mettere date MINORI DI OGGI 
	@endisAssoc

	$("#datepicker").datepicker(_jsonObjDate);

	//Timepicker
	$('.timepicker').timepicker({
	  language: "it",
	  showInputs: false,
	  showMeridian: false,
	  minuteStep: 1
	})

</script>



<script type="text/javascript">
var map;
var marker;

var markersArray = [];

function clearOverlays() {
  for (var i = 0; i < markersArray.length; i++ ) {
    markersArray[i].setMap(null);
  }
  markersArray.length = 0;
}

function initMap() {                            
    var latitude = 44.059959;
    var longitude = 12.573509;

	var myLatLng = {lat: latitude, lng: longitude};
	
	@if ($preventivo->exists)
		
		var indirizzo = "{{$preventivo->localita}}";

		data = { 
		       'indirizzo': indirizzo, 
		       '_token': jQuery('input[name=_token]').val()
		       };

		if (indirizzo != "") {
			jQuery.ajax({
			        type: "POST",
			        url: '<?=url("admin/preventivi/geocode_ajax") ?>',
			        data: data,
			        dataType: "json",
			        async: false,
			        success: success_geocode
			    });
			}

		function success_geocode(result) {
		  	myLatLng = {lat: result.lat, lng: result.long};

		}
		
	@else

		myLatLng = {lat: latitude, lng: longitude};
	
	@endif




    map = new google.maps.Map(document.getElementById('map'), {
      center: myLatLng,
      zoom: 11,
      scrollwheel: true,
      disableDoubleClickZoom: false, // disable the default map zoom on double click
    });
	

    marker = new google.maps.Marker({
		map: map,
		position: myLatLng,
    });
    markersArray.push(marker);
    
    // Update lat/long value of div when anywhere in the map is clicked    
    {{-- @if (!$preventivo->exists)  --}}
	    google.maps.event.addListener(map,'dblclick',function(event) {          
	        data = { 
	        	'lat': event.latLng.lat(), 
	        	'long': event.latLng.lng(),
	        	'_token': jQuery('input[name=_token]').val() 
	        	}
	        jQuery.ajax({
	                type: "POST",
	                url: '<?=url("admin/preventivi/reverse_geocode_ajax") ?>',
	                data: data,
	                success: success_reverse_geocode
	            });

	       	function success_reverse_geocode(result) {
	       	   jQuery("#localita").val(result);
	       	}
	    });
  {{-- @endif  --}}
    
    // Create new marker on double click event on the map
    google.maps.event.addListener(map,'dblclick',function(event) {
    	clearOverlays();
        marker = new google.maps.Marker({
          position: event.latLng, 
          map: map, 
          title: event.latLng.lat()+', '+event.latLng.lng()
        });
        markersArray.push(marker);
      
    });
    

}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCAyCUJ63a6dtvWfdAaqCmLxrWqOombjM8&language=it&callback=initMap"
async defer></script>


@endsection
