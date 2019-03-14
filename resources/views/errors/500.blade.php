@extends('layouts.grafica.app_error')

@section('content')
	  <!-- Content Header (Page header) -->
	  <section class="content-header text-center">
      <h1>
        500 Errore interno del server
      </h1>
    </section>

	  <!-- Main content -->
	  <section class="content">

	    <div class="error-page">
	      <h2 class="headline text-red">500</h2>

	      <div class="error-content">
	        <h3><i class="fa fa-warning text-red"></i> Oops! Errore imprevisto.</h3>

	        <p>
	          Una mail è stata inviata ai nostri tecnici che interverranno il prima possibile.
	          Torna alla <a href="{{ url('admin/home') }}">dashboard</a>.
	        </p>

	      </div>
	    </div>
	    <!-- /.error-page -->

	  </section>
	  <!-- /.content -->
@endsection