@extends('layout')

@section('extraStyles')
    <link rel="stylesheet" type="text/css" href="{{asset('css/register-styles.css')}}">
    <style>
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button,
        input[type=date]::-webkit-inner-spin-button,
        input[type=date]::-webkit-outer-spin-button{
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
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
                <div class="mx-auto" id="firstClassFree"> ¡Tu primer clase será gratis al registrarte!</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}" class="registration">
                        @csrf

                        <div class="form-group row mb-3">
                            <div class="col-2 col-xs-2 col-sm-2 col-md-3"></div>
                            <div class="col-8 col-xs-8 col-sm-8 col-md-6 mx-auto">
                                <input id="name" type="text" placeholder="Nombre(s)" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus >
                                {{-- <ul class="input-requirements">
                                    <li id="nameError1">Mínimo 3 caracteres</li>
                                    <li id="nameError2">Solamente números y letras (no caracteres especiales)</li>
                                </ul> --}}
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-2 col-xs-2 col-sm-2 col-md-3"></div>
                        </div>

                        <div class="form-group row mb-3">
                            <div class="col-2 col-xs-2 col-sm-2 col-md-3"></div>
                            <div class="col-8 col-xs-8 col-sm-8 col-md-6 mx-auto">
                                <input id="last_name" placeholder="Apellido(s)" type="text" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{ old('last_name') }}" required autofocus>
                                {{-- <ul class="input-requirements">
                                    <li id="lastNameError1">Mínimo 3 caracteres</li>
                                    <li id="lastNameError2">Solamente números y letras (no caracteres especiales)</li>
                                </ul> --}}
                                @if ($errors->has('last_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-2 col-xs-2 col-sm-2 col-md-3"></div>
                        </div>

                        <div class="form-group row mb-3">
                            <div class="col-2 col-xs-2 col-sm-2 col-md-3"></div>
                            <div class="col-8 col-xs-8 col-sm-8 col-md-6 mx-auto">
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

                        <div class="form-group row mb-3">
                            <div class="col-2 col-xs-2 col-sm-2 col-md-3"></div>
                            <div class="col-8 col-xs-8 col-sm-8 col-md-6 mx-auto">
                                <input id="password-confirm" placeholder="Confirmar Contraseña" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                            <div class="col-2 col-xs-2 col-sm-2 col-md-3"></div>
                        </div>

                        <div class="form-group row mb-3">
                            <div class="col-2 col-xs-2 col-sm-2 col-md-3"></div>
                            <div class="col-8 col-xs-8 col-sm-8 col-md-6 mx-auto">
                                <div class="input-group">
                                    <input id="birth_date" min="1900-01-01" max="2100-12-31" type="date" class="form-control{{ $errors->has('birth_date') ? ' is-invalid' : '' }}" name="birth_date" value="{{ old('birth_date') }}" required autofocus>
                                    @if ($errors->has('birth_date'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('birth_date') }}</strong>
                                    </span>
                                    @endif
                                    <div class="input-group-append">
                                        <span class="input-group-text text-secondary bg-white">Nacimiento</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-2 col-xs-2 col-sm-2 col-md-3"></div>
                        </div>

                        {{-- Input Phone --}}
                        {{-- <input type="hidden" placeholder="Teléfono"  name="phone" value="3121234567" maxlength="15" required autofocus> --}}
                        {{-- Input Weight --}}
                        {{-- <input type="hidden" id="weight" name="weight" value="86.5" required autofocus> --}}
                        {{-- Input Height --}}
                        <input type="hidden" id="height" name="height" value="186" required autofocus>
                        <div class="form-group row mb-3">
                            <div class="col-2 col-xs-2 col-sm-2 col-md-3"></div>
                            <div class="col-8 col-xs-8 col-sm-8 col-md-6 mx-auto">
                                <select class="form-control" id="gender" name="gender" placeholder="Sexo" value="Sexo" required autofocus>
                                    <option disabled selected hidden>Sexo</option>
                                    <option>Hombre</option>
                                    <option>Mujer</option>
                                </select>
                                @if ($errors->has('gender'))
                                    <span class="invalid-feedback" style="display: block !important" role="alert">
                                        <strong>{{ $errors->first('gender') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-2 col-xs-2 col-sm-2 col-md-3"></div>
                        </div>

                        <div class="form-group row mb-3">
                            <div class="col-2 col-xs-2 col-sm-2 col-md-3"></div>
                            <div class="col-8 col-xs-8 col-sm-8 col-md-6 mx-auto">
                                <input id="phone" placeholder="Teléfono" type="number" min="0" minlength="10" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" value="{{ old('phone') }}" required autofocus>
                                @if ($errors->has('phone'))
                                    <span class="invalid-feedback" style="display: block !important" role="alert">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-2 col-xs-2 col-sm-2 col-md-3"></div>
                        </div>

                        <div class="form-group row mb-3">
                            <div class="col-2 col-xs-2 col-sm-2 col-md-3"></div>
                            <div class="col-8 col-xs-8 col-sm-8 col-md-6 mx-auto">
                                <div class="input-group">
                                    <input id="shoe_size" placeholder="Talla de Calzado" type="text" class="form-control{{ $errors->has('shoe_size') ? ' is-invalid' : '' }}" name="shoe_size" value="{{ old('shoe_size') }}" required autofocus>
                                    <div class="input-group-append">
                                        <span class="input-group-text text-secondary bg-white">cm</span>
                                    </div>
                                </div>
                                @if ($errors->has('shoe_size'))
                                    <span class="invalid-feedback" style="display: block !important" role="alert">
                                        <strong>{{ $errors->first('shoe_size') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-2 col-xs-2 col-sm-2 col-md-3"></div>
                        </div>

                        <div class="form-group row">
                            <div class="col-2 col-xs-2 col-sm-2 col-md-3"></div>
                            <div class="col-8 col-xs-8 col-sm-8 col-md-6 text-center">
                                {{-- <input type="checkbox" id="termsCondition" class="form-control{{ $errors->has('termsCondition') ? ' is-invalid' : '' }}" name="termsCondition" value="{{ old('termsCondition') }}" required> He leído y acepto los <a href="{{url("/who-are-we")}}">Términos y Condiciones de Uso</a> --}}

                                <input type="checkbox" name="conditions" id="conditions" required oninvalid="this.setCustomValidity('Debes marcar esta casilla para continuar')" oninput="this.setCustomValidity('')"  />
                                <label for="conditions" class="conditions" style="font-size: 15px;">He leído y acepto los <a href="#">Términos y Condiciones</label>
                            </div>
                            <div class="col-2 col-xs-2 col-sm-2 col-md-3"></div>
                        </div>

                        <div class="form-group row">
                            <div class="col-2 col-xs-2 col-sm-2 col-md-3"></div>
                            <div class="col-8 col-xs-8 col-sm-8 col-md-6 text-center">
                                <button type="submit" class="btn button" id="submitButton">
                                    {{ __('¡Se Véloz!') }}
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
    <script src="{{ asset('/js/register-script.js') }}"></script>
    <script>
        // Select the Phone Input.
        var phone = document.getElementById('phone');

        // Lock the input only to numbers.
        phone.onkeydown = function(e) {
            if(!((e.keyCode > 95 && e.keyCode < 106)
            || (e.keyCode > 47 && e.keyCode < 58)
            || e.keyCode == 8 || e.keyCode == 9)) {
                return false;
            }
        }
    </script>
@endsection