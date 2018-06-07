@extends('layouts.grafica.app_pdf')

@section('content')
	
    <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
    <div id="pdf_filter_container">
       <div id="pdf_filter">
       {!! implode('<br />', $filtro_pdf_relazione) !!}
       </div>
       <div id="pdf_logo">
          <img src="{{ base_path('public/images/provincia-rimini.jpg') }}" alt="Provincia di Rimini">
       </div>
    </div>
    <div class="clear border"></div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box-body">
                <table class="table table-bordered table-hover" id="tbl_relazione_pdf" cellpadding="10" cellspacing="10">
                    <tbody>
                        <tr><td>ID: {{$relazione->id}}</td></tr>
                        <tr><td>Associazione: {{$relazione->associazione->nome}}</td></tr>
                        <tr><td>Volontari: {{implode( ', ', $relazione->getVolontariFullName() )}}</td></tr>
                        <tr><td>Data: {{$relazione->dalle->format('d/m/Y')}}</td></tr>
                        <tr><td>Dalle: {{$relazione->dalle->format('H:i')}}</td></tr>
                        <tr><td>Alle: {{ $relazione->alle->format('H:i')}}</td></tr>
                        <tr><td>Ore: {{$relazione->getHours()}}</td></tr>
                        <tr><td>Auto: {{$relazione->auto}}</td></tr>
                        <tr><td>Note: {{$relazione->note}}</td></tr>
                        <tr><td>Rapporto: {{$relazione->rapporto}}</td></tr>
                        <tr><td style="height: 150px;">Firme GGV: __________________________________________________________________________</td></tr> 
                    </tbody>
                </table>
        		</div>
        </div>
    </div>
    </div>
@endsection



