@extends('layouts.main')

@section('content')
    <div class="container loginContainer" id="mainDiv">
        <div class="login row justify-content-center">
            <div class="col-md-8">
                <div>
                    <div class="mx-auto" id="loginTitle">Restablecer contraseña</div>
                    <div class="mx-auto" id="welcomeMessage">Bienvenido a <img src="{{asset('img/iconos/CroppedLogo.png')}}" id="welcomeLogo"></div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">
                            <div class="form-group row">
                                <div class="col-2 col-xs-2 col-sm-2 col-md-3"></div>
                                <div class="col-8 col-xs-8 col-sm-8 col-md-6">
                                    <input id="email" type="email" placeholder="Email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email ?? old('email') }}" required autofocus>
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-2 col-xs-2 col-sm-2 col-md-3"></div>
                            </div>

                            <div class="form-group row">
                                <div class="col-2 col-xs-2 col-sm-2 col-md-3"></div>
                                <div class="col-8 col-xs-8 col-sm-8 col-md-6">
                                    <input id="password" type="password" placeholder="Contraseña" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }} bg-white text-dark" name="password" required>
                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-2 col-xs-2 col-sm-2 col-md-3"></div>
                            </div>

                            <div class="form-group row">
                                <div class="col-2 col-xs-2 col-sm-2 col-md-3"></div>
                                <div class="col-8 col-xs-8 col-sm-8 col-md-6">
                                    <input id="password-confirm" type="password" placeholder="Confirmar Contraseña" class="form-control" name="password_confirmation" required>
                                </div>
                                <div class="col-2 col-xs-2 col-sm-2 col-md-3"></div>
                            </div>

                            <div class="form-group row justify-content-center mt-4">
                                <div class="col-2 col-xs-2 col-sm-2 col-md-3"></div>
                                <div class="col-8 col-xs-8 col-sm-8 col-md-6 centerBtn">
                                    <button type="submit" class="btn button" id="submitButton">
                                        Cambiar Contraseña
                                    </button>
                                </div>
                                <div class="col-2 col-xs-2 col-sm-2 col-md-3"></div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection


@section('extraScripts')
    <link rel="stylesheet" type="text/css" href="{{asset('css/login-styles.css')}}">
@endsection
