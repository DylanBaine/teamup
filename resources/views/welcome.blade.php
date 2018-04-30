@extends('layouts.app')
    @section('content')
        <div class="container">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-4">
                    <form action="files" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="filename">
                                File Name
                            </label>
                            <input type="text" id="filename" name="file_name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="file">
                                File
                            </label>
                            <input type="file" id="file" name="file" class="form-control">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">
                                Save
                            </button>
                        </div>
                    </form>
                </div>
                <div class="col-md-2">
                <ul class="navbar-nav">
                    @foreach($fileTypes as $link)
                        <li>
                            @if($link->files->count())
                                <a class="nav-link ml-auto" href="#{{$link->slug}}">{{$link->name}}</a>
                            @endif
                        </li>
                    @endforeach
                </ul>
                </div>
            </div>
            @if(isset($fileTypes))
                <div class="text-center">
                    @foreach($fileTypes as $type)
                        @if($type->files->count())
                            <section id="{{$type->slug}}" class="file-collection">
                                <header>
                                    <h1>{{$type->name}}</h1>
                                </header>
                                <div class="row">
                                    @foreach($type->files as $file)
                                        <div class="col-md-3">
                                            @if($type->name == 'Images')
                                                <a href="{{$file->slug}}" class="nav-link">
                                                    <img width="100%" src="{{$file->slug}}" alt="{{$file->name}}">
                                                </a>
                                                <form action="{{url('files/'.$file->id)}}" method="POST">
                                                    {{csrf_field()}}
                                                    {{method_field('delete')}}
                                                    <button class="btn btn-danger btn-block">Delete</button>
                                                </form>
                                            @else
                                                <div class="text-center card">
                                                    <h3>{{$file->name}}</h3>
                                                    <a href="{{$file->slug}}" download="{{$file->name}}" class="btn btn-success btn-block">Download</a>
                                                    <form action="{{url('files/'.$file->id)}}" method="POST">
                                                        {{csrf_field()}}
                                                        {{method_field('delete')}}
                                                        <button class="btn btn-danger btn-block">Delete</button>
                                                    </form>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </section>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>
    @endsection
