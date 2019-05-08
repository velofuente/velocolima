@extends('layout')
@section('title')
    Usuario
@endsection
@section('extraStyles')
    <link rel="stylesheet" href="{{asset('css/user-styles.css')}}">
@endsection
@section('content')
    <div class="container-fluid main_div">
        {{-- <div class="flex-center position-ref full-height"> --}}
            <div class="row">
                {{-- User Name & Share Code --}}
                <div class="col-xs-6 col-sm-6 col-md-5 mb-4">
                    <div class="text-center">
                        <span class="text-center hola_gradient"> Hola </span>
                        <span class="text-center user_name"> {{ Auth::user()->name }} {{ Auth::user()->last_name }}</span>
                    </div>
                </div>
                <div class="col-xs-0 col-sm-0 col-md-1 mb-4">
                    <div>
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6 mb-4">
                    <div class="text-center text_share_code">
                        <span>Tu código es:  </span>
                        <span class="text-center share_code"> {{ Auth::user()->share_code }} </span>
                    </div>
                </div>

                {{-- Available Classes & Classes Buttons --}}
                <div class="col-md-5">
                    <div class="text-center" id="clases">
                        <span class="text-center text_my_classes">Mis Clases</span>
                        <div class="classesButton">
                            <p class="available_classes">0{{Auth::user()->classes}}</p>
                            <small class=" ">Clases disponibles en tu cuenta</small>
                        </div>
                        <a href="{{ url('/#packages') }}" class="btn mx-auto" id="buyPackages" role="button">Comprar Clases</a>
                    </div>
                </div>
                {{-- Límite de Grid --}}
                <div class="col-md-1">
                    <div id="clases" class="text-center">
                        <h4 class="text-center">Límite de Grid</h4>
                    </div>
                </div>
                <div class="col-md-6">
                    <div id="clases" class="text-left">
                        <h4 class="text-left">Límite de Grid</h4>
                    </div>
                </div>

                {{-- User Name & Available Classes: col-md-5
                <div class="col-md-5">
                    <div class="text-center">
                        <span class="text-center hola_gradient"> Hola </span>
                        <span class="text-center user_name"> {{ Auth::user()->name }} {{ Auth::user()->last_name }}</span>
                    </div>
                    <br>
                    <div id="clases" class="text-center">
                        <h4 class="text-center font-weight-bold myclss">Mis Clases</h4>
                        <div class="classesButton">
                            <h1 class="myclss">0{{Auth::user()->classes}}</h1>
                                <span class="font-weight-bold myclss">Clases</span><br>
                                <small class="text-secondary font-weight-bold">* Clases disponibles en tu cuenta</small>
                        </div>
                        <a href="{{ url('/#packages') }}" class="btn text-white mb-4" style="background-color: #26C6CF" role="button">COMPRAR CLASES</a>
                    </div>
                </div> --}}

                {{-- User Data & Change Password: col-md-7
                <div class="col-md-7">
                    <div id="userGeneralData">
                        <button type="button" class="btn btn-secondary text-white mb-2 mt-2 w-50 d-block mx-auto" data-toggle="collapse" data-target="#userData">Datos del usuario</button>
                        <div id="userData" class="collapse">
                            <form method="post" action="{{ route('user.update', Auth::user()->id) }}">
                                @method('PATCH')
                                @csrf
                                <div class="d-block">
                                    <input type="text" class="form-control pl-3 input_custom mb-1 w-75 d-block mx-auto" name="name" value="{{ Auth::user()->name }}">
                                    <input type="text" class="form-control pl-3 input_custom mb-1 w-75 d-block mx-auto" name="last_name" value="{{ Auth::user()->last_name }}">
                                    <input type="text" class="form-control pl-3 input_custom mb-1 w-75 d-block mx-auto" name="phone" value="{{ Auth::user()->phone }}">
                                </div>
                                <button type="submit" class="btn text-white d-block mx-auto mb-3" style="background-color: #26C6CF" role="button">Actualizar</button>
                            </form>
                        </div>
                        <button type="button" class="btn mb-2 btn-secondary text-white w-50 d-block mx-auto" data-toggle="collapse" data-target="#userPassword">Cambiar contraseña</button>
                        <div id="userPassword" class="collapse">
                            <form action="{{ route('updatePassword') }}" method="post">
                                @method('PATCH')
                                @csrf
                                <div class="d-block">
                                    <input type="password" name="password" id="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }} pl-3 w-75 d-block mx-auto mb-1 input_custom" placeholder="Contraseña" required>
                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                    <input type="password" id="password-confirm" name="password_confirmation" class="form-control pl-3 w-75 d-block mx-auto input_custom mb-1" placeholder="Confirmar contraseña">
                                </div>
                                <button class="btn text-white d-block mx-auto mb-3" style="background-color: #26C6CF" type="submit" role="button">Guardar contraseña</button>
                            </form>
                        </div>
                    </div>
                </div> --}}

                {{-- Share Code & Social Network: col-md-5
                <div class="col-md-5">
                    <div id="shareCode" class="border border-info mx-auto circleDiv">
                        <span class="align-middle invite">
                            <h3 class="text-body invite">Invita, Comparte y GANA.</h3>
                            <h5 class="text-muted">Tu código es: </h5>
                            <h4 class="text-danger">{{ Auth::user()->share_code }}</h4>
                            <i class="fab fa-whatsapp mr-2" id="media_icon" ></i><i class="fab fa-twitter" id="media_icon" ></i>
                            <i class="fab fa-facebook mr-2" id="media_icon" ></i><i class="fas fa-envelope" id="media_icon"></i>
                        </span>
                    </div>
                </div> --}}

                {{-- Add Card, Classes, Waitlist & Payments
                <div class="col-md-7">
                    <div id="Payments" class="mb-4">
                        <h5 class="text-center mx-auto myclss">Formas de Pago</h5>
                        <h5 class="text-center mx-auto mb-2 myclss">Mis tarjetas</h5>
                        <button class="btn btn-dark text-white mb-4 w-50 d-block mx-auto" data-toggle="modal" data-target="#addCardModal" role="button"><span>+ Añadir tarjeta</span></button>
                    </div>
                    <div id="extraInfo">
                        <button type="button" class="btn btn-secondary mb-2 text-white w-50 d-block mx-auto" st>Historial de pagos</button>
                        <button type="button" class="btn btn-secondary mb-2 text-white w-50 d-block mx-auto" st>Lista de espera</button>
                        <button type="button" class="btn btn-secondary mb-2 text-white w-50 d-block mx-auto" st>Clases anteriores</button>
                        <button type="button" class="btn btn-secondary mb-2 text-white w-50 d-block mx-auto" st>Clases expiradas</button>
                    </div>
                </div> --}}
            </div>

            <!-- Add Credit/Debit Card Modal !-->
            <div class="modal fade" id="addCardModal" tabindex="-1" role="dialog" aria-labelledby="addCardModalTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content bg-dark">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addCardModalTitle"></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-5">
                                    <p id="oName">{{ Auth::user()->name }} {{ Auth::user()->last_name}}</p>
                                </div>
                                {{-- Form Add Card --}}
                                <form method="post" id="add-card-form">
                                    @csrf
                                    <input type="hidden" name="token_id" id="token_id">
                                    <input type="hidden" name="device_session_id" id="device_session_id">
                                    <input type="hidden" name="tokenBearer" id="tokenBearer" value="{{ Session::get("tokenBearer")[0]}}">
                                    <div class="col-7">
                                        <div class="data">
                                            <img id="visa" src="/img/visa.png" alt="visa" width="83px" height="40px">
                                            <img src="/img/mastercard.png" alt="mastercard" width="83px" height="40px">
                                            <img src="/img/express.png" alt="express" width="85px" height="50px">
                                        </div>
                                        <input class="data" type="text" id="cardOwner" placeholder="Nombre del tarjetahabiente" value="Juan Perez Ramirez" data-openpay-card="holder_name">
                                        <input class="data" type="text" id="cardNumber" placeholder="Número de la tarjeta" value="4111111111111111" data-openpay-card="card_number">

                                        {{-- <select class="data" name="" id="monthExpiration" value="12" data-openpay-card="expiration_month">
                                            @for ($i = 1; $i <= 12; $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select> --}}
                                        <input class="data" type="text" id="monthExpiration" placeholder="Mes de Expiración" value="12" data-openpay-card="expiration_month">

                                        {{-- <select class="data" name="" id="yearExpiration" value="20" data-openpay-card="expiration_year">
                                            @for ($i = 0; $i <= 10; $i++)
                                                <option value="{{ now()->format('Y') }}">{{ now()->modify('+'. $i .' year')->format('Y') }}</option>
                                            @endfor
                                        </select> --}}
                                        <input class="data" type="text" id="yearExpiration" placeholder="Año de Expiración" value="20" data-openpay-card="expiration_year">
                                        <input class="data" type="text" name="" id="cvv" placeholder="CVV" value="110" data-openpay-card="cvv2">
                                    </div>
                                </form>
                                {{-- End Form Add Card --}}
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-dark" id="add-card-button">Agregar</button>
                        </div>
                    </div>
                </div>
            </div>
        {{-- </div> --}}
    </div>

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script type="text/javascript" src="https://openpay.s3.amazonaws.com/openpay.v1.min.js"></script>
    <script type='text/javascript' src="https://openpay.s3.amazonaws.com/openpay-data.v1.min.js"></script>

<script type="text/javascript">
    var deviceSessionId = null;
    var token_id = null;
    var tokenBearer = null;
    var crfsToken = '{{ csrf_token() }}';

    $(document).ready(function() {
        OpenPay.setId('mwykro9vagcgwumpqaxb');
        OpenPay.setApiKey('pk_d72eec48f13042949140a7873ee1b3c2');
        OpenPay.setSandboxMode(true);
        //Se genera el id de dispositivo
        device_session_id = OpenPay.deviceData.setup("add-card-form", "deviceIdHiddenFieldName");
        $('#device_session_id').val(device_session_id);
        //Bearer en Variable del Script

        $('#add-card-button').on('click', function(event) {
            event.preventDefault();
            $("#add-card-button").prop( "disabled", true);
            OpenPay.token.extractFormAndCreate('add-card-form', sucess_callbak, error_callbak);
            console.log(OpenPay);
        });

        var sucess_callbak = function(response) {
            token_id = response.data.id;
            $('#token_id').val(token_id);
            // Submit Form
            // $('#add-card-form').submit();
            addCard();
        };

        var error_callbak = function(response) {
            var desc = response.data.description != undefined ? response.data.description : response.message;
            alert("ERROR [" + response.status + "] " + desc);
            $("#add-card-button").prop("disabled", false);
        };

        // $.get("App/Http/Controllers/Auth/LoginController.php", function(data, status){
        //     alert("Token:" + data + "\nStatus" + status);
        // });

        function addCard(){
            tokenBearer = $('#tokenBearer').val();
            console.log('si entro');
            $.ajax({
                url: "/api/addCard",
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${tokenBearer}`,
                },
                data: {
                    _token: crfsToken,
                    token_id: token_id,
                    device_session_id: device_session_id,
                    customer_id: 'customerId'
                },
                success: function(result){
                    console.log(result);
                }
            });
            console.log('token_id: ', token_id);
            console.log('device_session_id: ', device_session_id);
            console.log('Token CRSF: ', crfsToken);
            console.log('Bearer: ', tokenBearer);
        };
    });
</script>
@endsection

@section('extraScripts')
@endsection