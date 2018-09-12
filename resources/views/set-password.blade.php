@extends('layouts.marketing')

@section('content')
<div class="d-flex justify-center align-center bg-gears fch fvw">
    <v-flex md6>
        <v-card>
            <v-card-title>
                @if($user)
                <h2 class="title">
                    Welcome, {{$user->name}}!
                </h2>
                @else
                <h2 class="title">
                    Reset your password.
                </h2>
                @endif
            </v-card-title>
            <v-form action="{{url('set-password')}}" method="post">
                {{csrf_field()}}
                <v-card-text>
                    @if(!$user)
                    <v-text-field
                        label="Email"
                        name="email"
                        type="text"
                    ></v-text-field>
                    @else
                    <input type="hidden" name="email" value="{{$user->email}}">
                    <v-text-field
                        label="New Password"
                        name="password"
                        type="password"
                    ></v-text-field>
                    @endif
                </v-card-text>
                <v-card-actions>
                    <v-btn color="primary" type="submit">Continue</v-btn>
                    @if(!$user)
                    <v-btn color="accent" flat href="{{url('/login')}}">Back to login.</v-btn>
                    @endif
                </v-card-actions>
            </v-form>
        </v-card>
    </v-flex>
</div>
@stop