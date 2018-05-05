@extends('layouts.grafica.app_pdf')

@section('content')
	@if (!$preventivi->count())
    <div class="callout callout-info">
        <h4>
            Nessun preventivo presente!
        </h4>
    </div>
    @else
    <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
    @foreach ($preventivi->chunk($chunked_element) as $key => $chunk)
    <div id="pdf_filter">
       {!! implode('<br />', $filtro_pdf) !!}
    </div>
    <div class="row">
        <p class="page_number">Pagina {{$key+1}} di {{ count($preventivi->chunk($chunked_element)) }}</p>
        <div class="col-xs-12">
            <div class="box-body">
                <table cellpadding="10" cellspacing="0" id="tbl_preventivi">
                    <thead>
                        <tr>
                            @foreach ($columns as $field => $name)
                                <th>
                                  {!!$name!!}
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
    @if ($key+1 < count($preventivi->chunk($chunked_element)))
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



