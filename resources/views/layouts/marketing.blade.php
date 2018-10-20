<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>timatik</title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <script>
        window.url = "{{ url('') }}";
        const token = "{{csrf_token()}}";
    </script>
</head>
<body>
    <div id="app" v-cloak>
        <v-app id="inspire">
            @if(session('success'))
            <v-snackbar
                color="info"
                :value="true" top
                :timeout="3000">
                <v-icon class="mr-3" color="white">info</v-icon>
                {{session('success')}}
            </v-snackbar>
            @endif
            @if(session('error'))
            <v-snackbar
                color="error"
                :value="true" top
                :timeout="3000">
                <v-icon class="mr-3" color="white">error</v-icon>
                {{session('error')}}
            </v-snackbar>
            @endif
            <v-toolbar class="white" dark color="primary" v-if="$vuetify.breakpoint.mdAndUp">
                <v-btn flat class="btn__fill-height" large href="{{url('/')}}">timatik (beta)</v-btn>
                <v-spacer></v-spacer>
                <v-btn flat class="btn__fill-height" href="{{url('/pricing')}}">Pricing</v-btn>
                @if(!user())
                <v-btn flat class="btn__fill-height" href="{{url('/login')}}">Login</v-btn>
                <v-btn flat class="btn__fill-height" href="{{url('/register')}}">Register</v-btn>
                @else
                <v-btn flat class="btn__fill-height" href="{{url('/app#/'.user('last_route'))}}">App</v-btn>
                @endif
            </v-toolbar>
            <v-toolbar v-else color="primary" fixed>
                <v-btn flat icon color="white" @click="drawer = !drawer">
                    <v-icon>menu</v-icon>
                </v-btn>
                <v-btn flat class="btn__fill-height white--text" large href="{{url('/')}}">timatik</v-btn>
            </v-toolbar>
            <v-navigation-drawer
                v-model="drawer"
                class="primary"
                fixed
                app>
                <v-list dark>
                    <v-list-tile href="{{url('/')}}">
                        Timatik
                    </v-list-tile>
                    <v-divider></v-divider>
                    <v-list-tile href="{{url('/pricing')}}">
                        Pricing
                    </v-list-tile>
                    @if(!user())
                    <v-list-tile href="{{url('/login')}}">
                        Login
                    </v-list-tile>
                    <v-list-tile href="{{url('/register')}}">
                        Register
                    </v-list-tile>
                    @else
                    <v-list-tile href="{{url('/app#/'.user('last_route'))}}">
                        App
                    </v-list-tile>
                    @endif
                </v-list>
            </v-navigation-drawer>
            <v-container fluid grid-list-md style="padding: 0;">
                @yield('content')
            </v-container>
<!--             <div class="white--text primary padded">
                <v-layout class="padded">
                    <v-flex md3>
                    </v-flex>
                    <v-flex md4></v-flex>
                    <v-flex md4></v-flex>
                    <v-flex md1>
                        <ul>
                            <li>Thing one</li>
                            <li>Thing two</li>
                            <li>Thing three</li>
                        </ul>
                    </v-flex>
                </v-layout>
            </div> -->
            <v-footer class="white--text primary darken-2">
                <v-layout>
                    <v-spacer></v-spacer>
                    <div class="mr-4">
                        &copy; - {{date('Y')}} Timatik 
                    </div>
                </v-layout>
            </v-footer>
        </v-app>
    </div>
<script src="{{asset('js/app.js')}}"></script>
</body>
</html>
