<div id="packages" class="packages container-fluid">
    <div class="description">
        <img class="buyClass" src="/img/iconos/1.png" alt="">
    </div>
    <div class="row classes">
        <div class="content-normal col col-sm col-md col-lg" style=" padding: 0;">
            <div id="first-class" data-toggle="modal" data-target="#exampleModalCenter" onclick="classQuantity('primera')">
                <img class="bicImg" src="/img/iconos/BICI.png" alt="">
                <h6 id="amount1">PRIMERA</h6>
                <h5 class="class f-class">CLASE</h5>
                <p class="price">$150</p>
                <p class="exp">Expira: 30 días</p>
            </div>
        </div>
        @php
            $amount=2;
            $flag=true;
        @endphp
        @foreach ($products as $product)
            @if ($product != $products{0})
                {{--dd($products{0})--}}
                <div class="content-normal col col-sm col-md col-lg" style=" padding: 0;">
                    <div id="content-normal" class="content-n" data-toggle="modal" data-target="#exampleModalCenter" onclick="classQuantity('{{ $product->n_classes }}')">
                        <h3 id="amount{{$amount}}">{{$product->n_classes}}</h3>
                        @if ($flag)
                            <h5 class="class">CLASE</h5>
                            {{$flag=false}}
                        @else
                            <h5 class="class">CLASES</h5>
                        @endif
                        <p class="precio">{{$product->price}}</p>
                        <p class="exp">Expira: {{$product->expiration_days}} días</p>
                        <input type="hidden" name="product_id" id="product_id">
                    </div>
                </div>
                @php
                    $amount++;
                @endphp
            @endif
        @endforeach
        <!-- Modal -->
        @guest
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                    <div class="col-5">
                        <p id="oName">Ingresa a tu Cuenta</p>
                    </div>
                    <div class="col-7">
                        <a id="btnLog" href="{{ route('login') }}" class="button">INICIAR SESIÓN</a>
                    </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="closeBtn" data-dismiss="modal">Cerrar</button>
                </div>
                </div>
            </div>
        </div>
        @endguest
        @auth
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                    <form method="post" id="payment-form">
                            @csrf
                            <input type="hidden" name="token_id" id="token_id">
                            <input type="hidden" name="device_session_id" id="device_session_id">
                            <input type="hidden" name="tokenBearer" id="tokenBearer" value="{{ Session::get("tokenBearer")[0]}}">
                        <div class="">
                            <img class="cards" src="/img/iconos/VISA.png" alt="visa">
                            <img class="cards" src="/img/iconos/MASTER.png" alt="mastercard" >
                            <img class="cards" src="/img/iconos/AMERICAN.png" alt="express">
                        </div>
                        <input class="data mx-auto" type="text" name="" id="cardOwner" placeholder="Nombre" maxlength="35" data-openpay-card="holder_name">
                        <input class="data mx-auto" type="text" name="" id="cardNumber" placeholder="Número de tarjeta"  maxlength="16" data-openpay-card="card_number">
                            <div class="cInfo mx-auto">
                                <select class="dataRow" name="" id="monthExpiration" data-openpay-card="expiration_month">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                </select>
                                <select class="dataRow" name="" id="yearExpiration" data-openpay-card="expiration_year">
                                    <option value="19">2019</option>
                                    <option value="20">2020</option>
                                    <option value="21">2021</option>
                                    <option value="22">2022</option>
                                    <option value="23">2023</option>
                                    <option value="24">2024</option>
                                    <option value="25">2025</option>
                                    <option value="26">2026</option>
                                    <option value="27">2027</option>
                                    <option value="28">2028</option>
                                    <option value="29">2029</option>
                                </select>
                                <input class="dataRow" type="text" name="" id="Code" placeholder="CVV" maxlength="3" data-openpay-card="cvv2">
                            </div>
                        <div class="">
                        <input type="checkbox" name="data" id="data">
                        <label for="data">Guarda datos de mi tarjeta</label>
                        </div>
                        <input class="data mx-auto" type="text" name="" id="Discount" placeholder="Código de descuento" maxlength="10">
                        <button type="button" class="button">Aplicar código</button>
                        <div class="">
                        <input type="checkbox" name="conditions" id="conditions">
                        <label for="conditions" class="conditions">Acepto términos y condiciones</label>
                        </div>
                    </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="closeBtn" data-dismiss="modal">Cerrar</button>
                <button type="button" class="button" id="pay-button">Comprar</button>
            </div>
            </div>
        </div>
        </div>
        @endauth
    </div>
</div>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script type="text/javascript" src="https://openpay.s3.amazonaws.com/openpay.v1.min.js"></script>
<script type='text/javascript' src="https://openpay.s3.amazonaws.com/openpay-data.v1.min.js"></script>

<script type="text/javascript">
//variable que crear openpay
var deviceSessionId = null;
//solo se crea cuando hay una respuesta success
var token_id = null;
//token de usuario autenticado
var tokenBearer = null;
//se genera solo por laravel
var crfsToken = '{{ csrf_token() }}';
var product_id = null;

$(document).ready(function() {
    OpenPay.setId('mwykro9vagcgwumpqaxb');
    OpenPay.setApiKey('pk_d72eec48f13042949140a7873ee1b3c2');
    OpenPay.setSandboxMode(true);
    //Se genera el id de dispositivo
    device_session_id = OpenPay.deviceData.setup("payment-form", "deviceIdHiddenFieldName");
    $('#device_session_id').val(device_session_id);
    //Bearer en Variable del Script

    $('#pay-button').on('click', function(event) {
        event.preventDefault();
        $("#pay-button").prop( "disabled", true);
        OpenPay.token.extractFormAndCreate('payment-form', sucess_callbak, error_callbak);
        console.log(OpenPay);
    });

    var sucess_callbak = function(response) {
        token_id = response.data.id;
        $('#token_id').val(token_id);
        // Submit Form
        //$('#payment-form').submit();
        makeCharge();

        console.log("cargo realizado");
    };

    var error_callbak = function(response) {
        var desc = response.data.description != undefined ? response.data.description : response.message;
        alert("ERROR [" + response.status + "] " + desc);
        $("#pay-button").prop("disabled", false);
    };

    // $.get("App/Http/Controllers/Auth/LoginController.php", function(data, status){
    //     alert("Token:" + data + "\nStatus" + status);
    // });

    function makeCharge(){
        tokenBearer = $('#tokenBearer').val();
        console.log('si entro');
        $.ajax({
            url: "/api/makeCharge",
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${tokenBearer}`,
            },
            data: {
                _token: crfsToken,
                token_id: token_id,
                device_session_id: device_session_id,
                product_id: product_id,
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