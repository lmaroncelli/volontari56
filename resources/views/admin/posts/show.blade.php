@extends('layouts.grafica.app')

@section('titolo')
    Post
@endsection


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border"><h3 class="box-title">Post</h3></div>
                <div class="user-block">
                  <span class="username"><a href="#">{{$post->autore->name}}</a></span>
                  @php
                    Carbon\Carbon::setLocale('it'); /* in un middleware every request!!*/
                  @endphp
                  <span class="description">Pubblicato - {{$post->created_at->diffForHumans()}}</span>
                </div>
                <div class="box-body">
                	{!! $post->testo !!}
                </div>
           	</div>
        </div>
     </div>
</div>
@endsection