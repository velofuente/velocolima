@extends('layouts.main')

@section('title')
    Horario
@endsection

@section('content')
    <div class="container-fluid pt-4 mb-4 main">
        <div class="row" id="topNavBar">
            {{-- Empty Section at the Far LeftNavBar --}}
            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-2">
                <span class="weekShown">
                </span>
            </div>
            {{-- Message Actual Week --}}
            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-2">
                <input type="hidden" name="timezoneSet" value="{{ setlocale(LC_TIME,'es_MX.utf8') }}">
                <input type="hidden" name="WeekShown" value="{{ $weekShown=now() }}">
                <input type="hidden" name="setMonth" value="{{ $month=strftime('%B', strtotime($weekShown)) }}">
                <span class="weekShown">
                    del {{date('d')}} al {{date('d', strtotime($weekShown->modify("+6 days")))}} de {{ $month}}
                </span>
            </div>
            {{-- Place Dropdown --}}
            {{-- <div class="col-xs-3 col-sm-3 col-md-3 col-lg-2"> --}}
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-4">
                {{-- <div class="container-fluid">
                    <select name="places" id="places" class="dropdown">
                        <option value="allPlaces">Ubicación</option>
                        @foreach ($places as $place)
                            <option value="{{$place->id}}">{{$place->name}}</option>
                        @endforeach
                    </select>
                </div> --}}
            </div>

            {{-- Brand dropdown --}}
            {{-- <div class="col-xs-3 col-sm-3 col-md-3 col-lg-2">
                <div class="container-fluid">
                    <select name="brands" id="brands" class="dropdown">
                        <option value="allBrands">Estudio</option>
                    </select>
                </div>
            </div> --}}

            {{-- Branch dropdown --}}
            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-2">
                <div class="container-fluid">
                    <select class="dropdown" id="branches" name="branches">
                        <option value="allBranches" selected="selected"></option>
                        <option value="{{ env('PROMOTIONAL_VELO_BRANCH_ID', 3) }}">Victoria</option>
                        <option value="{{ env('PROMOTIONAL_FORTE_BRANCH_ID', 5) }}">Forte Victoria</option>
                    </select>
                </div>
            </div>
            {{-- Empty Section at the Far Right NavBar --}}
            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-2">
                <span class="weekShown">
                </span>
            </div>
        </div>

        {{-- Schedule Section --}}
        <input type="hidden" name="timezoneSet" value="{{ date_default_timezone_set('America/Mexico_City') }}">
        <input type="hidden" name="actualDay" value="{{ $today=now() }}">
        <input type="hidden" name="thisDay" value="{{ $thisDay=now() }}">
        <div class="container" id="calendario" name="calendar">
            <h2 class="text-center text-white ">Reserva en</h2>
            <div class="row justify-content-center">
                <div id="promotionalVelo" class="px-4 content-n promotional-branches" data-branch-id="{{ env('PROMOTIONAL_VELO_BRANCH_ID', 3) }}">
                    {{-- <h4 id="package-description" class="mt-2 text-center">Forte</h4> --}}
                    <img class=" img-fluid rounded" src="{{ asset('img/iconos/LOGO.png')}}" />
                </div>
                <div id="promotionalForte" class="px-4 content-n promotional-branches" data-branch-id="{{ env('PROMOTIONAL_FORTE_BRANCH_ID', 5) }}">
                    {{-- <h5 id="package-description" class="mt-2 text-center">Velo Cycling</h5> --}}
                    <img class="mt-3 img-fluid rounded" src="{{ asset('img/iconos/logo_forte.png')}}" />
                </div>
            </div>
        </div>
    </div>
    @include('packages')
    @include('partials.footer')
@endsection

@section('extraStyles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/schedule-styles.css') }}">
    <style>
        .hidden { display: none; }
        .promotional-branches {
            width: 40vh;
            cursor: pointer;
            padding: 1em;
            border: 1px solid;
            border-color: rgba(255, 255, 255, 0.3);
            border-radius: 0.5em;
            margin: 0 1em;
        }
        .promotional-branches:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }
    </style>
@endsection

@section('extraScripts')
<script type="text/javascript" src="{{ asset('js/schedule-script.js') }}"></script>
<script type="text/javascript" src="https://cdn.conekta.io/js/latest/conekta.js"></script>
<script type="text/javascript">
    let veloBranchId = "{{ env('PROMOTIONAL_VELO_BRANCH_ID', 3) }}";
    let forteBranchId = "{{ env('PROMOTIONAL_FORTE_BRANCH_ID', 5) }}";
    let product_id = null;
    let token = "{{ csrf_token() }}";
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
            $("#payment-button").prop("disabled", false);
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

        $('#places').on('change', function (e) {
           var selectedPlace = $(this).val();
           getBrandListByPlace(selectedPlace);
        });

        $('#brands').on('change', function (e) {
            var selectedBrand = $(this).val();
            getBranchesListByBrand(selectedBrand);
        });

        $('#branches').on('change', function (e) {
            var branchId = $(this).val();
            getScheduleListByBranch(branchId);
        });

        $('.promotional-branches').on('click', function (e) {
            var branchId = $(this).data('branch-id');
            getScheduleListByBranch(branchId);
            $('#branches').each(function () {
                
            });
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
                }, 2000);
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
                $("#pay-selected-card-button").prop( "disabled", false);
            },
            failure: function (result) {
                $("#pay-selected-card-button").prop( "disabled", false);
                //swal error de comunicación
                alert("Ocurrió un error en el pago, por favor intente de nuevo");
            }
        });
    }
  </script>
{{-- <script type="text/javascript" src="https://openpay.s3.amazonaws.com/openpay.v1.min.js"></script>
<script type='text/javascript' src="https://openpay.s3.amazonaws.com/openpay-data.v1.min.js"></script>
    <script type="text/javascript">
        var crfsToken = '{{ csrf_token() }}';
        var opId = "{{ env('OPENPAY_ID') }}";
        var opPublicKey = "{{ env('OPENPAY_PUBLIC_KEY') }}";
        var opSandbox = "{{ env('OPENPAY_SANDBOX') }}";
    </script>
    <script src="{{ asset('js/openpay-script.js') }}"></script>
    <script src="{{ asset('/js/schedule-script.js') }}"></script> --}}
@endsection