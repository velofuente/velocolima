@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="nombre" class="col-md-4 col-form-label text-md-right">{{ __('Nombre') }}</label>

                            <div class="col-md-6">
                                <input id="nombre" type="text" class="form-control{{ $errors->has('nombre') ? ' is-invalid' : '' }}" name="nombre" value="{{ old('nombre') }}" required autofocus>

                                @if ($errors->has('nombre'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('nombre') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="apellido_p" class="col-md-4 col-form-label text-md-right">{{ __('Apellido Paterno') }}</label>

                            <div class="col-md-6">
                                <input id="apellido_p" type="text" class="form-control{{ $errors->has('apellido_p') ? ' is-invalid' : '' }}" name="apellido_p" value="{{ old('apellido_p') }}" required autofocus>

                                @if ($errors->has('apellido_p'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('apellido_p') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="apellido_m" class="col-md-4 col-form-label text-md-right">{{ __('Apellido Materno') }}</label>

                            <div class="col-md-6">
                                <input id="apellido_m" type="text" class="form-control{{ $errors->has('apellido_m') ? ' is-invalid' : '' }}" name="apellido_m" value="{{ old('apellido_m') }}" required autofocus>

                                @if ($errors->has('apellido_m'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('apellido_m') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Email') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="contrasena" class="col-md-4 col-form-label text-md-right">{{ __('Contraseña') }}</label>

                            <div class="col-md-6">
                                <input id="contrasena" type="password" class="form-control{{ $errors->has('contrasena') ? ' is-invalid' : '' }}" name="contrasena" required>

                                @if ($errors->has('contrasena'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('contrasena') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="confirma-contrasena" class="col-md-4 col-form-label text-md-right">{{ __('Confirmar Contraseña') }}</label>

                            <div class="col-md-6">
                                <input id="confirma-contrasena" type="password" class="form-control" name="confirma-contrasena" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fecha_nac" class="col-md-4 col-form-label text-md-right">{{ __('Fecha de Nacimiento') }}</label>

                            <div class="col-md-6">
                                <input id="fecha_nac" type="date" class="form-control{{ $errors->has('fecha_nac') ? ' is-invalid' : '' }}" name="fecha_nac" value="{{ old('fecha_nac') }}" required autofocus>

                                @if ($errors->has('apellido_m'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('fecha_nac') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="telefono" class="col-md-4 col-form-label text-md-right">{{ __('Telefono') }}</label>

                            <div class="col-md-6">
                                <input id="telefono" type="text" class="form-control{{ $errors->has('telefono') ? ' is-invalid' : '' }}" name="telefono" value="{{ old('telefono') }}" required autofocus>

                                @if ($errors->has('telefono'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('telefono') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="peso" class="col-md-4 col-form-label text-md-right">{{ __('Peso') }}</label>

                            <div class="col-md-6">
                                <input id="peso" type="text" class="form-control{{ $errors->has('peso') ? ' is-invalid' : '' }}" name="peso" value="{{ old('peso') }}" required autofocus>

                                @if ($errors->has('peso'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('peso') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="estatura" class="col-md-4 col-form-label text-md-right">{{ __('Estatura') }}</label>

                            <div class="col-md-6">
                                <input id="estatura" type="text" class="form-control{{ $errors->has('estatura') ? ' is-invalid' : '' }}" name="estatura" value="{{ old('estatura') }}" required autofocus>

                                @if ($errors->has('estatura'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('estatura') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="n_clases" class="col-md-4 col-form-label text-md-right">{{ __('Numero de Clases') }}</label>

                            <div class="col-md-6">
                                <input id="n_clases" type="text" class="form-control{{ $errors->has('n_clases') ? ' is-invalid' : '' }}" name="n_clases" value="{{ old('n_clases') }}" required autofocus>

                                @if ($errors->has('n_clases'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('n_clases') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="genero" class="col-md-4 col-form-label text-md-right">{{ __('Genero') }}</label>

                            <div class="col-md-4">
                                <input id="genero" type="radio" class="form-control{{ $errors->has('genero') ? ' is-invalid' : '' }}" name="Hombre" value="{{ old('genero') }}" required autofocus>
                                <label for="Hombre">Hombre</label>
                                @if ($errors->has('genero'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('genero') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-4">
                                <input id="genero" type="radio" class="form-control{{ $errors->has('genero') ? ' is-invalid' : '' }}" name="Mujer" value="{{ old('genero') }}" required autofocus>
                                <label for="Mujer">Mujer</label>
                                @if ($errors->has('genero'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('genero') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="expiracion" class="col-md-4 col-form-label text-md-right">{{ __('Expiracion') }}</label>

                            <div class="col-md-6">
                                <input id="expiracion" type="date" class="form-control{{ $errors->has('expiracion') ? ' is-invalid' : '' }}" name="expiracion" value="{{ old('expiracion') }}" required autofocus>

                                @if ($errors->has('expiracion'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('expiracion') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Registrarme') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
