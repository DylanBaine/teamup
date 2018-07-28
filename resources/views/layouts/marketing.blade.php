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
        const token = "{{csrf_token()}}";
    </script>
</head>
<body>
    <div id="app" v-cloak>
        <v-app id="inspire">
            <v-toolbar class="white" dark color="primary">
                <v-btn flat class="btn__fill-height" large href="{{url('/')}}">TeamUp</v-btn>
                <v-spacer></v-spacer>
                <v-btn flat class="btn__fill-height" href="{{url('/pricing')}}">Pricing</v-btn>
                <v-btn flat class="btn__fill-height" href="{{url('/login')}}">Login</v-btn>
                <v-btn flat class="btn__fill-height" href="{{url('/register')}}">Register</v-btn>
            </v-toolbar>
            <v-container fluid grid-list-md style="padding: 0;">
                @yield('content')
            </v-container>
        </v-app>
    </div>
<script src="{{asset('js/app.js')}}"></script>
</body>
</html>
