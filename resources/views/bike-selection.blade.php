@extends('layouts.main')

@section('title')
    Reservar Bici
@endsection

@section('content')
    @php
        use Carbon\Carbon;
    @endphp
    <div class="container-fluid main">
        <div class="select">
            <a href="/schedule" id="goBack">Volver al calendario</a>
            <input type="hidden" id="schedule_id" value="{{ $schedules->id }}">
                <div class="row">
                    <div class="col-md-6 col-xs-6 bnd" id="placeDate">
                        <?php setlocale(LC_TIME,'es_MX.utf8'); $dt = Carbon::now(); $inicio = strftime("%A %d de %B,", strtotime($schedules->day));?>
                        <h6 class="col-md-6 col-xs-12 ml-0 first" id="branch">ESTUDIO: <span>{{ $schedules->branch->name }}</span></h6>
                    </div>
                    <div class="col-2 col-xs-6"></div>
                    <div class="col col-xs-0" id="selectBikeLogo">
                        <h5 class="ent">Selecciona tu bici y entra a
                            <img class="cropLogo" src="/img/iconos/CroppedLogo.png" alt="">
                        </h5>
                    </div>
                </div>
                {{-- Displays the Date of the selected schedule on another row, now this can be displayed properly on mobile screens --}}
                <div class="row">
                    <h6 class="col-md-6 col-xs-12 first" id="date"> FECHA: <span>{{ $inicio }}</span> <span> {{ date('h', strtotime($schedules->hour)) }}:{{ date('i A', strtotime($schedules->hour)) }} </span></h6>
                </div>
            <div class="description">
                <span class="text-center text_gradient_bike_selection"> Reserva tu clase </span>
            </div>
            @if (strlen($instructor->profile_image) > 0)
                <img  id="profilePic" src="{{ $instructor->profile_image }}" class="card-img-top" alt="{{ $instructor->name }}">
            @else
                <img id="profilePic" src="{{ asset('img/instructors/Instructor-Head.png') }}" alt="">
            @endif
	</div>
	<br/>
        <div class="row" id="main-bikes">
            <div class="centeredDiv" id="bikes-div" style="width: 100%">
            </div>
        </div>
    </div>
    @include('packages')
    @include('partials.footer')
@endsection


@section('extraStyles')
    <link rel="stylesheet" href="{{ asset('css/style-bike.css') }}">
    <style>
        #profilePic {
            border-radius: 0px !important;
            height: auto !important;
        }
    </style>
@endsection

