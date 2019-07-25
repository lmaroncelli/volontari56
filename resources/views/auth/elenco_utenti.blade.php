@extends('layouts.grafica.app')

@section('titolo')
    Utenti
@endsection

@section('header_css')
<!-- DataTables -->
<link href="{{ asset('css/dataTables.bootstrap.min.css') }}" rel="stylesheet">

@endsection

@section('briciole')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Elenco Utenti <span class="badge bg-blue">{{$utenti->total()}}</span>
        </h1>
        @component('admin.breadcrumb')
            @slot('title')
                Utenti
            @endslot
        @endcomponent

         {{-- @include('admin.posts.search') --}}

    </section>
    @endsection


@section('content')
	@if (!$utenti->count())
    <div class="callout callout-info">
        <h4>
            Nessuna utente presente!
        </h4>
    </div>
    @else
    {{--  CREO I FORM PER LA CENLLAZIONE DEI RECORD --}}
  
    @foreach ($utenti as $utente)
      @if ($utente->hasRole('admin'))
        <form action="{{ route('utenti.elimina', $utente->id) }}" id="form_{{$utente->id}}" method="POST" id="record_delete">
          {!! csrf_field() !!}
          <input type="hidden" name="id" value="{{$utente->id}}">
        </form>
      @endif
    @endforeach

    <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
    <div class="row">
        <div class="col-xs-12">
            <!-- /.box-header -->
            <div class="box-body">
                <table class="table table-bordered table-hover" id="tbl_volontari">
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
                                      {{-- Se sono il cognome e non ho ordinamento , il default è per cognome asc, quindi metto ordinamento inverso --}}
                                      {{-- altrimenti anche il cognome ha ordinamento asc --}}
                                      @php
                                          if ($field == 'cognome' && !app('request')->has('order_by'))
                                            {
                                            $new_order = 'desc';
                                            }
                                          else
                                            {
                                            $new_order = 'asc';
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
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($utenti as $utente)
                        <tr>
                            @foreach ($columns as $field => $name)
                                <td>
                                  @if ($field == 'name')
                                    <a class="preventivo" href="{{ route('utenti.edita', $utente->id) }}" title="Modifica utente">
                                      {{$utente->$field}}
                                    </a>
                                  @else
                                    {{$utente->$field}}
                                  @endif
                                </td>
                            @endforeach
                            
                            <td>
                              @if ($utente->hasRole('admin'))
                                <button type="button" class="btn btn-danger btn-flat delete_post pull-right" data-post-id="{{$utente->id}}"><i class="fa fa-trash"></i></button>
                              @endif
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
             	Pagina {{$utenti->currentPage()}} di {{$utenti->lastPage()}}
            </div>
        </div>
        <div class="col-sm-7">
            <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
        		    @if ($ordering)
                    {{ $utenti->appends(['order_by' => $order_by, 'order' => $order])->links() }}
                @else
                    {{ $utenti->links() }}
                @endif
            </div>
        </div>
    </div>
    </div>
    @endif
@endsection