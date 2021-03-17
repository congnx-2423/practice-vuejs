@extends('layouts.app')
@section('content')
    <div id="vueApp">
        <post-component></post-component>
    </div>
@endsection
@section('extra-js')
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
@endsection
