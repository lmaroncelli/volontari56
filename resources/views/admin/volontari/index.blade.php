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
                            <th>
                                @if (app('request')->has('order_by') && app('request')->get('order_by') == 'cognome')
                                    @php
                                        app('request')->get('order') == 'asc' ? $order = 'desc' : $order = 'asc';
                                    @endphp
                                    <a href="{{url()->current()}}?order_by=cognome&order={{$order}}">Cognome</a>
                                @else
                                    <a href="{{url()->full()}}?order_by=cognome&order=asc">Cognome</a>
                                @endif
                            </th>
                            <th>
                                Nome
                            </th>
                            <th>
                                Nato il
                            </th>
                            <th>
                                Registro
                            </th>
                            <th>
                                Note
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($volontari as $volontario)
                        <tr>
                            <td>
                                <a class="volontario" href="{{ route('volontari.edit', $volontario->id) }}" title="Modifica volontariolontario">
                                    {{$volontario->cognome}}
                                </a>
                            </td>
                            <td>
                                {{$volontario->nome}}
                            </td>
                            <td>
                                {{$volontario->data_nascita}}
                            </td>
                            <td>
                                {{$volontario->registro}}
                            </td>
                            <td>
                                {{$volontario->nota}}
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
             	Pagina {{$volontari->currentPage()}} di {{$volontari->lastPage()}}
            </div>
        </div>
        <div class="col-sm-7">
            <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
        		{{ $volontari->links() }}
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
      'ordering'    : true,
      'info'        : false,
      'autoWidth'   : true
    })
	});
    </script>
    @endsection
</link>