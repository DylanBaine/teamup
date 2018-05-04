@extends('layouts.app')

@section('content')
    <div class="container fluid">
        <div class="row">
            <div class="col-md-4">
                <header>
                    <h3>Created Groups</h3>
                </header>
                <ul class="navbar-nav">
                    @foreach($groups as $group)
                        <li>
                            <a href="{{url('groups/'.$group->id)}}">{{$group->name}}</a>
                        </li>
                    @endforeach
                </ul>
                <br>
                <header>
                    <h1>
                        Add a new Group
                    </h1>
                </header>
                <form action="{{url('groups')}}" method="POST">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="name">
                            Group Name
                        </label>
                        <input type="text" id="name" name="name" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary btn-block" >Save</button>
                </form>
            </div>
            <div class="col-md-8 pos-ref">
                <div class="row overflowable">
                    @foreach($users as $user)
                        <div class="col-md-4">
                            <div class="text-center card">
                                <h3>
                                    {{$user->name}}
                                </h3>
                                <h6>
                                    {{$user->email}}
                                </h6>
                                <hr>
                                @if($user->groups->count())
                                    <small>
                                        <ul class="text-left navbar-nav">
                                            <h4>Groups</h4>
                                            @foreach($user->groups as $group)
                                                <li>
                                                    <form action="{{url('groups/'.$group->id.'/remove/'.$user->id)}}" method="POST">
                                                        {{csrf_field()}}
                                                        {{method_field('delete')}}
                                                        <button class="btn btn-block btn-danger">Remove from {{$group->name}}</button>
                                                    </form>
                                                </li>
                                                <br>
                                            @endforeach
                                        </ul>
                                    </small>
                                @endif
                                
                                <form action="{{url('groups/manage/users').'/'.$user->id}}" method="POST">
                                    {{csrf_field()}}

                                    <div class="form-group">
                                        <label for="group">Group</label>                                    
                                        <select name="group" id="group" class="form-control">
                                            @foreach($user->availableGroups() as $group)
                                                    <option value="{{$group->id}}">
                                                        {{$group->name}}
                                                    </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-block">
                                        Add To group
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@stop