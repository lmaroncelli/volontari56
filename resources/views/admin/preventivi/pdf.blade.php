@extends('layouts.grafica.app_pdf')

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
    @foreach ($preventivi->chunk(5) as $key => $chunk)
    <div class="row">
        <p>Pagina {{$key+1}} di {{ count($preventivi->chunk(5)) }}</p>
        <div class="col-xs-12">
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
                        @foreach ($chunk as $preventivo)
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
    </div>
    @if ($key+1 < count($preventivi->chunk(5)))
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



