@extends('layouts.app')

@section('content')
    <div class="container">
        <header class="text-center">
            <h1>{{$type->name}}</h1>
        </header>
        <div class="row">
            <div class="col-md-8">
                <div class="row">
                    @foreach($type->posts as $post)
                        <div class="col-md-4">
                            <div class="card padded text-center">
                                <h2>
                                    {{$post->name}}
                                </h2>
                                <a class="btn btn-primary btn-block" href="{{url('posts/'.$post->id)}}">
                                    Read
                                </a>
                                @if($post->belongsToUser())
                                    <form action="{{url('posts/'.$post->id)}}" method="POST">
                                        {{csrf_field()}}
                                        {{method_field('DELETE')}}
                                        <button type="submit" class="btn btn-danger btn-block">Delete Post</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-md-4">
                <div class="card padded">
                    <header>
                        <h2>Add {{$type->name}}</h2>
                    </header>
                    <form action="{{url('posts')}}" method="POST">
                        {{csrf_field()}}
                        <input type="hidden" value="{{$type->id}}" name="type_id">
                        <div class="form-group">
                            <label for="name">
                                Name
                            </label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="form-group">
                            <label for="content">
                                Content
                            </label>
                            <textarea name="content" id="content" cols="30" rows="10" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop