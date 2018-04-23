
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
                                <th>
                                  {!!$field!!}
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($preventivi as $preventivo)
                        <tr @if ($preventivo->trashed()) class="deleted" @endif>
                            <td>
                                {{$preventivo->id}}
                            </td>
                            <td>
                                {{$preventivo->associazione->nome}}
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
    {{-- <div class="row">
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
    </div> --}}
    </div>
    @endif




