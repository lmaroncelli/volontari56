@extends('layouts.grafica.app')


@section('briciole')
	<!-- Content Header (Page header) -->
	<section class="content-header">
	  <h1>Elenco Associazioni</h1>
	  <ol class="breadcrumb">
	    <li><a href="#"><i class="fa fa-dashboard"></i> Top</a></li>
	    <li class="active">Associazioni</li>
	  </ol>
	</section>
@endsection


@section('content')
	@if (!$assos->count())
		<div class="callout callout-info">
		  <h4>Nessuna Associazione presente!</h4>
		  <p>Creane una <a href="{{ route('associazioni.create') }}" title="Crea Associazione">adesso</a></p>
		</div>
	@else
		@foreach ($assos as $asso)
		    <div class="row">
		     	<div class="col-md-4">
		     	  <!-- Widget: user widget style 1 -->
		     	  <div class="box box-widget widget-user-2">
		     	    <!-- Add the bg color to the header using any of the bg-* classes -->
		     	    <div class="widget-user-header bg-yellow">
		     	      <!-- /.widget-user-image -->
		     	      <h3 class="widget-user-username"><a class="asso" href="{{ route('associazioni.edit', $asso->id) }}" title="Modifica Associazione">{{$asso->nome}}</a></h3>
		     	    </div>
		     	    <div class="box-footer no-padding">
		     	      <ul class="nav nav-stacked">
		     	        <li><a href="#">Associati <span class="pull-right badge bg-blue">{{$asso->volontari->count()}}</span></a></li>
		     	      </ul>
		     	    </div>
		     	  </div>
		     	  <!-- /.widget-user -->
		     	</div>
		    </div> <!-- /.row -->
		@endforeach
	@endif
@endsection
