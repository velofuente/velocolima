@extends('layout')
@section('title')
    Verify
@endsection
@section('extraStyles')
    <link rel="stylesheet" href="{{asset('css/home.css')}}">
@endsection
@section('content')
<div class="container main">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div>
                <div class="">{{ __('Verifique su correo electronico') }}</div>

                <div class="">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Se ha vuelto a enviar un correo de confirmación.') }}
                        </div>
                    @endif

                    {{ __('Antes de proceder, por favor buscar en su correo electronico el link de verificación.') }}
                    {{ __('Si no recibiste el correo') }}, <a href="{{ route('verification.resend') }}">{{ __('haz click aqui para mandar uno nuevo') }}</a>.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
