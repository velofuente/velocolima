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
                    <div class="col-md-6 col-xs-6 bnd" id="placeDate">
                        <?php setlocale(LC_TIME,'es_MX.utf8'); $dt = Carbon::now(); $inicio = strftime("%A %d de %B,", strtotime($schedules->day));?>
                        <h6 class="col-md-6 col-xs-12 ml-0 first" id="branch">ESTUDIO: <span>{{$schedules->branch->name}}</span></h6>
                        {{-- <h6 class="col-md-6 col-xs-12 first" id="date"> FECHA: <span>{{$inicio}}</span> <span> {{date('h', strtotime($schedules->hour))}}:{{date('i A', strtotime($schedules->hour))}} </span></h6> --}}
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
                    <h6 class="col-md-6 col-xs-12 first" id="date"> FECHA: <span>{{$inicio}}</span> <span> {{date('h', strtotime($schedules->hour))}}:{{date('i A', strtotime($schedules->hour))}} </span></h6>
                </div>
            <div class="description">
                {{-- <img class="resClass" src="/img/iconos/2.png" alt=""> --}}
                <span class="text-center text_gradient_bike_selection"> Reserva tu clase </span>
            </div>
            {{-- <img id="profilePic" src="{{ asset('img/instructors/' . $schedules->instructor->name . '-Head.png') }}" alt=""> --}}
            <img id="profilePic" src="{{ asset('img/instructors/Instructor-Head.png') }}" alt="">
        </div>
        <div class="row" id="main-bikes">
            <div class="centeredDiv" id="bikes-div" style="width: 100%">
            </div>
        </div>
    </div>
    @include('packages')
    @include('footer')
@endsection
@section('extraScripts')
    <script type="text/javascript" src="https://openpay.s3.amazonaws.com/openpay.v1.min.js"></script>
    <script type='text/javascript' src="https://openpay.s3.amazonaws.com/openpay-data.v1.min.js"></script>
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
        var cancelation_period = "{{ $schedules->branch->cancelation_period }}";
        var scheduleHourBeforeCancelation = "{{ $scheduleHourBeforeCancelation }}";
    </script>
    <script src="{{asset('js/openpay-script.js')}}"></script>
    <script src="{{asset('js/bike-selection-script.js')}}"></script>
@endsection