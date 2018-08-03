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
    @foreach ($relazioni->chunk($chunked_element) as $key => $chunk)
    <div id="pdf_filter_container">
       <div id="pdf_filter">
       {!! implode('<br />', $filtro_pdf) !!}
       </div>
       <div id="pdf_logo">
          <img src="{{ base_path('public/images/provincia-rimini.jpg') }}" alt="Provincia di Rimini">
       </div>
    </div>
    <div class="clear border"></div>
    <div class="row">
        <p class="page_number">Pagina {{$key+1}} di {{ count($relazioni->chunk($chunked_element)) }}</p>
        <div class="col-xs-12">
            <div class="box-body">
                <table cellpadding="10" cellspacing="0" id="tbl_relazioni">
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
                        <tr @if ($relazione->trashed()) class="deleted" @endif>
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
                            <td nowrap="nowrap">
                                {{$relazione->getHoursForView()}}
                            </td>
                            <td><button type="button" class="btn btn-success no_link">{{$relazione->preventivo_id}}</button></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
        		</div>
        </div>
    </div>
    @if ($key+1 < count($relazioni->chunk($chunked_element)))
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



