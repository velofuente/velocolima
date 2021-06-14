@extends('layouts.main')

@section('title')
    Horario
@endsection

@section('content')
    <div class="container-fluid pt-4 mb-4 main">
        <div class="row" id="topNavBar">
            {{-- Empty Section at the Far LeftNavBar --}}
            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                <span class="weekShown">
                </span>
            </div>
            {{-- Message Actual Week --}}
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-3">
                <input type="hidden" name="timezoneSet" value="{{ setlocale(LC_TIME,'es_MX.utf8') }}">
                <input type="hidden" name="WeekShown" value="{{ $weekShown=now() }}">
                <input type="hidden" name="setMonth" value="{{ $month=strftime('%B', strtotime($weekShown)) }}">
                <span class="weekShown">
                    del {{date('d')}} al {{date('d', strtotime($weekShown->modify("+6 days")))}} de {{ $month}}
                </span>
            </div>
            {{-- Empty Section at the Middle of the NavBar --}}
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-4">
                <span class="weekShown">
                </span>
            </div>
            {{-- Instructor Dropdown --}}
            <div class="col-xs-4 ol-sm-4 col-md-4 col-lg-3">
                <div class="container-fluid">
                    <select class="dropdown" id="ScheduleInstructor" onchange="scheduleByInstructor()">
                        <option value="allInstructors" selected="selected">Instructores</option>
                        @foreach ($instructors as $instructor)
                            <option value="{{ $instructor->name }}">{{ $instructor->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            {{-- Empty Section at the Far Right NavBar --}}
            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                <span class="weekShown">
                </span>
            </div>
        </div>

        {{-- Schedule Section --}}
        <input type="hidden" name="timezoneSet" value="{{ date_default_timezone_set('America/Mexico_City') }}">
        <input type="hidden" name="actualDay" value="{{ $today=now() }}">
        <input type="hidden" name="thisDay" value="{{ $thisDay=now() }}">
        <div class="container" id="calendario" name="calendar">
            {{-- <h1 class="text-center text-white">SCHEDULE BACKUP</h1> --}}
            @if(count($schedules) > 0)
                <div class="row" id="rowSchedule" name="dates">
                    @for ($i = 0; $i < 7; $i++)
                    <section class="col" id="scheduleDayColumn">
                        <ul>
                            <li class="scheduleDayText">
                                <input type="hidden" name="langLocal" value="<?php setlocale(LC_TIME,'es_MX.utf8'); $dayNumber=strftime('%d', strtotime($today));?>">
                                <input type="hidden" name="langLocal" value="<?php $dayName = strftime("%a", strtotime($today));?>">
                            <span class="number"> {{ $dayName}}.{{ $dayNumber}}</span>
                            </li>
                            @foreach ($schedules as $schedule)
                                @if ($schedule->day == $today->format('Y-m-d'))
                                    {{-- If the Schedule Day == Actual (Real) Day of the Week then check the hour scheduled --}}
                                    @if ($schedule->day == $thisDay->format('Y-m-d'))
                                        @if ($schedule->hour < $today->format('H:i:s'))
                                            @if ($schedule->description == null)
                                                {{-- Disabled Boxes || No Description--}}
                                                <span class="scheduleItemLinkDisabled">
                                                    <li class="scheduleItemDisabled" id="{{ $schedule->instructor->name }}">
                                                        <section class="scheduleItemContainer">
                                                            <p class="scheduleItemTextInstructor">
                                                                {{ $schedule->instructor->name}}
                                                            </p>
                                                            <p class="scheduleItemTextHourDisabled">
                                                                {{ date('g:i A', strtotime($schedule->hour)) }}
                                                            </p>
                                                        </section>
                                                    </li>
                                                </span>
                                            @else
                                                {{-- Disabled Boxes || No Description--}}
                                                <span class="scheduleItemLinkDisabled">
                                                        <li class="scheduleItemDisabled" id="{{ $schedule->instructor->name }}">
                                                            <section class="scheduleItemContainerDescription">
                                                                <p class="scheduleItemTextInstructor">
                                                                    {{ $schedule->instructor->name}}
                                                                </p>
                                                                <p class="scheduleDescription">{{ $schedule->description }}</p>
                                                                <p class="scheduleItemTextHourDisabled">
                                                                    {{ date('g:i A', strtotime($schedule->hour)) }}
                                                                </p>
                                                            </section>
                                                        </li>
                                                    </span>
                                            @endif
                                        @else
                                            @if($schedule->description == null)
                                                {{-- Enabled Boxes from Today || No Description --}}
                                                <a href="/bike-selection/{{ $schedule->id }}" class="scheduleItemLink">
                                                    <li class="scheduleItem" id="{{ $schedule->instructor->name }}">
                                                        <section class="scheduleItemContainer">
                                                            <p class="scheduleItemTextInstructor">
                                                                {{ $schedule->instructor->name}}
                                                            </p>
                                                            <p class="scheduleItemTextHour">
                                                                {{ date('g:i A', strtotime($schedule->hour)) }}
                                                            </p>
                                                        </section>
                                                    </li>
                                                </a>
                                            @else
                                                {{-- Enabled Boxes from Today || With Description--}}
                                                <a href="/bike-selection/{{ $schedule->id }}" class="scheduleItemLink">
                                                    <li class="scheduleItem" id="{{ $schedule->instructor->name }}">
                                                        <section class="scheduleItemContainerDescription">
                                                            <p class="scheduleItemTextInstructor">
                                                                {{ $schedule->instructor->name}}
                                                            </p>
                                                            <p class="scheduleDescription">{{ $schedule->description}}</p>
                                                            <p class="scheduleItemTextHour">
                                                                {{ date('g:i A', strtotime($schedule->hour)) }}
                                                            </p>
                                                        </section>
                                                    </li>
                                                </a>
                                            @endif
                                        @endif
                                    @else
                                        @if($schedule->description == null)
                                            {{-- Enabled Boxes day by day || No Description --}}
                                            <a href="/bike-selection/{{ $schedule->id }}" class="scheduleItemLink">
                                                <li class="scheduleItem" id="{{ $schedule->instructor->name }}">
                                                    <section class="scheduleItemContainer">
                                                        <p class="scheduleItemTextInstructor">
                                                            {{ $schedule->instructor->name }}
                                                        </p>
                                                        <p class="scheduleItemTextHour">
                                                            {{ date('g:i A', strtotime($schedule->hour)) }}
                                                        </p>
                                                    </section>
                                                </li>
                                            </a>
                                        @else
                                            {{-- Enabled Boxes day by day || No Description --}}
                                            <a href="/bike-selection/{{ $schedule->id }}" class="scheduleItemLink">
                                                <li class="scheduleItem" id="{{ $schedule->instructor->name }}">
                                                    <section class="scheduleItemContainerDescription">
                                                        <p class="scheduleItemTextInstructor">
                                                            {{ $schedule->instructor->name }}
                                                        </p>
                                                        <p class="scheduleDescription">{{ $schedule->description}}</p>
                                                        <p class="scheduleItemTextHour">
                                                            {{ date('g:i A', strtotime($schedule->hour)) }}
                                                        </p>
                                                    </section>
                                                </li>
                                            </a>
                                        @endif
                                    @endif
                                @endif
                            @endforeach
                        </ul>
                    </section>
                    <input type="hidden" value="{{ $today->modify('+1 day') }}">
                    @endfor
                </div>
            @else
                <h4 class="text-center text-white">Aún no hay clases agendadas</h4>
            @endif
        </div>
    </div>
    @include('packages')
    @include('partials.footer')
@endsection

@section('extraStyles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/schedule-styles.css') }}">
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
                $("#payment-button").prop("disabled", false);
                $.LoadingOverlay("hide");
                $('#newCardChargeModal').modal('hide');
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });

                Toast.fire({
                    icon: 'success',
                    title: response.message
                });
            }else{
                $("#payment-button").prop("disabled", false);
                $('#newCardChargeModal').modal('hide');
                $.LoadingOverlay("hide");
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
        if($("#cardOwner").val() && $("#cardNumber").val() && $("#Code").val() && $("#monthExpiration").val() && $("#yearExpiration").val()){
            $("#card-form").submit();
        }else{
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
            $("#pay-button").prop( "disabled", false);
            if(response.status == true){
                $("#payment-button").prop("disabled", false);
                $.LoadingOverlay("hide");
                $('#savedCardsModal').modal('hide');
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });

                Toast.fire({
                    icon: 'success',
                    title: response.message
                });
            }else{
                $("#payment-button").prop("disabled", false);
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