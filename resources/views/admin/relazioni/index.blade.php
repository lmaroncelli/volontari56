@extends('layouts.grafica.app')


@section('header_css')
<!-- DataTables -->
<link href="{{ asset('css/dataTables.bootstrap.min.css') }}" rel="stylesheet">

@endsection

@section('briciole')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Elenco Relazioni
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
                Relazioni
            </li>
        </ol>
        <form action="{!! route('relazioni.search') !!}" method="post">
          {{ csrf_field() }}
        <div class="row">
            <div class="col-sm-4 col-sm-offset-2">
              <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Cerca..." required value="{{$valore}}">
                <span class="input-group-btn">
                  <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
                </span>
              </div>
            </div>
            <div class="col-sm-4">
              <select class="form-control" name="ricerca_campo" id="ricerca_campo">
                @foreach (['nome_asso' => 'associazione', 'volontario' => 'elenco volontari', 'note' => 'note', 'rapporto' => 'rapporto', 'auto' => 'auto'] as $key => $nome)
                  <option value="{{$key}}" @if ($campo == $key) selected="selected" @endif>{{$nome}}</option>
                @endforeach
              </select>
            </div>
        </div>
        </form>
    </section>
    @endsection


@section('content')
	@if (!$relazioni->count())
    <div class="callout callout-info">
        <h4>
            Nessuna relazione presente!
        </h4>
        <p>
            Creane una relazione
            <a href="{{ route('relazioni.create') }}" title="Crea relazione">
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
                <table class="table table-bordered table-hover" id="tbl_relazioni">
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
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($relazioni as $relazione)
                        <tr>
                            <td>
                                <a class="relazione" href="{{ route('relazioni.edit', $relazione->id) }}" title="Modifica relazione">
                                    {{$relazione->id}}
                                </a>
                            </td>
                            <td>
                                <a class="relazione" href="{{ route('relazioni.edit', $relazione->id) }}" title="Modifica relazione">
                                    {{$relazione->associazione->nome}}
                                </a>
                            </td>
                            <td>
                                {{ implode( ', ', $relazione->getVolontariFullName() ) }}
                            </td>
                            <td>
                                {{$relazione->getDalleAlle()}}
                            </td>
                            <td>
                                {{$relazione->note}}
                            </td>
                            <td>
                                {{$relazione->rapporto}}
                            </td>
                            <td>
                                {{$relazione->auto}}
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
             	Pagina {{$relazioni->currentPage()}} di {{$relazioni->lastPage()}}
            </div>
        </div>
        <div class="col-sm-7">
            <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
        		@if ($ordering)
                    {{ $relazioni->appends(['order_by' => $order_by, 'order' => $order])->links() }}
                @else
                    {{ $relazioni->links() }}
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
	    $('#tbl_relazioni').DataTable({
      'paging'      : false,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : false,
      'info'        : false,
      'autoWidth'   : false
    })
	});
    </script>
    @endsection
</link>
