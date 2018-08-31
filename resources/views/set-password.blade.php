@extends('layouts.marketing')

@section('content')
<div class="d-flex justify-center align-center bg-gears fch fvw">
    <v-flex md6>
        <v-card>
            <v-card-title>
                <h2 class="title">
                    Welcome, {{user('name')}}!
                </h2>
            </v-card-title>
            <v-form action="{{url('set-password')}}" method="post">
                {{csrf_field()}}
                <v-card-text>
                    <v-text-field
                        label="New Password"
                        name="password"
                    ></v-text-field>
                </v-card-text>
                <v-card-actions>
                    <v-btn color="primary">Continue</v-btn>
                </v-card-actions>
            </v-form>
        </v-card>
    </v-flex>
</div>
@stop