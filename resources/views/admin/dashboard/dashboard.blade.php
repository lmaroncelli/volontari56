@extends('layouts.grafica.app')

@section('titolo')
    Dashboard
@endsection


@section('content')
<div class="container">


    <div class="row justify-content-center">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header"><h3 class="box-title">Preventivi in scadenza</h3></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

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
                                                  {!!$name!!}
                                                </th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                            @foreach ($preventivi_arr as $title => $preventivi)
                                                @include('admin.dashboard.inc_display_preventivi_rows', ['preventivi' => $preventivi, 'title' => $title])
                                            @endforeach
                                    </tbody>
                                </table>
                                </div>
                            </div>
                            <!-- /.box-body -->
                    </div>
                    </div>
                </div>
        </div> {{-- \.box --}}
        </div> {{-- \ col-xs-12 --}}
    </div>

    
    @if ($posts->count())

    <div class="row justify-content-center">
    <div class="col-xs-12">
      <div class="box box-primary">
        <div class="box-header"><h3 class="box-title">Post in primo piano &nbsp; <button type="button" class="btn btn-warning btn-flat" data-toggle="tooltip" title="Visible nella Dashboard"><i class="fa fa-star"></i></button></h3></div>
      </div>
    </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-xs-12">
          @foreach ($posts as $post)
          <div class="box box-widget">
              <div class="box-header">
                <div class="user-block">
                  <span class="username"><a href="#">{{$post->autore->name}}</a></span>
                  @php
                    Carbon\Carbon::setLocale('it'); /* in un middleware every request!!*/
                  @endphp
                  <span class="description">Pubblicato - {{$post->created_at->diffForHumans()}}</span>
                </div>
              </div>{{-- box-header --}}
              <div class="attachment-block clearfix" style="padding-left: 20px;">
                  <h4 class="attachment-heading"><a href="{{ route('posts.show', $post->id) }}">{{$post->titolo}}</a></h4>
                  <div class="attachment-text">
                    {{ $post->getExcerpt() }} ... <a href="{{ route('posts.show', $post->id) }}">more</a>
                  </div>
                  <!-- /.attachment-text -->
              </div>
          </div> {{-- box-widget --}}
          @endforeach
        </div> {{--  \ col --}}
    </div> {{--  \.row --}}

    @endif
</div>
@endsection
