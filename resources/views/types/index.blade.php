@extends('layouts.app')

@section('content')
    <div class="container">
        <header class="text-center">
            <h1>Post Types</h1>
        </header>
        <div class="row">
            <div class="col-md-8">
                <div class="row">
                    @foreach($types as $type)
                        <div class="col-md-6">
                            <a href="{{url('types/'.$type->slug)}}">
                                <div class="card padded text-center">
                                    <h2>
                                        {{$type->name}}
                                    </h2>
                                </div>
                            </a>                            
                            <br>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-md-4">
                <div class="card padded">
                    <header>
                        <h2>Add Post Type</h2>
                    </header>
                    <form action="{{url('types')}}" method="POST">
                        {{csrf_field()}}
                        <input type="hidden" value="Post" name="model">
                        <div class="form-group">
                            <label for="name">
                                Name
                            </label>
                            <input type="text" class="form-control" id="name" name="name">
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