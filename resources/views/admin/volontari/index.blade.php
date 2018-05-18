@extends('layouts.grafica.app')


@section('header_css')
<!-- DataTables -->
<link href="{{ asset('css/dataTables.bootstrap.min.css') }}" rel="stylesheet">

@endsection

@section('briciole')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Elenco Volontari
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="#">
                    <i class="fa fa-dashboard">
                    </i>
                    Top
                </a>
            </li>
            <li class="active">
                Volontari
            </li>
        </ol>

         @include('admin.volontari.search')

    </section>
    @endsection


@section('content')
	@if (!$volontari->count())
    <div class="callout callout-info">
        <h4>
            Nessuna volontariolontario presente!
        </h4>
        <p>
            Creane un
            <a href="{{ route('volontari.create') }}" title="Crea volontario">
                adesso
            </a>
        </p>
    </div>
    @else
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
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($volontari as $volontario)
                        <tr>
                            @foreach ($columns as $field => $name)
                                <td>
                                    @if ($field == 'cognome' || $field == 'nome')
                                        <a class="volontario" href="{{ route('volontari.edit', $volontario->id) }}" title="Modifica volontariolontario">
                                            {{$volontario->$field}}
                                        </a>
                                    @elseif($field == 'associazione')
                                        @if ($volontario->has($field) && !is_null($volontario->$field))
                                          {{$volontario->$field->nome}}
                                        @endif
                                    @else
                                        {{$volontario->$field}}
                                    @endif
                                </td>
                            @endforeach
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
             	Pagina {{$volontari->currentPage()}} di {{$volontari->lastPage()}}
            </div>
        </div>
        <div class="col-sm-7">
            <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
        		    @if ($ordering)
                    {{ $volontari->appends(['order_by' => $order_by, 'order' => $order])->links() }}
                @else
                    {{ $volontari->links() }}
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
	});
    </script>
    @endsection
</link>
