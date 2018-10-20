@extends('layouts.marketing')
@section('content')
<div class="d-flex justify-center align-center bg-random-shapes fch fvw">
    <div>
        <v-container grid-list-xl>
            <v-layout row wrap justify-center>
                <v-flex md4>
                    <v-card>
                        <v-card-title>
                            <h1>Basic Account</h1>
                        </v-card-title>
                        <v-divider></v-divider>
                        <v-card-text>
                            FREE while in beta.
                            <br>
                            No credit card needed at signup.
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