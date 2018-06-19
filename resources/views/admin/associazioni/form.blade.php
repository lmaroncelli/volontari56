@extends('layouts.grafica.app')


@section('header_css')
	<!-- Select2 -->
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
	
@endsection

@section('briciole')
	<!-- Content Header (Page header) -->
	<section class="content-header">
	  @if ($asso->exists)
	  	<h1>
	  		Modifica Associazione <span class="badge bg-blue">{{$asso->volontari->count()}} Associati</span>
	  	</h1>
	  @else
	  	<h1>Crea Nuova Associazione</h1>
	  @endif
	  @component('admin.breadcrumb')
	    @slot('title')
	        Associazioni
	    @endslot
	@endcomponent
	</section>
@endsection


@section('content')
		
		@if ($asso->exists)
		  <form action="{{ route('associazioni.destroy', $asso->id) }}" method="POST" id="record_delete">
		  	{{ method_field('DELETE') }}
		    {!! csrf_field() !!}
		    <input type="hidden" name="id" value="{{$asso->id}}">
		  </form>
		@endif

    <div class="row">
      <!-- left column -->
      <div class="col-md-6">
        <!-- general form elements -->
        <div class="box box-primary">
	  		@if ($asso->exists)
	        	<form role="form" action="{{ route('associazioni.update', $asso->id) }}" method="POST">
	        	{{ method_field('PUT') }}
			@else
	        	<form role="form" action="{{ route('associazioni.store') }}" method="POST">
	        @endif
	        	{!! csrf_field() !!}
				<div class="box-body">
					<div class="form-group">
					  <label for="nome">Nome</label>
					  <input type="nome" class="form-control" name="nome" id="nome" placeholder="nome" value="{{$asso->nome}}">
					</div>
					@if ($asso->exists)
						<div class="form-group">
					    	<label for="volontari">Volontari:</label>
							<select multiple="multiple" name="volontari[]" id="volontari" class="form-control select2" data-placeholder="Seleziona i volontari" style="width: 100%;">
							@foreach($volontari as $id => $nome)
								<option value="{{$id}}" @if ( in_array($id, $volontari_associati_ids) || collect(old('volontari'))->contains($id) ) selected="selected" @endif>{{$nome}}</option>
							@endforeach
							</select>
					   </div>
					@endif
				</div> <!-- /.box-body -->
				<div class="box-footer">
				<button type="submit" class="btn btn-primary">
					@if ($asso->exists)
						Modifica
					@else
						Crea
					@endif
				</button>
				<a href="{{ url('admin/associazioni') }}" title="Annulla" class="btn btn-warning pull-right">Annulla</a>
				</div>
        	</form>
      	</div> <!-- /.box -->
      </div><!-- /.col -->
     </div> <!-- /.row -->
     <div class="row">
       	<!-- left column -->
       <div class="col-md-6">
       	
       	 <!-- general form elements -->
       	<div class="box-operations">
       		@include('admin.admin_inc_delete_button')
       	</div> <!-- /.box -->
       
       	</div><!-- /.col -->
     </div> <!-- /.row -->
@endsection


@section('script_footer')
	<!-- Select2 -->
    <script src="{{ asset('js/select2.full.min.js') }}"></script>

	<script type="text/javascript">
		$(function () {
		  //Initialize Select2 Elements
		  $('.select2').select2();
		});
	</script>
@endsection