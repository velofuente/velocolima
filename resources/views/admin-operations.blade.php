{{-- Show the Schedules (ordered by Hour) for today --}}
<div class="row text-center mx-0 py-3">
    <h3 class="col-md-4 col-sm-12 col-xs-12">Operaciones</h3>
    <div class="dropdown col-md-8 col-sm-12 col-xs-12">
        <button class="btn btn-success mx-3 dropdown-toggle" id="dropdownSchedule" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span id="selectedSchedule">Horario</span>
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownSchedule">
            @foreach ($schedules as $schedule)
                @if ($schedule->day == date('Y-m-d'))
                    @if ($schedule->hour >= date('H:i:s'))
                        <a class="dropdown-item" href="javascript:showClients({{$schedule->id}})" id="{{$schedule->id}}">
                            <span>{{ date('g:i A', strtotime($schedule->hour)) }} |</span>
                            <span>{{$schedule->instructor->name}}</span>
                            {{-- <img width="60%" height="60%" src="{{ asset('img/instructors/' . $schedule->instructor->name . '-Head.png') }}" alt=""> --}}
                        </a>
                    {{-- @else
                        <a class="dropdown-item text-danger" href="#">
                            <span>{{ date('g:i A', strtotime($schedule->hour)) }}</span>
                            <span>{{$schedule->instructor->name}}</span>
                        </a> --}}
                    @endif
                @else
                    <h3 class="text-left">No hay horarios creados el día de hoy</h3>
                @endif
            @endforeach
        </div>
    </div>
</div>

{{-- Bike Grid & Table of Users--}}
<div class="row" id="main-bikes">
    <div class="centeredDiv col-md-10" id="bikes-div" style="width: 100%">
        <h1>System Grid Test</h1>
    </div>
    <div class="col-md-2">
        @if (count($userSchedules) > 0)
            <table class="table table-striped table-hover">
                <thead style="font-size: 1em;">
                    <tr style="font-size: 1em;">
                        <th scope="col">Nombre</th>
                        <th scope="col">Teléfono</th>
                        <th scope="col">Email</th>
                        <th scope="col">Talla de Calzado</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- the Value of each Row contains its respective schedule_id --}}
                    @foreach ($userSchedules as $userSchedule)
                        <tr style="font-size: 0.9em;" id="tableBodyRow">
                            <input type="hidden" value="{{$userSchedule->schedule_id}}" id="hiddenUsers">
                            <td>{{$userSchedule->user->name}} {{$userSchedule->user->last_name}}</td>
                            <td> {{$userSchedule->user->phone}} </td>
                            <td>{{$userSchedule->user->email}}</td>
                            <td>{{$userSchedule->user->shoe_size}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <h2 class="text-center">No hay usuarios en esta sesión</h2>
        @endif
    </div>
</div>

{{-- Add, Delete & Edit Products Scripts --}}
<script>
    var variable1 = null;
    var variable2 = [];
    var variable3 = [];
    var cols = null;

    $(document).ready(function (){
        $('#main-bikes').hide();

        // Dropdown Selected Option
        $('.dropdown-menu a').click(function(){
            $('#selectedSchedule').text($(this).text());
        });

        cols = document.querySelectorAll('#tableBodyRow');
    });

    function showClients(id){
        variable1 = id;
        variable2 = document.getElementById("tableBodyRow");
        console.log('ID guardado (Schedule): ' + id);
        var i = 0;

        // cols.forEach(element => {
        //     console.log(cols[i]);
        //     i++;
        // });

        //Línea para Eliminar la Fila de la Tabla
        cols.item(0).remove();
        $('#main-bikes').show();
    }
</script>