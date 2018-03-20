@if ($errors->any())
	<div class="alert alert-danger alert-dismissible">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<h4><i class="icon fa fa-ban"></i> Attenzione!</h4>
		<ul>
			@foreach ( $errors->all() as $error )
				<li>{{ $error }}</li>
			@endforeach
		</ul>
	</div>
@endif


@if (session('status'))
	<div class="alert alert-info">
		  {{ session('status') }}
	</div>
@endif


@if (session('error'))
	<div class="alert alert-danger">
		  {{ session('error') }}
	</div>
@endif