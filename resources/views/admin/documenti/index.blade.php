@extends('layouts.grafica.app')

@section('titolo')
    Documenti
@endsection

@section('header_css')
<!-- DataTables -->
<link href="{{ asset('css/dataTables.bootstrap.min.css') }}" rel="stylesheet">

@endsection

@section('briciole')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Elenco Documenti <span class="badge bg-blue">{{$documenti->total()}}</span>
        </h1>
        @component('admin.breadcrumb')
            @slot('title')
                Documenti
            @endslot
        @endcomponent
       {{--  @include('admin.documenti.search') --}}
    </section>
    @endsection


@section('content')
	@if (!$documenti->count())
    <div class="callout callout-info">
        <h4>
            Nessuna documento presente!
        </h4>
        @isAdmin
        <p>
            Creane un
            <a href="{{ route('documenti.form-upload') }}" title="Crea docuemto">
                adesso
            </a>
        </p>
        @endisAdmin
    </div>
    @else
    
    @foreach ($documenti as $documento)
      <form action="{{ route('documenti.elimina', $documento->id) }}" id="form_{{$documento->id}}" method="POST" id="record_delete">
        {!! csrf_field() !!}
      </form>
    @endforeach

    <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
    <div class="row">
        <div class="col-xs-12">
            <!-- /.box-header -->
            <div class="box-body">
                <table class="table table-bordered table-hover" id="tbl_documenti">
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
                                    {{-- Se sono il id e non ho ordinamento , il default è per id desc, quindi metto ordinamento inverso --}}
                                    {{-- altrimenti anche il id ha ordinamento asc --}}
                                    @php
                                        if ($field == 'id' && !app('request')->has('order_by'))
                                          {
                                          $new_order = 'asc';
                                          }
                                        else
                                          {
                                          $new_order = 'desc';
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
                            @isAdmin
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            @endisAdmin
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($documenti as $documento)
                        <tr>
                            <td>
                                <a class="documento" href="{{asset('storage').'/'.$documento->file}}" title="Scarica documento" target="_blank">
                                {!!$documento->titolo!!}
                                </a>
                            </td>
                            <td>
                                {{$documento->argomento}}
                            </td>
                            <td>
                                {{$documento->tipo}}
                            </td>
                            @php
                              Carbon\Carbon::setLocale('it'); /* in un middleware every request!!*/
                            @endphp
                            <td>
                                {{ $documento->created_at->diffForHumans() }} 
                            </td>
                            @isAdmin
                            <td>
                                <a class="documento" href="{{ route('documenti.modifica', $documento->id) }}" title="Modifica documento">
                                 <button type="button" class="btn btn-primary btn-flat pull-right"><i class="fa fa-edit"></i></button>
                                </a>
                            </td>
                            <td>
                              <button type="button" class="btn btn-danger btn-flat delete_doc pull-right" data-doc-id="{{$documento->id}}"><i class="fa fa-trash"></i></button>
                            </td>
                            @endisAdmin
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
             	Pagina {{$documenti->currentPage()}} di {{$documenti->lastPage()}}
            </div>
        </div>
        <div class="col-sm-7">
            <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
        		@if ($ordering)
                    {{ $documenti->appends(['order_by' => $order_by, 'order' => $order])->links() }}
                @else
                    {{ $documenti->links() }}
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

    	    $('#tbl_documenti').DataTable({
              'paging'      : false,
              'lengthChange': false,
              'searching'   : false,
              'ordering'    : false,
              'info'        : false,
              'autoWidth'   : false
            });

            $(".delete_doc").click(function(){

                var docId = $(this).data("doc-id");
                if (window.confirm('Sei sicuro di voler cancellare il documento ?')) {
                    $("#form_"+docId).submit();
                }

            });
    	});
    </script>
    @endsection
</link>
