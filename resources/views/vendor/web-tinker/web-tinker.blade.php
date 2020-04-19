@extends('layouts.app')

@section('css')
    <!-- Style sheets-->
    <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Mono:400,400i,600" rel="stylesheet">
    <link href='{{ asset(mix('app.css', 'vendor/web-tinker')) }}' rel='stylesheet' type='text/css'>
@endsection

@section('content')
    <div id="web-tinker" v-cloak>
        <tinker path="{{ $path }}"></tinker>
    </div>
@endsection


@section('js')
    <script src="{{ asset(mix('app.js', 'vendor/web-tinker')) }}"></script>
@endsection