@section('extraScripts')
<script type="text/javascript" src="https://cdn.conekta.io/js/latest/conekta.js"></script>
<script type="text/javascript">
    let product_id = null;
    $(document).ready(()=>{
        $(document).on("click", ".pickClass", function(e) {
            var elementId = this.id;
            elementExploded = elementId.split("-");
            product_id  = elementExploded[1];
            console.log(product_id);
        })
        Conekta.setPublicKey('{{ env('CONEKTA_PUBLIC_KEY') }}');
      
      
        let conektaSuccessResponseHandler = function(token) {
          let $form = $("#card-form");
          //Inserta el token_id en la forma para que se envíe al servidor
          $form.append($('<input type="hidden" name="conektaTokenId" id="conektaTokenId">').val(token.id));
          $form.append($('<input type="hidden" name="brand_card" id="brand_card">').val(Conekta.card.getBrand($("#cardNumber").val())));
          $form.append($('<input type="hidden" name="product_id" id="product_id">').val(product_id));
          $.ajax({
            beforeSend: function(){
                $("#payment-button").prop("disabled", true);
                $.LoadingOverlay("show");
            },
            url: "/conekta/checkout",
            method:'POST',
            data: $form.serialize(),
          }).done((response) => {
            if(response.status == true){
                $.LoadingOverlay("hide");
                $('#newCardChargeModal').modal('hide');
                Swal.fire(
                    '¡Hecho!',
                    response.message,
                    'success'
                )
                setTimeout(() => {
                    window.location.href = "/user";
                }, 3500);
            }else{
                $("#payment-button").prop("disabled", false);
                $('#newCardChargeModal').modal('hide');
                $.LoadingOverlay("hide");
                console.log(response.data);
                Swal.fire({
                    title: 'Error',
                    text: response.message,
                    type: 'error',
                    confirmButtonText: 'Aceptar'
                });
            }
          });
/*           $form.get(0).submit();   *////Hace submit
        };
        let conektaErrorResponseHandler = function(response) {
          let $form = $("#card-form");
          $form.find(".card-errors").text(response.message_to_purchaser);
          $form.find("button").prop("disabled", false);
        };
      
      $("#payment-button").click(()=>{
        $("#payment-button").prop("disabled", true);
        if($("#cardOwner").val() && $("#cardNumber").val() && $("#Code").val() && $("#monthExpiration").val() && $("#yearExpiration").val()){
            $("#card-form").submit();
        }else{
            $("#payment-button").prop("disabled",  false);
           $(".card-errors").text('No deje campos vacíos');
        } 
      });
        //jQuery para que genere el token después de dar click en submit
        $(function () {
          $("#card-form").submit(function(event) {
            let $form = $(this);
            // Previene hacer submit más de una vez
            $form.find("button").prop("disabled", true);
            Conekta.Token.create($form, conektaSuccessResponseHandler, conektaErrorResponseHandler);
            return false;
          });
        });

        $('#pay-selected-card-button').click(()=> {
            $("#pay-selected-card-button").prop( "disabled", true);
            makeCharge();
        });

        $('#use-new-card-button').click(() => {
            $('#savedCardsModal').modal('hide');
            $('#newCardChargeModal').modal('show');
        });

            
    });

    function makeCharge(){
        const card_id = $('#selectSavedCard').val();
        $.ajax({
            url: "/conekta/charge/create",
            method: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                product_id: product_id,
                card_id:  card_id
            },
            beforeSend: function(){
                $.LoadingOverlay("show");
            },
            success: function(response){
            $.LoadingOverlay("hide");
            if(response.status == true){
                $.LoadingOverlay("hide");
                $('#savedCardsModal').modal('hide');
                Swal.fire(
                    '¡Hecho!',
                    response.message,
                    'success'
                )
                setTimeout(() => {
                    window.location.href = "/user";
                }, 3500);
            }else{
                console.log(response.data);
                $("#pay-selected-card-button").prop("disabled", false);
                $('#savedCardsModal').modal('hide');
                $.LoadingOverlay("hide");
                Swal.fire({
                    title: 'Error',
                    text: response.message,
                    type: 'error',
                    confirmButtonText: 'Aceptar'
                });
            }
            },
            error: function (result) {
                alert("Ocurrió un error en el pago, por favor intente de nuevo");
                $("#pay-selected-card-button").prop( "disabled", false);
            },
            failure: function (result) {
                alert("Ocurrió un error en el pago, por favor intente de nuevo");
                $("#pay-selected-card-button").prop( "disabled", false);
                //swal error de comunicación
            }
        });
    }
  </script>
    <script type="text/javascript" src="https://openpay.s3.amazonaws.com/openpay.v1.min.js"></script>
    <script type="text/javascript" src="https://openpay.s3.amazonaws.com/openpay-data.v1.min.js"></script>
    <script type="text/javascript">
        var crfsToken = '{{ csrf_token() }}';
        var selectedBike = "{{ $selectedBike }}";
        var disabledBikes = '{!! json_encode($disabledBikes) !!}';
        var instructorBikes = '{!! json_encode($instructorBikes) !!}';
        var x = "{{ $schedules->branch->reserv_lim_x }}";
        var y = "{{ $schedules->branch->reserv_lim_y }}";
        var reservedPlaces = '{!! json_encode($reservedPlaces) !!}';
        var opId = "{{ env('OPENPAY_ID') }}";
        var opPublicKey = "{{ env('OPENPAY_PUBLIC_KEY') }}";
        var opSandbox = "{{ env('OPENPAY_SANDBOX') }}";
        var instructor = "{{ $instructor->name }}";
        var scheduleHour = "{{ $schedules->hour }}";
        var scheduleDay = "{{ $schedules->day }}";
        var cancelation_period = "{{ $schedules->branch->cancelation_period }}";
        var scheduleHourBeforeCancelation = "{{ $scheduleHourBeforeCancelation }}";
    </script>
    <script src="{{ asset('js/openpay-script.js') }}"></script>
    <script src="{{ asset('js/bike-selection-script.js') }}?{{ time() }}"></script>
@endsection
