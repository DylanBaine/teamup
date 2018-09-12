<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>TeamUp</title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <script>
        window.url = "{{ url('') }}";
        window.__set_user__ = {!!json_encode($user) !!};
        window.set_users = {!!json_encode($users_collection)!!}
        const token = "{{csrf_token()}}";
    </script>
</head>
<body>
    <div id="app" v-cloak>
        <v-app :dark="dark" id="inspire">
            @if(session('success'))
            <v-snackbar
                color="info"
                :value="true" top
                :timeout="3000">
                <v-icon class="mr-3" color="white">info</v-icon>
                {{session('success')}}
            </v-snackbar>
            @endif
            <application
                ref="app"
                :user="user"
            ></application><!-- 
            <v-card style="width: 70%; margin: auto;" :value="true" light  v-else-if="!user && !user.password_confimed">
                <v-card-text>
                    <h2 class="title">
                        Thanks for coming over!
                    </h2>
                    <h3 class="subheading">
                        Set your password to start working.
                    </h3>
                    <v-form method="post" action="{{url('set_new_password')}}">
                        <v-layout row wrap>
                            {{csrf_field()}}
                            <v-flex md5>
                                <v-text-field
                                    label="New Password"
                                    type="password"
                                    name="password"
                                ></v-text-field>
                            </v-flex>
                            <v-flex md1></v-flex>
                            <v-flex md2>
                                <v-btn block color="primary" type="submit">
                                    Get Started
                                </v-btn>
                            </v-flex>
                        </v-layout>
                    </v-form>
                </v-card-text>
            </v-card>
            <register v-else-if="register"></register>
            <login v-else ref="login"></login> -->
        </v-app>
    </div>
<script src="{{asset('js/app.js')}}"></script>
</body>
</html>
