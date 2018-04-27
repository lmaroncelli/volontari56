@extends('layouts.grafica.app_pdf')

@section('content')
	@if (!$relazioni->count())
    <div class="callout callout-info">
        <h4>
            Nessuna relazione presente!
        </h4>
    </div>
    @else
    <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
    @foreach ($relazioni->chunk(5) as $key => $chunk)
    <div class="row">
        <p>Pagina {{$key+1}} di {{ count($relazioni->chunk(5)) }}</p>
        <div class="col-xs-12">
            <div class="box-body">
                <table class="table table-bordered table-hover" id="tbl_relazioni">
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
                        @foreach ($chunk as $relazione)
                        <tr @if ($preventivo->trashed()) class="deleted" @endif>
                            <td>
                                {{$relazione->id}}
                            </td>
                            <td>
                                {{$relazione->associazione->nome}}
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
    </div>
    @if ($key+1 < count($relazioni->chunk(5)))
     <div class="row">
          <div class="col-xs-12">
            <div class="page-break"></div>
          </div>
      </div>
    @endif
    @endforeach
    </div>
    @endif
@endsection



