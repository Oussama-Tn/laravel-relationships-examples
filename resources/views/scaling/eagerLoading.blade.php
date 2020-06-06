@extends('layouts.app_container')

@section('content_container')

    <div class="card">
        <div class="card-header">
            Caching Query Result
        </div>
        <div class="card-body">

            @php
                $parsedMarkdown = resolve('md-parser')->parseFile('md/scaling/eager-loading.md');
            @endphp

            {!! $parsedMarkdown !!}

            @php
                dump($users)
            @endphp
        </div>
    </div>

@endsection
