@extends('layouts.grafica.app_pdf')

@section('content')
	@if (!count($volontari))
    <div class="callout callout-info">
        <h4>
            Nessun volontario presente!
        </h4>
    </div>
    @else
    <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
    @foreach (array_chunk($volontari,30) as $key => $chunk)
    <div class="row">
        <p>Pagina {{$key+1}} di {{ count(array_chunk($volontari,30)) }}</p>
        <div class="col-xs-12">
            <div class="box-body">
                <table class="table table-bordered table-hover" id="tbl_relazioni">
                    <thead>
                        <tr>
                            @foreach ($columns_pdf as $name)
                                <th>
                                  {!!$name!!}
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($chunk as $volontario)
                        <tr>
                            @foreach ($columns_pdf as $name)
                                <td>
                                    {{$volontario[$name]}}
                                </td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
        		</div>
        </div>
    </div>
    @if ($key+1 < count(array_chunk($volontari,30)))
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


