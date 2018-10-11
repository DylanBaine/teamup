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
        window.__set_user__ = {!!json_encode($user) !!};
        window.set_users = {!!json_encode($users_collection)!!}
        window.set_company = {!!json_encode($company)!!}
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
            ></application>
        </v-app>
    </div>
<script src="{{asset('js/app.js')}}"></script>
</body>
</html>
