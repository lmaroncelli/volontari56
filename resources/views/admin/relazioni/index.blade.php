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

        @include('admin.relazioni.search')

    </section>
    @endsection


@section('content')
	@if (!$relazioni->count())
    <div class="callout callout-info">
        <h4>
            Nessuna relazione presente!
        </h4>
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
                            <td>
                                <button type="button" class="btn btn-success no_link">{{$relazione->preventivo_id}}</button> 
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

    <!-- date-range-picker -->
    <script src="{{ asset('js/moment.min.js') }}"></script>
    <script src="{{ asset('js/daterangepicker.js') }}"></script>
    <!-- bootstrap datepicker -->
    <script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>


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
