@extends('layouts.marketing')
@section('content')
<div class="d-flex justify-center align-center bg-random-shapes fch fvw">
    <div>
        <v-container grid-list-xl>
            <v-layout row wrap justify-center>
                <v-flex md4>
                    <v-card>
                        <v-card-title class="accent white--text">
                            <h1>Basic Account</h1>
                        </v-card-title>
                        <v-card-text>
                            FREE for unlimited users of your company for 14 days.
                            <br>
                            No credit card needed at signup.
                            <br>
                            $5 per user after free trial ends.
                        </v-card-text>
                        <v-card-actions>
                            <v-btn block href="{{url('/register')}}" class="accent">
                                Sign Up
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-flex>
            </v-layout>
        </v-container>
    </div>
</div>

@stop