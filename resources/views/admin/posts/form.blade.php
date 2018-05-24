@extends('layouts.grafica.app')

@section('titolo')
    Posts
@endsection


@section('header_css')
	<!-- Select2 -->
	<link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
@endsection


@section('briciole')
	<!-- Content Header (Page header) -->
	<section class="content-header">
	  @if ($post->exists)
	  	<h1>Modifica Post</h1>
	  @else
	  	<h1>Crea Nuovo Post</h1>
	  @endif
	  <ol class="breadcrumb">
	    <li><a href="#"><i class="fa fa-dashboard"></i> Top</a></li>
	    <li class="active">Post</li>
	  </ol>
	</section>
@endsection


@section('content')
	

	@if ($post->trashed())
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
	  			@if ($post->exists)
	        	<form role="form" action="{{ route('posts.update', $post->id) }}" method="POST">
	        	{{ method_field('PUT') }}
					@else
	        	<form role="form" action="{{ route('posts.store') }}" method="POST">
	        	@endif
	        	{!! csrf_field() !!}
				<div class="box-body">
					
					<div class="form-group">
					  <label for="titolo">Titolo</label>
					  <input type="titolo" class="form-control" name="titolo" id="titolo" placeholder="titolo" value="{{$post->titolo}}" required="required">
					</div>
					
					<div class="form-group">
					  <label for="slug">Slug</label>
					  <input type="slug" class="form-control" name="slug" id="slug" placeholder="slug" value="{{$post->slug}}" required="required">
					</div>

				
					@if ($post->exists && !$post->trashed())
					<div class="form-group">
		            <div class="checkbox">
		              <label>
		                <input type="checkbox" id="featured" name="featured" value="1" @if(old('featured') != '' || $post->featured) checked="checked" @endif> Featured
		              </label>
		            </div>
					</div>
					@endif

					<div class="form-group">
					  <label for="nota">Testo</label>
					  <textarea class="form-control" rows="3" placeholder="Testo ..." name="testo" id="testo">@if(old('testo') != ''){{ old('testo') }}@else{{ $post->testo }}@endif</textarea>
					</div>

				</div> <!-- /.box-body -->
				
				@if (!$post->trashed())
				<div class="box-footer">
				<button type="submit" class="btn btn-primary">
					@if ($post->exists)
						Modifica
					@else
						Crea
					@endif
				</button>
				<a href="{{ url('admin/posts') }}" title="Annulla" class="btn btn-warning pull-right">Annulla</a>
				</div>
				@endif
        	</form>
      	</div> <!-- /.box -->
      </div><!-- /.col -->
     </div> <!-- /.row -->
@endsection



@section('script_footer')

<!-- Select2 -->
<script src="{{ asset('js/select2.full.min.js') }}"></script>


<script src='{{ asset('tinymce/tinymce.min.js') }}'></script>

<script>
tinymce.init({
selector: '#testo',
theme: 'modern',
convert_urls: false,
   width: 600,
   height: 300,
   plugins: [
     'advlist autolink link image lists preview hr anchor pagebreak spellchecker',
     'searchreplace wordcount code insertdatetime media nonbreaking',
     'save table contextmenu paste'
   ],
   toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons',


    // without images_upload_url set, Upload tab won't show up
    images_upload_url: '{{ route('posts.upload') }}',

    // override default upload handler to simulate successful upload
        images_upload_handler: function (blobInfo, success, failure) {
            var xhr, formData;
          
            xhr = new XMLHttpRequest();
            xhr.withCredentials = false;
            xhr.open('POST', '{{ route('posts.upload') }}');

            var token = '{{ csrf_token() }}';
            xhr.setRequestHeader("X-CSRF-Token", token);
          
            xhr.onload = function() {
                var json;
            
                if (xhr.status != 200) {
                    failure('HTTP Error: ' + xhr.status);
                    return;
                }
            
                json = JSON.parse(xhr.responseText);
            
                if (!json || typeof json.location != 'string') {
                    failure('Invalid JSON: ' + xhr.responseText);
                    return;
                }
            
                success(json.location);
            };
          
            formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());
          
            xhr.send(formData);
        },

});
</script>


<script type="text/javascript">
	$(function () {
	   jQuery('#titolo').blur(function(event){
	     slug = jQuery("#slug");

	     if (slug.val() == '') {

	       val = jQuery(this).val();
	       
	       jQuery.ajax({
	         url: '<?=url("admin/posts/slug_ajax") ?>',
	         type: "post",
	         data : { 
	           'value': val,
	           '_token': '{{ csrf_token() }}'
	         },
	         success: function(data) {
	           slug.val(data);
	         }
	       });
	     
	     }

	   });
	});
</script>


@endsection
