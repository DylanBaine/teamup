<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <script>
        window.url = "{{ url('') }}";
        window.__set_user__ = {!!json_encode($user) !!};
    </script>
</head>
<body>
    <div id="app" v-cloak>
        <application
            ref="app"
            v-if="user"
            :user="user"
        ></application>
        <register v-else-if="register"></register>
        <login v-else ref="login"></login>
    </div>
<script src="{{asset('js/app.js')}}"></script>
</body>
</html>
