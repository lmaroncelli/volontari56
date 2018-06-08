@extends('layouts.grafica.app')

@section('titolo')
    Posts
@endsection

@section('header_css')
<!-- DataTables -->
<link href="{{ asset('css/dataTables.bootstrap.min.css') }}" rel="stylesheet">

@endsection

@section('briciole')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Elenco Posts <span class="badge bg-blue">{{$posts->total()}}</span>
        </h1>
        @component('admin.breadcrumb')
            @slot('title')
                Posts
            @endslot
        @endcomponent

         @include('admin.posts.search')

    </section>
    @endsection


@section('content')
	@if (!$posts->count())
    <div class="callout callout-info">
        <h4>
            Nessuna Post presente!
        </h4>
        <p>
            Creane uno
            <a href="{{ route('posts.create') }}" title="Crea volontario">
                adesso
            </a>
        </p>
    </div>
    @else
    {{--  CREO I FORM PER LA CENLLAZIONE DEI RECORD --}}
  
    @foreach ($posts as $post)
      <form action="{{ route('posts.destroy', $post->id) }}" id="form_{{$post->id}}" method="POST" id="record_delete">
        {{ method_field('DELETE') }}
        {!! csrf_field() !!}
        <input type="hidden" name="id" value="{{$post->id}}">
      </form>
    @endforeach

    <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
    <div class="row">
        <div class="col-xs-12">
            <!-- /.box-header -->
            <div class="box-body">
                <table class="table table-bordered table-hover" id="tbl_volontari">
                    <thead>
                        <tr>
                            @foreach ($columns as $field => $name)
                              
                                @if (empty($field))

                                  <th>
                                    {!!$field!!}
                                  </th>

                                @else

                                  {{-- se sono il campo per cui è ordinato il listing --}}
                                  @if (app('request')->has('order_by') && app('request')->get('order_by') == $field)
                                      @php
                                          if(app('request')->get('order') == 'desc')
                                            {
                                            $new_order = 'asc';
                                            $class = "sorting_desc";
                                            }
                                          else
                                            {
                                            $new_order = 'desc';
                                            $class = "sorting_asc";
                                            }

                                          $link = "<a href='".url()->current()."?order_by=".$field."&order=".$new_order."'>".$name."</a>";
                                      @endphp
                                  @else
                                      {{-- Se sono il cognome e non ho ordinamento , il default è per cognome asc, quindi metto ordinamento inverso --}}
                                      {{-- altrimenti anche il cognome ha ordinamento asc --}}
                                      @php
                                          if ($field == 'cognome' && !app('request')->has('order_by'))
                                            {
                                            $new_order = 'desc';
                                            }
                                          else
                                            {
                                            $new_order = 'asc';
                                            }
                                          $link = "<a href='".url()->current()."?order_by=".$field."&order=$new_order'>".$name."</a>";
                                          $class="sorting";
                                      @endphp
                                  @endif
                                  <th class="{{$class}}">
                                      {!!$link!!}
                                  </th>

                                @endif

                            @endforeach
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($posts as $post)
                        <tr @if ($post->trashed()) class="deleted" @endif>
                            @foreach ($columns as $field => $name)
                                <td>
                                    @if ($field == 'titolo' || $field == 'slug')
                                        <a href="{{ route('posts.edit', $post->id) }}" title="Modifica post">
                                            {{$post->$field}}
                                        </a>
                                    @elseif($field == 'autore')
                                        @if ($post->has($field) && !is_null($post->$field))
                                          {{$post->$field->name}}
                                        @endif
                                    @elseif($field == 'created_at' || $field == 'updated_at')
                                        {{$post->$field->timezone('Europe/Rome')->format('d/m/Y H:i')}}
                                    @elseif($field == 'featured')

                                      @if ($post->$field)
                                        <button type="button" class="btn btn-warning btn-flat" data-toggle="tooltip" title="Visible nella Dashboard"><i class="fa fa-star"></i></button>
                                      @else
                                        &nbsp;
                                      @endif
                                      
                                    @else
                                        {{$post->$field}}
                                    @endif
                                </td>
                            @endforeach
                            <td>
                              <button type="button" class="btn btn-danger btn-flat delete_post pull-right" data-post-id="{{$post->id}}"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
        		</div>
            </div>
            <!-- /.box-body -->
    </div>
    <div class="row">
        <div class="col-sm-5">
            <div aria-live="polite" class="dataTables_info" id="example2_info" role="status">
             	Pagina {{$posts->currentPage()}} di {{$posts->lastPage()}}
            </div>
        </div>
        <div class="col-sm-7">
            <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
        		    @if ($ordering)
                    {{ $posts->appends(['order_by' => $order_by, 'order' => $order])->links() }}
                @else
                    {{ $posts->links() }}
                @endif
            </div>
        </div>
    </div>
    </div>
    @endif
@endsection


@section('script_footer')
    <!-- DataTables -->
    <script src="{{ asset('js/jquery.dataTables.min.js') }}">
    </script>
    <script src="{{ asset('js/dataTables.bootstrap.min.js') }}">
    </script>
    <script type="text/javascript">
        $(function () {
    	    $('#tbl_volontari').DataTable({
          'paging'      : false,
          'lengthChange': false,
          'searching'   : false,
          'ordering'    : false,
          'info'        : false,
          'autoWidth'   : false
        });

        $(".delete_post").click(function(){

            var postId = $(this).data("post-id");
            if (window.confirm('Sei sicuro di voler cancellare il post?')) {
                $("#form_"+postId).submit();
            }

        });
	});
    </script>
    @endsection
</link>
