@extends('layouts.app')

@section('content')
    <div class="container">
        <header class="text-center">
            <h1>{{$group->name}} Group</h1>
        </header>
        <br>
        <div class="row">
            @foreach($group->users as $user)
                <div class="col-md-3">
                    <div class="card padded">
                        <h2>{{$user->name}}</h2>
                        <p>{{$user->email}}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@stop