@extends('layouts.grafica.app')


@section('header_css')
<!-- DataTables -->
<link href="{{ asset('css/dataTables.bootstrap.min.css') }}" rel="stylesheet">

@endsection

@section('briciole')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Elenco Preventivi
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
                Preventivi
            </li>
        </ol>
    </section>
    @endsection


@section('content')
	@if (!$preventivi->count())
    <div class="callout callout-info">
        <h4>
            Nessuna volontariolontario presente!
        </h4>
        <p>
            Creane un
            <a href="{{ route('preventivi.create') }}" title="Crea preventivo">
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
                <table class="table table-bordered table-hover" id="tbl_preventivi">
                    <thead>
                        <tr>
                            <td>
                                ID
                            </td>
                            <th>
                                Associazione
                            </th>
                            <th>
                                Volontari
                            </th>
                            <th>
                                Data
                            </th>
                            <th>
                                Località
                            </th>
                            <th>
                                Motivazione
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($preventivi as $preventivo)
                        <tr>
                            <td>
                                <a class="preventivo" href="{{ route('preventivi.edit', $preventivo->id) }}" title="Modifica preventivo">
                                    {{$preventivo->id}}
                                </a>
                            </td>
                            <td>
                                <a class="preventivo" href="{{ route('preventivi.edit', $preventivo->id) }}" title="Modifica preventivo">
                                    {{$preventivo->associazione->nome}}
                                </a>
                            </td>
                            <td>
                                {{$preventivo->getVolontariLista()}}
                            </td>
                            <td>
                                {{$preventivo->getDalleAlle()}}
                            </td>
                            <td>
                                {{$preventivo->localita}}
                            </td>
                            <td>
                                {{$preventivo->motivazioni}}
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
             	Pagina {{$preventivi->currentPage()}} di {{$preventivi->lastPage()}}
            </div>
        </div>
        <div class="col-sm-7">
            <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
        		{{ $preventivi->links() }}
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
	    $('#tbl_preventivi').DataTable({
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