@extends('layout')

@section('extraStyles')
    <link rel="stylesheet" type="text/css" href="{{asset('css/register-styles.css')}}">
@endsection

@section('content')
<div class="container">
    <div class="register row justify-content-center">
        <div class="col-md-8">
            <div>
                <h3 class="mx-auto">Registro</h3>
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}" class="registration">
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nombre') }}</label>
                            <div class="col-md-6">
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
                        </div>
                        <div class="form-group row">
                            <label for="last_name" class="col-md-4 col-form-label text-md-right">{{ __('Apellido') }}</label>
                            <div class="col-md-6">
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
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Email') }}</label>
                            <div class="col-md-6 pb-3">
                                <input id="email" placeholder="Ejemplo@Prueba.com" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Contraseña') }}</label>
                            <div class="col-md-6">
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
                        </div>

                        <div class="form-group row pb-3">
                            <label for="password_confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirmar Contraseña') }}</label>
                            <div class="col-md-6">
                                <input id="password-confirm" placeholder="Confirmar Contraseña" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>
                        <div class="form-group row pb-3">
                            <label for="birth_date" class="col-md-4 col-form-label text-md-right">{{ __('Fecha de Nacimiento') }}</label>
                            <div class="col-md-6">
                                <input id="birth_date" min="1900-01-01" max="2100-12-31" type="date" class="form-control{{ $errors->has('birth_date') ? ' is-invalid' : '' }}" name="birth_date" value="{{ old('birth_date') }}" required autofocus>
                                @if ($errors->has('birth_date'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('birth_date') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Teléfono') }}</label>
                            <div class="col-md-6">
                                <input id="phone" placeholder="Teléfono" type="text" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" value="{{ old('phone') }}" required autofocus>
                                <ul class="input-requirements">
                                    <li>LADA (3 dígitos) + Número (10 dígitos)</li>
                                </ul>
                                @if ($errors->has('phone'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="weight" class="col-md-4 col-form-label text-md-right">{{ __('Peso') }}</label>
                            <div class="col-md-6 pb-3">
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
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="height" class="col-md-4 col-form-label text-md-right">{{ __('Estatura') }}</label>
                            <div class="col-md-6 pb-3">
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
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="gender" class="col-md-4 col-form-label text-md-right">{{ __('Genero') }}</label>
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
<script>
    function CustomValidation(){
        this.invalidities = [];
	    this.validityChecks = [];
    }

    CustomValidation.prototype = {
        addInvalidity: function(message){
            this.invalidities.push(message);
        },

        getInvalidities: function () {
            return this.invalidities.join('. \n');
        },

        checkValidity: function(input){
            for (var i = 0; i < this.validityChecks.length; i++){
                var isInvalid = this.validityChecks[i].isInvalid(input);
                if (isInvalid){
                    this.addInvalidity(this.validityChecks[i].invalidityMessage);
                    this.validityChecks[i].element.classList.add('invalid');
                    this.validityChecks[i].element.classList.remove('valid');
                } else{
                    this.validityChecks[i].element.classList.remove('invalid');
                    this.validityChecks[i].element.classList.add('valid');
                }
            }
        }
    };

    var nameValidityChecks = [
        {
            isInvalid: function(input){
                return input.value.length < 3;
            },
            invalidityMessage: 'Este campo debe tener al menos 3 caracteres',
            element: document.querySelector('#nameError1')
        },
        {
            isInvalid: function(input){
                var illegalCharacters = input.value.match((/[^a-zA-Z0-9]/g));
                return illegalCharacters ? true : false;
            },
            invalidityMessage: 'Solamente se permiten letras y números',
            element: document.querySelector('#nameError2')
        }
    ]

    var lastNameValidityChecks = [
        {
            isInvalid: function(input){
                return input.value.length < 3;
            },
            invalidityMessage: 'Este campo debe tener al menos 3 caracteres',
            element: document.querySelector('#lastNameError1')
        },
        {
            isInvalid: function(input){
                var illegalCharacters = input.value.match((/[^a-zA-Z0-9]/g));
                return illegalCharacters ? true : false;
            },
            invalidityMessage: 'Solamente se permiten letras y números',
            element: document.querySelector('#lastNameError2')
        }
    ]
    var passwordValidityChecks = [
        {
            isInvalid: function(input){
                return input.value.length < 7 | input.value.length > 100;
            },
            invalidityMessage: 'Este campo debe tener al menos 7 caracteres',
            element: document.querySelector('#passwordError1')
        },
        {
            isInvalid: function(input){
                return !input.value.match((/[0-9]/g))
            },
            invalidityMessage: 'Este campo debe tener al menos un número',
            element: document.querySelector('#passwordError2')
        },
        {
            isInvalid: function(input){
                return !input.value.match((/[a-z]/g))
            },
            invalidityMessage: 'Este campo debe tener al menos una letra minúscula',
            element: document.querySelector('#passwordError3')
        },
        {
            isInvalid: function(input){
                return !input.value.match((/[A-Z]/g))
            },
            invalidityMessage: 'Este campo debe tener al menos una letra mayúscula',
            element: document.querySelector('#passwordError4')
        }
    ]

    var nameInput = document.getElementById('name');
    var lastNameInput = document.getElementById('last_name');
    var passwordInput = document.getElementById('password');

    nameInput.CustomValidation = new CustomValidation();
    nameInput.CustomValidation.validityChecks = nameValidityChecks;

    lastNameInput.CustomValidation = new CustomValidation();
    lastNameInput.CustomValidation.validityChecks = lastNameValidityChecks;

    passwordInput.CustomValidation = new CustomValidation();
    passwordInput.CustomValidation.validityChecks = passwordValidityChecks;

    var inputs = document.querySelectorAll('input:not([type="submit"])');
    for (var i = 0; i < inputs.length; i++){
        inputs[i].addEventListener('keyup', function(){
            this .CustomValidation.checkValidity(this);
        })
    }
</script>
@endsection