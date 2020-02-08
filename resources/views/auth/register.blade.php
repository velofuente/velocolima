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
<div class="container registerContainer">
    <div class="register row justify-content-center">
        <div class="col-md-8">
            <div>
                <div class="mx-auto" id="registerTitle">Registrar una nueva cuenta</div>
                <div class="mx-auto" id="welcomeMessage">Bienvenido a <img src="{{asset('img/iconos/CroppedLogo.png')}}" id="welcomeLogo"></div>
                <div class="mx-auto" id="firstClassFree"> ¡Tu primer clase será gratis al registrarte!</div>

                <div class="card-body pt-0">
                    <form method="POST" action="{{ route('register') }}" class="registration">
                        @csrf

                        <div class="form-group row mb-3">
                            <div class="col-2 col-xs-2 col-sm-2 col-md-3"></div>
                            <div class="col-8 col-xs-8 col-sm-8 col-md-6 mx-auto">
                                <label for="name" class="mr-sm-2">Nombre:</label>
                                <input id="name" type="text" placeholder="Nombre(s)" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>
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
                                    <label for="last_name" class="mr-sm-2">Apellido(s):</label>
                                <input id="last_name" placeholder="Apellido(s)" type="text" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{ old('last_name') }}" required>
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
                                <label for="email" class="mr-sm-2">E-Mail:</label>
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
                                <label for="password" class="mr-sm-2">Contraseña:</label>
                                <input id="password" placeholder="Contraseña" minlength="7" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                                <ul class="input-requirements">
                                    <li id="passwordError1">Mínimo 7 caracteres (máximo 100 caracteres)</li>
                                    {{-- <li id="passwordError2">Debe contener al menos un número</li>
                                    <li id="passwordError3">Debe contener al menos una letra minúscula</li>
                                    <li id="passwordError4">Debe contener al menos una letra mayúscula</li> --}}
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
                                <label for="password-confirm" class="mr-sm-2">Confirmar contraseña:</label>
                                <input id="password-confirm" placeholder="Confirmar Contraseña" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                            <div class="col-2 col-xs-2 col-sm-2 col-md-3"></div>
                        </div>

                        <div class="form-group row mb-3">
                            <div class="col-2 col-xs-2 col-sm-2 col-md-3"></div>
                            <div class="col-8 col-xs-8 col-sm-8 col-md-6 mx-auto">
                                <label for="birth_date" class="mr-sm-2">Fecha de nacimiento:</label>
                                <div class="input-group">
                                    {{-- <input id="birth_date" min="1900-01-01" max="2100-12-31" type="date" fecha="active" class="form-control{{ $errors->has('birth_date') ? ' is-invalid' : '' }}" name="birth_date" value="{{ old('birth_date') }}" required > --}}
                                    <input id="birth_date" min="1900-01-01" max="2100-12-31" style="z-index: 0" type="text" fecha="active" class="form-control{{ $errors->has('birth_date') ? ' is-invalid' : '' }}" name="birth_date" value="{{ old('birth_date') }}" required >
                                    @if ($errors->has('birth_date'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('birth_date') }}</strong>
                                    </span>
                                    @endif
                                    <div class="input-group-append" id="birth-date-append">
                                        <span class="input-group-text text-secondary bg-white">Nacimiento</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-2 col-xs-2 col-sm-2 col-md-3"></div>
                        </div>

                        {{-- Input Phone --}}
                        {{-- <input type="hidden" placeholder="Teléfono"  name="phone" value="3121234567" maxlength="15" required > --}}
                        {{-- Input Weight --}}
                        {{-- <input type="hidden" id="weight" name="weight" value="86.5" required > --}}
                        {{-- Input Height --}}
                        <input type="hidden" id="height" name="height" value="186" required >
                        <div class="form-group row mb-3">
                            <div class="col-2 col-xs-2 col-sm-2 col-md-3"></div>
                            <div class="col-8 col-xs-8 col-sm-8 col-md-6 mx-auto">
                                <label for="gender" class="mr-sm-2">Sexo:</label>
                                <select class="form-control" id="gender" name="gender" placeholder="Sexo" value="{{ old('gender') }}" required>
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
                                <label for="phone" class="mr-sm-2">Teléfono:</label>
                                <input id="phone" placeholder="Teléfono" type="number" min="0" minlength="10" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" value="{{ old('phone') }}" required>
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
                                    <label for="shoe_size" class="mr-sm-2">Talla de calzado:</label>
                                <div class="input-group">
                                    <select class="form-control" id="shoe_size" name="shoe_size" placeholder="Talla de Calzado" value="{{ old('shoe_size') }}" required>
                                        <option disabled selected hidden>Talla de calzado</option>
                                        <option>23</option>
                                        <option>23.5</option>
                                        <option>24</option>
                                        <option>24.5</option>
                                        <option>25</option>
                                        <option>25.5</option>
                                        <option>26</option>
                                        <option>26.5</option>
                                        <option>27</option>
                                        <option>27.5</option>
                                        <option>28</option>
                                        <option>28.5</option>
                                        <option>29</option>
                                    </select>
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
                                <label for="conditions" class="conditions" style="font-size: 15px;">He leído y acepto los <a href="/legales" target="_blank">Términos y condiciones</label>
                            </div>
                            <div class="col-2 col-xs-2 col-sm-2 col-md-3"></div>
                        </div>

                        <div class="form-group row">
                            <div class="col-2 col-xs-2 col-sm-2 col-md-3"></div>
                            <div class="col-8 col-xs-8 col-sm-8 col-md-6 text-center">
                                <button type="submit" class="btn submitButton" id="submitButton">
                                    {{ __('Regístrate') }}
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
    {{-- <script>
        $('#birth_date').datepicker({
            changeMonth: true,
            changeYear: true,
            yearRange: '1920:2013',
            dateFormat: 'yy-mm-dd',
            // showButtonPanel: true,
        });
    </script> --}}
    <script>
        $(document).ready(function() {
            const genderOldValue = '{{ old('gender') }}';
            const shoeOldValue = '{{ old('shoe_size') }}';

            //"Select gender" element can't be empty
            if(genderOldValue !== '') {
            $('#gender').val(genderOldValue);
            }

            $('input[fecha=active]').attr('placeholder', 'aaaa/mm/dd')
            $('input[fecha=active]').on('click', function(event) {
                $('input[fecha=active]').datepicker({
                    dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa", "Do"],
                    dayNamesShort: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab", "Dom"],
                    dayNames: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo"],
                    monthNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                    monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
                    currentText: "Hoy",
                    dateFormat: 'yy/mm/dd',
                    changeMonth: true,
                    changeYear: true,
                    yearRange: '-110:+0',
                    onSelect: function(dateText, inst) {
                        $(inst).val(dateText); // Write the value in the input
                    }
                }).focus();
                //  // Use datepicker on the date inputs
                //  $("input[type=date]").datepicker({
                //     dateFormat: 'yy/mm/dd',
                //     changeMonth: true,
                //     changeYear: true,
                //     yearRange: '1920:2019',
                //         onSelect: function(dateText, inst) {
                //             $(inst).val(dateText); // Write the value in the input
                //         }
                // });
            });

            //datePicker on Safari
            // if ( $('[type="date"]').prop('type') != 'date' || $('[type="date"]').prop('type') == 'date' ) {
            if ( $('[type="date"]').prop('type') != 'date' ) {
                // Use datepicker on the date inputs
                $("input[type=date]").datepicker({
                    dateFormat: 'yy/mm/dd',
                    dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa", "Do"],
                    dayNamesShort: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab", "Dom"],
                    dayNames: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo"],
                    monthNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                    monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
                    currentText: "Hoy",
                    changeMonth: true,
                    changeYear: true,
                    yearRange: '-110:+0',
                        onSelect: function(dateText, inst) {
                            $(inst).val(dateText); // Write the value in the input
                        }
                });
                // Code below to avoid the classic date-picker
                // $("input[type=date]").on('click', function() {
                // return false;
                // });
            }

            //Hide "Nacimiento" append on birth_date input
            $( "#birth_date" ).focus(function() {
                $('#birth-date-append').hide();
            });
        });
    </script>
@endsection
