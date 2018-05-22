@extends('layouts.grafica.app')

@section('titolo')
    Preventivi
@endsection

@section('header_css')
<!-- DataTables -->
<link href="{{ asset('css/dataTables.bootstrap.min.css') }}" rel="stylesheet">

@endsection

@section('briciole')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Elenco Preventivi <span class="badge bg-blue">{{$preventivi->total()}}</span>
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

        @include('admin.preventivi.search')
    
    </section>
    @endsection


@section('content')
	@if (!$preventivi->count())
    <div class="callout callout-info">
        <h4>
            Nessuna volontario presente!
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
                        @foreach ($preventivi as $preventivo)
                        <tr @if ($preventivo->trashed()) class="deleted" @endif>
                            <td>
                                {!!$preventivo->displayInTime()!!}
                            </td>
                            <td>
                                <a class="preventivo" href="{{ route('preventivi.edit', $preventivo->id) }}" title="Modifica preventivo">
                                    {{$preventivo->id}}
                                </a>
                            </td>
                            <td>
                                <a class="preventivo" href="{{ route('preventivi.edit', $preventivo->id) }}" title="Modifica preventivo">
                                    @if (!is_null($preventivo->associazione))
                                        {{$preventivo->associazione->nome}}
                                    @endif
                                </a>
                            </td>
                            <td>
                                {{ implode( ', ', $preventivo->getVolontariFullName() ) }}
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
        		@if ($ordering)
                    {{ $preventivi->appends(['order_by' => $order_by, 'order' => $order])->links() }}
                @else
                    {{ $preventivi->links() }}
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

    <!-- date-range-picker -->
    <script src="{{ asset('js/moment.min.js') }}"></script>
    <script src="{{ asset('js/daterangepicker.js') }}"></script>
    <!-- bootstrap datepicker -->
    <script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datepicker.it.js') }}"></script>


    <script type="text/javascript">
        $(function () {

    	    $('#tbl_preventivi').DataTable({
              'paging'      : false,
              'lengthChange': false,
              'searching'   : false,
              'ordering'    : false,
              'info'        : false,
              'autoWidth'   : false
            });


            //Date range as a button
            $('#daterange-btn').daterangepicker(

              {
                locale : {
                    customRangeLabel: 'Seleziona periodo',
                    format: 'DD/MM/YYYY',
                    applyLabel: 'Conferma',
                    cancelLabel: 'Annulla',
                },
                ranges   : {
                  'Oggi'       : [moment(), moment()],
                  'Ieri'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                  'Ultimi 7 Giorni' : [moment().subtract(6, 'days'), moment()],
                  'Ultimi 30 Giorni': [moment().subtract(29, 'days'), moment()],
                  'Questo Mese'  : [moment().startOf('month'), moment().endOf('month')],
                  'Mese Scorso'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                startDate: moment().subtract(29, 'days'),
                endDate  : moment()
              },
              function (start, end) {
                $('#daterange-btn span').html(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
                $('#cerca_dal').val(start.format('DD/MM/YYYY'));
                $('#cerca_al').val(end.format('DD/MM/YYYY'));
              }

            )

        @if ($dal != '' &&  $al != '')
            var _dal = '{{$dal}}';
            var _al = '{{$al}}';
            $('#daterange-btn span').html(_dal + ' - ' + _al);
        @endif

    	});
    </script>
    @endsection
</link>
