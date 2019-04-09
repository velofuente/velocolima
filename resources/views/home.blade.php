@extends('layout')
@section('extraStyles')
    <link rel="stylesheet" href="{{asset('css/home.css')}}">
@endsection
@section('content')
<div class="container main">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div>
                <div class="">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <h3>Tu cuenta ha sido verificada.</h3>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
