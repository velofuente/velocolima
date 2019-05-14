@extends('layout')
@section('title')
Reservar Bici
@endsection
@section('extraStyles')
    <link rel="stylesheet" href="{{asset('css/style-bike.css')}}">
@endsection
@section('content')
    @php
        use Carbon\Carbon;
    @endphp
    <div class="container-fluid main">
        <div class="select">
            <a href="/schedule" id="goBack">Volver al calendario</a>
            <input type="hidden" id="schedule_id" value="{{$schedules->id}}">
                <div class="row">
                    <div class="col-5 bnd">
                        <?php setlocale(LC_TIME,'es_MX.utf8'); $dt = Carbon::now(); $inicio = strftime("%A %d de %B,", strtotime($schedules->day));?>
                        <h6 class="first" id="branch">ESTUDIO: <span>{{$schedules->room->branch->name}}</span></h6>
                        <h6 class="first" id="date"> FECHA: <span>{{$inicio}}</span> <span> {{date('h', strtotime($schedules->hour))}}:{{date('i', strtotime($schedules->hour))}} </span></h6>
                    </div>
                    <div class="col-2"></div>
                    <div class="col">
                        <h5 class="ent">Selecciona tu bici y entra a
                                <img class="cropLogo" src="/img/iconos/CroppedLogo.png" alt="">
                        </h5>
                    </div>
                </div>
            <div class="description">
                <img class="resClass" src="/img/iconos/2.png" alt="">
            </div>
            <img id="profilePic" src="{{ asset('img/instructors/' . $schedules->instructor->name . '-Head.png') }}" alt="">
        </div>

        <div class="row" id="main-bikes">
            <div class="centeredDiv"> 
                <div id="divr1" class="col-md-12">
                    <span class="bikes" id="ball-1">1</span>
                    <span class="bikes" id="ball-2">2</span>
                    <span class="bikes" id="ball-3">3</span>
                    <span class="bikes" id="ball-4">4</span>
                    <span class="bikes" id="ball-5">5</span>
                    
                </div>
                <div id="divr2" class="col-md-12">
                    <span class="bikes" id="ball-6">6</span>
                    <span class="bikes" id="ball-7">7</span>
                    <span class="bikes" id="ball-8">8</span>
                    <span class="bikes" id="ball-9">9</span>
                    <span class="bikes" id="ball-10">10</span>
                </div>
                <div id="divr3" class="col-md-12">
                    <span class="bikes" id="ball-11">11</span>
                    <span class="bikes" id="ball-12">12</span>
                    <span class="bikes" id="ball-13">13</span>
                    <span class="bikes" id="ball-14">14</span>
                    <span class="bikes" id="ball-15">15</span>
                </div>
            </div>
        </div> 
        <!--
        <div class="details">
            <input type="hidden" name="actualDay" value="{{$day=now()}}">
            <div class="row">
                <div class="col">
                    <div>
                        <h5 class="first" >INSTRUCTOR</h5>
                        <h5>{{$schedules->instructor->name}}</h5>
                    </div>
                    <div>
                        <h5 class="first">NO. DE LUGAR</h5>
                        <h5 id="placeNum">--</h5>
                    </div>
                </div>
            </div>
        </div>
    -->
    <!--
        <div id="dinamicTable">
        </div>
    -->
    </div>
    @include('packages')
    @include('footer')
@endsection
@section('extraScripts')
    {{-- <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script> --}}
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="https://openpay.s3.amazonaws.com/openpay.v1.min.js"></script>
    <script type='text/javascript' src="https://openpay.s3.amazonaws.com/openpay-data.v1.min.js"></script>


    {{-- <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.js"></script> --}}
    {{-- <script type="text/javascript" src="https://openpay.s3.amazonaws.com/openpay.v1.min.js"></script>
    <script type='text/javascript' src="https://openpay.s3.amazonaws.com/openpay-data.v1.min.js"></script> --}}

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
        var selectedBike = "{{ $selectedBike }}";
        var reservedPlaces = jQuery.parseJSON("{!! json_encode($reservedPlaces) !!}");

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
            });

            var sucess_callbak = function(response) {
                token_id = response.data.id;
                $('#token_id').val(token_id);
                // product_id = $('#product_id').val();
                // console.log(product_id);
                // Submit Form
                makeCharge();
                $('#payment-form').submit();

                console.log("cargo realizado");
            };
            $('#payment-form').on('submit', function(e){
                e.preventDefault();
                window.location.replace("/user");
            })

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
                    url: "/makeCharge",
                    method: 'POST',
                    /*headers: {
                            'Authorization': `Bearer ${tokenBearer}`
                        },*/
                    data: {
                        _token: crfsToken,
                        token_id: token_id,
                        device_session_id: device_session_id,
                        product_id: product_id
                    },
                    success: function(result){
                        console.log(result);
                    }
                });
                console.log('token_id: ', token_id);
                console.log('device_session_id: ', device_session_id);
                console.log('Token CRSF: ', crfsToken);
                console.log('Bearer: ', tokenBearer);
            }
        });

        $(document).on("click", ".pickClass", function(e) {
            var elementId = this.id;
            elementExploded = elementId.split("-")
            product_id = elementExploded[1];
            console.log(product_id);
        })

        $(document).on("click", ".places", function(e) {
            e.preventDefault();
            console.log(this.id);
        })
    </script>
    <script src="{{asset('js/bike-selection-script.js')}}"></script>
@endsection