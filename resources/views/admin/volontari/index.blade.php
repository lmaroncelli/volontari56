@extends('layouts.grafica.app')


@section('header_css')
	<!-- DataTables -->
	<link href="{{ asset('css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
@endsection

@section('briciole')
	<!-- Content Header (Page header) -->
	<section class="content-header">
	  <h1>Elenco Volontari</h1>
	  <ol class="breadcrumb">
	    <li><a href="#"><i class="fa fa-dashboard"></i> Top</a></li>
	    <li class="active">Volontari</li>
	  </ol>
	</section>
@endsection


@section('content')
	@if (!$volontari->count())
		<div class="callout callout-info">
		  <h4>Nessuna volontariolontario presente!</h4>
		  <p>Creane un <a href="{{ route('volontari.create') }}" title="Crea volontario">adesso</a></p>
		</div>
	@else
		<div class="row">
		  <div class="col-xs-12">
		  	<!-- /.box-header -->
		  	<div class="box-body">
		  	  <table id="tbl_volontari" class="table table-bordered table-hover">
		  	    <thead>
		  	    <tr>
		  	      <th>Cognome</th>
		  	      <th>Nome</th>
		  	      <th>Nato il</th>
		  	      <th>Registro</th>
		  	      <th>Note</th>
		  	    </tr>
		  	    </thead>
		  	    <tbody>
							@foreach ($volontari as $volontario)
					    	<tr>
					    		<td>
					    			<a class="volontario" href="{{ route('volontari.edit', $volontario->id) }}" title="Modifica volontariolontario">{{$volontario->cognome}}</a>
					    		</td>
					    		<td>{{$volontario->nome}}</td>
					    		<td>{{$volontario->data_nascita}}</td>
					    		<td>{{$volontario->registro}}</td>
					    		<td>{{$volontario->nota}}</td>
					    	</tr>
							@endforeach
						</tbody>
				   </table>
				 </div><!-- /.box-body -->
			</div>
		</div>
	@endif
@endsection


@section('script_footer')


<!-- DataTables -->
<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/dataTables.bootstrap.min.js') }}"></script>


<script type="text/javascript">
	$(function () {
	    $('#tbl_volontari').DataTable({
      'paging'      : false,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : false,
      'autoWidth'   : true
    })
	});

	

</script>


@endsection
