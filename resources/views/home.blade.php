@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div id="vueApp">
                        <dashboard-component 
                            :user="{{ json_encode($user) }}"
                            :users="{{ json_encode($users) }}"
                        >
                        </dashboard-component>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('extra-js')
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
@endsection