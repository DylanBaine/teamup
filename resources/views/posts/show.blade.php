@extends('layouts.app')

@section('content')
    <div class="container">
        <header>
            <h1>
                {{$post->name}}
            </h1>
            <h3>
                <a href="{{url('types/'.$post->type->slug)}}">
                    {{$post->type->name}}
                </a>
            </h3>
            @if($post->belongsToUser())
                <p>
                    <a href="{{url('manage/permissions/?post='.$post->id)}}">
                        Manage Permissions
                    </a>
                </p>
            @endif
        </header>
        <hr>
        <section>
            {{$post->content}}
        </section>
    </div>
@stop