@extends('layouts.grafica.app')

@section('titolo')
    {{ $post->titolo }}
@endsection


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xs-12">
            <div class="box box-primary box-header">
                <div class="user-block">
                  <span class="username"><a class="post_author">{{$post->autore->name}}</a></span>
                  @php
                    Carbon\Carbon::setLocale('it'); /* in un middleware every request!!*/
                  @endphp
                  <span class="description">Pubblicato - {{$post->created_at->diffForHumans()}}</span>
                </div>
                <div class="box-header with-border"><h3 class="box-title">{!! $post->titolo !!}</h3></div>
                <div class="box-body">
                	{!! $post->testo !!}
                </div>
           	</div>
        </div>
     </div>
</div>
@endsection