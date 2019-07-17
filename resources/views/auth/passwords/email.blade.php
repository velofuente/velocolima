@extends('layout')

@section('extraScripts')
    <style>
        .main_div {
            margin-top: 10em;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="{{asset('css/login-styles.css')}}">
@endsection

@section('content')
<div class="container loginContainer" id="mainDiv">
    <div class="login row justify-content-center">
        <div class="col-md-8">
            <div>
                <div class="mx-auto" id="loginTitle">Cambio de  contraseña</div>
                <div class="mx-auto" id="welcomeMessage">Bienvenido a <img src="{{asset('img/iconos/CroppedLogo.png')}}" id="welcomeLogo"></div>

                <div class="card-body">
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="form-group row">
                            {{-- <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Correo Electrónico') }}</label> --}}
                            <div class="col-2 col-xs-2 col-sm-2 col-md-3"></div>
                            <div class="col-8 col-xs-8 col-sm-8 col-md-6 mx-auto">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Email" autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-2 col-xs-2 col-sm-2 col-md-3"></div>
                        </div>

                        <div class="form-group row justify-content-center">
                            <div class="col-2 col-xs-2 col-sm-2 col-md-3"></div>
                            <div class="col-8 col-xs-8 col-sm-8 col-md-6 centerBtn">
                                <button type="submit" class="btn button" id="submitButton">
                                    {{ __('Cambiar contraseña') }}
                                </button>
                            </div>
                            <div class="col-2 col-xs-2 col-sm-2 col-md-3"></div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="col-2 col-xs-2 col-sm-2 col-md-3"></div>
                            <div class="col-8 col-xs-8 col-sm-8 col-md-6 text-center">
                                <a class="btn btn-link register-account" href="{{ url('/register#') }}">
                                    {{ __('¿Aún no tienes una cuenta?') }}
                                </a>
                            </div>
                            <div class="col-2 col-xs-2 col-sm-2 col-md-3"></div>
                        </div>
                    </form>
                    @if (session('status'))
                        <div class="col-4"></div>
                        <div class="col-8 mx-auto text-center alert alert-success" style="font-family: Avenir" role="alert">
                            {{ session('status') }}
                        </div>
                        <div class="col-4"></div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Old/Original version made by Laravel:auth --}}
{{-- <div class="container">
    <div class="row justify-content-center main_div">
        <div class="col-md-8">
            <div class="card bg-dark">
                <div class="card-header bg-dark">Cambiar Contraseña</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">Email:</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }} bg-white text-dark" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Enviar link de cambio de contraseña
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> --}}
@endsection
