@extends('layouts.app')

@section('content')
    <div class="container">
        <header class="text-center">
            <h1>Post Types</h1>
        </header>
        <div class="row">
            @foreach($types as $type)
                <div class="col-md-3">
                    <a href="{{url('types/'.$type->slug)}}">
                        <div class="card padded text-center">
                            <h2>
                                {{$type->name}}
                            </h2>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@stop