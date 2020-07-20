@extends('layouts.grafica.app_pdf')

@section('content')
	@if (!$volontari->count())
    <div class="callout callout-info">
        <h4>
            Nessun volontario presente!
        </h4>
    </div>
    @else
    <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
    @foreach ($volontari->chunk($chunked_element) as $key => $chunk)
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
        <p class="page_number">Pagina {{$key+1}} di {{ count($volontari->chunk($chunked_element)) }}</p>
        <div class="col-xs-12">
            <div class="box-body">
                <table cellpadding="10" cellspacing="0" id="tbl_relazioni">
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
                        @foreach ($chunk as $volontario)
                        <tr {{-- @if ($volontario->trashed()) class="deleted" @endif --}}>
                            <td>
                                {{$volontario->nome}}
                            </td>
                            <td>
                                {{$volontario->cognome}}
                            </td>
                            <td>
                                {{$volontario->registro}}
                            </td>
                            <td>
                                {{$volontario->data_nascita}}
                            </td>
                            <td>
                                {{optional($volontario->associazione)->nome}}
                            </td>
                            <td>
                                @if ($volontario->utente->login_capabilities)
                                  Sì
                                @else
                                  No
                                @endif
                            </td>
                            <td>
                                @if ($volontario->utente->login_capabilities)
                                  {{$volontario->utente->ruolo == 'associazione' ? 'Referente associazione' : $volontario->utente->ruolo}}
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
        		</div>
        </div>
    </div>
    @if ($key+1 < count($volontari->chunk($chunked_element)))
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



