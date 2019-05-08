@extends('layout')

@section('extraStyles')
    <link rel="stylesheet" type="text/css" href="{{asset('css/register-styles.css')}}">
@endsection

@section('title')
    Velo | Regístrate
@endsection

@section('content')
<div class="container">
    <div class="register row justify-content-center">
        <div class="col-md-8">
            <div>
                <div class="mx-auto" id="registerTitle">Registrar una nueva cuenta</div>
                <div class="mx-auto" id="welcomeMessage">Bienvenido a <img src="{{asset('img/iconos/CroppedLogo.png')}}" id="welcomeLogo"></div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}" class="registration">
                        @csrf

                        <div class="form-group row">
                            <div class="col-2 col-xs-2 col-sm-1 col-md-3"></div>
                            <div class="col-8 col-xs-8 col-sm-10 col-md-6 mx-auto">
                                <input id="name" type="text" placeholder="Nombre(s)" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus >
                                <ul class="input-requirements">
                                    <li id="nameError1">Mínimo 3 caracteres</li>
                                    <li id="nameError2">Solamente números y letras (no caracteres especiales)</li>
                                </ul>
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-2 col-xs-2 col-sm-1 col-md-3"></div>
                        </div>

                        <div class="form-group row">
                            <div class="col-2 col-xs-2 col-sm-2 col-md-3"></div>
                            <div class="col-8 col-xs-8 col-sm-8 col-md-6 mx-auto">
                                <input id="last_name" placeholder="Apellido(s)" type="text" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{ old('last_name') }}" required autofocus>
                                <ul class="input-requirements">
                                    <li id="lastNameError1">Mínimo 3 caracteres</li>
                                    <li id="lastNameError2">Solamente números y letras (no caracteres especiales)</li>
                                </ul>
                                @if ($errors->has('last_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-2 col-xs-2 col-sm-2 col-md-3"></div>
                        </div>

                        <div class="form-group row">
                            <div class="col-2 col-xs-2 col-sm-2 col-md-3"></div>
                            <div class="col-8 col-xs-8 col-sm-8 col-md-6 mx-auto pb-3">
                                <input id="email" placeholder="E-Mail" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
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
                            <div class="col-8 col-xs-8 col-sm-8 col-md-6 mx-auto">
                                <input id="password" placeholder="Contraseña" minlength="7" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                                <ul class="input-requirements">
                                    <li id="passwordError1">Mínimo 7 caracteres (máximo 100 caracteres)</li>
                                    <li id="passwordError2">Debe contener al menos un número</li>
                                    <li id="passwordError3">Debe contener al menos una letra minúscula</li>
                                    <li id="passwordError4">Debe contener al menos una letra mayúscula</li>
                                </ul>
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
                            <div class="col-8 col-xs-8 col-sm-8 col-md-6 mx-auto pb-3">
                                <input id="password-confirm" placeholder="Confirmar Contraseña" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                            <div class="col-2 col-xs-2 col-sm-2 col-md-3"></div>
                        </div>

                        <div class="form-group row">
                            <div class="col-2 col-xs-2 col-sm-2 col-md-3"></div>
                            <div class="col-8 col-xs-8 col-sm-8 col-md-6 mx-auto pb-3">
                                <input id="birth_date" min="1900-01-01" max="2100-12-31" type="date" placeholder="Nacimiento" class="form-control{{ $errors->has('birth_date') ? ' is-invalid' : '' }}" name="birth_date" value="{{ old('birth_date') }}" required autofocus>
                                @if ($errors->has('birth_date'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('birth_date') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-2 col-xs-2 col-sm-2 col-md-3"></div>
                        </div>

                        {{-- Input Phone --}}
                        <input type="hidden" placeholder="Teléfono"  name="phone" value="3121234567" maxlength="15" required autofocus>
                        {{-- <div class="col-md-6 mx-auto">
                            <input id="phone" placeholder="Teléfono" type="text" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" value="{{ old('phone') }}" maxlength="15" required autofocus>
                            <ul class="input-requirements">
                                <li>LADA (3 dígitos) + Número (10 dígitos)</li>
                                <li>No debe contener espacios ni caracteres especiales</li>
                            </ul>
                            @if ($errors->has('phone'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('phone') }}</strong>
                                </span>
                            @endif
                        </div> --}}

                        {{-- Input Weight --}}
                        <input type="hidden" id="weight" name="weight" value="86.5" required autofocus>
                        {{-- <div class="col-md-6 pb-3 mx-auto">
                            <div class="input-group">
                                <input id="weight" placeholder="Peso" type="text" class="form-control{{ $errors->has('weight') ? ' is-invalid' : '' }}" name="weight" value="{{ old('weight') }}" required autofocus>
                                <div class="input-group-append">
                                    <span class="input-group-text" style="background:#f4f4f4; color: #000">kg</span>
                                </div>
                            </div>
                            @if ($errors->has('weight'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('weight') }}</strong>
                            </span>
                            @endif
                        </div> --}}

                        {{-- Input Height --}}
                        <input type="hidden" id="height" name="height" value="186" required autofocus>
                        {{-- <div class="col-md-6 pb-3 mx-auto">
                            <div class="input-group">
                                <input id="height" placeholder="Estatura" type="text" class="form-control{{ $errors->has('height') ? ' is-invalid' : '' }}" name="height" value="{{ old('height') }}" required autofocus>
                                <div class="input-group-append">
                                    <span class="input-group-text" style="background:#f4f4f4; color: #000">cm</span>
                                </div>
                            </div>
                            @if ($errors->has('height'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('height') }}</strong>
                                </span>
                            @endif
                        </div> --}}

                        {{-- Gender radio button selector --}}
                        {{-- <div class="form-group row">
                            <div class="col-md-4">
                                <input id="gender" type="radio" class="form-control{{ $errors->has('gender') ? ' is-invalid' : '' }}" name="gender" value="Hombre" required autofocus> Hombre<br>
                                @if ($errors->has('gender'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('gender') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-4">
                                <input id="gender" type="radio" class="form-control{{ $errors->has('gender') ? ' is-invalid' : '' }}" name="gender" value="Mujer" required autofocus> Mujer<br>
                                @if ($errors->has('gender'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('gender') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div> --}}

                        <div class="form-group row">
                            <div class="col-2 col-xs-2 col-sm-2 col-md-3"></div>
                            <div class="col-8 col-xs-8 col-sm-8 col-md-6 mx-auto pb-3">
                                <select class="form-control" id="gender" name="gender" placeholder="Sexo" value="Sexo" required autofocus>
                                    <option disabled selected hidden>Sexo</option>
                                    <option>Hombre</option>
                                    <option>Mujer</option>
                                </select>
                                @if ($errors->has('gender'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('gender') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-2 col-xs-2 col-sm-2 col-md-3"></div>
                        </div>

                        <div class="form-group row">
                            <div class="col-2 col-xs-2 col-sm-2 col-md-3"></div>
                            <div class="col-8 col-xs-8 col-sm-8 col-md-6 mx-auto pb-3">
                                <div class="input-group">
                                    <input id="shoe_size" placeholder="Tamaño de Calzado" type="text" class="form-control{{ $errors->has('shoe_size') ? ' is-invalid' : '' }}" name="shoe_size" value="{{ old('shoe_size') }}" required autofocus>
                                </div>
                                @if ($errors->has('shoe_size'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('shoe_size') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-2 col-xs-2 col-sm-2 col-md-3"></div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4 mx-auto">
                                <button type="submit" class="btn button mx-auto" id="submitButton">
                                    {{ __('¡Se Véloz!') }}
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

{{-- @section('extraScripts')
    <script src="{{ asset('/js/register-script.js') }}"></script>
@endsection --}}