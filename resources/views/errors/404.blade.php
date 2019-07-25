@extends('layouts.grafica.app_error')

@section('content')
	  <!-- Content Header (Page header) -->
	  <section class="content-header text-center">
	    <h1>
	      404 Error Page
	    </h1>
	  </section>

	  <!-- Main content -->
	  <section class="content">
	    <div class="error-page">
	      <h2 class="headline text-yellow"> 404</h2>

	      <div class="error-content">
	        <h3><i class="fa fa-warning text-yellow"></i> Oops! Pagina non trovata.</h3>

	        <p>
	          Non è possibile trovare la pagina che stai cercando.<br>
	          Torna alla <a href="{{ url('admin/home') }}">dashboard</a>.
	        </p>

	      </div>
	      <!-- /.error-content -->
	    </div>
	    <!-- /.error-page -->
	  </section>
	  <!-- /.content -->
@endsection