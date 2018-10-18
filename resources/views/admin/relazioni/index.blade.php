@extends('layouts.grafica.app')

@section('titolo')
    Relazioni
@endsection

@section('header_css')
<!-- DataTables -->
<link href="{{ asset('css/dataTables.bootstrap.min.css') }}" rel="stylesheet">

{{-- jQuery datePicker css --}}
<link href="{{ asset('css/daterangepicker.min.css') }}" rel="stylesheet">

@endsection

@section('briciole')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Elenco Relazioni  <span class="badge bg-blue">{{$relazioni->total()}}</span>
        </h1>
        @component('admin.breadcrumb')
            @slot('title')
                Relazioni
            @endslot
        @endcomponent 

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
                            @foreach ($columns as $field => $elem)
                              @php
                              list($name,$ordinamento) = explode('|', $elem);
                              @endphp

                              @if (empty($field))

                                <th>
                                  {!!$field!!}
                                </th>

                              @elseif($ordinamento != 'Order')
                                  
                                <th class="{{$ordinamento}}">
                                  {!!$name!!}
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
                        <tr @if ($relazione->trashed()) class="deleted" @endif>
                            @isAdmin
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
                            @else
                                <td>
                                    <a class="relazione" href="{{ route('relazioni.show', $relazione->id) }}" title="Modifica relazione">
                                        {{$relazione->id}}
                                    </a>
                                </td>
                                <td>
                                    <a class="relazione" href="{{ route('relazioni.show', $relazione->id) }}" title="Modifica relazione">
                                        {{$relazione->associazione->nome}}
                                    </a>
                                </td>
                            @endisAdmin
                            
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
                            <td nowrap="nowrap">
                                {{$relazione->getHoursForView()}}
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
    <script src="{{ asset('js/jquery.daterangepicker.min.js') }}"></script>



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

        var _configObject = {
            format: 'DD/MM/YYYY',
            startOfWeek: 'monday',
            language:'it',
            separator: ' | ',
            setValue: function(s)
            {
            this.innerHTML = s;
            var arr = s.split(' | ');
            $('#cerca_dal').val(arr[0]);
            $('#cerca_al').val(arr[1]);
            }
        };
        //Date range as a button
        $('#daterange-btn')
            .dateRangePicker(_configObject);

        @if ($dal != '' &&  $al != '')
            var _dal = '{{$dal}}';
            var _al = '{{$al}}';
            $('#daterange-btn span').html(_dal + ' | ' + _al);
        @endif
	   
       });
    </script>
    @endsection
</link>
