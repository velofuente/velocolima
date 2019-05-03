@extends('layout')

@section('title')
    Velo | Iniciar Sesión
@endsection

@section('extraStyles')
    <link rel="stylesheet" type="text/css" href="{{asset('css/login-styles.css')}}">
@endsection

@section('content')
<body>
    <div class="container" id="mainDiv">
        <div class="login row justify-content-center">
            <div class="col-md-8">
                <div>
                    <div class="mx-auto" id="loginTitle">Entrar o Registrar</div>
                    <div class="mx-auto" id="welcomeMessage">Bienvenido a <img src="{{asset('img/iconos/CroppedLogo.png')}}" id="welcomeLogo"></div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="form-group row">
                                {{-- <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Correo Electrónico') }}</label> --}}
                                <div class="col-md-6 mx-auto">
                                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Email" autofocus>

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                {{-- <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Contraseña') }}</label> --}}
                                <div class="col-md-6 mx-auto">
                                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Contraseña">

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4 mx-auto">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Recordar Sesión') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-0 mx-auto">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn" id="submitButton">
                                        {{ __('¡Se Véloz!') }}
                                    </button>

                                    {{-- @if (Route::has('password.request'))
                                    <br>
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Olvidaste tu Contraseña?') }}
                                        </a>
                                    @endif --}}
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
@endsection
