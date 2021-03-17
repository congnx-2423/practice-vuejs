@extends('layouts.app')
@section('content')
    <div id="vueApp">
        <post-component :current-user="{{ json_encode($currentUser) }}"></post-component>
    </div>
@endsection
@section('extra-js')
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
@endsection
