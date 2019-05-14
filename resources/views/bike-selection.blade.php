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
            <div class="centeredDiv" id="bikes-div">
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
        var reservedPlaces = jQuery.parseJSON("{!! json_encode($reservedPlaces) !!}");
    </script>
    <script src="{{asset('js/openpay-script.js')}}"></script>
    <script src="{{asset('js/bike-selection-script.js')}}"></script>
@endsection