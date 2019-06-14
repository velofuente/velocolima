{{-- Show the Schedules (ordered by Hour) for today --}}
<div class="row text-center mx-0 py-3">
    <h3 class="col-4">Operaciones</h3>
    <div class="dropdown col-8">
        <button class="btn btn-secondary mx-3 dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Horarios
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            @foreach ($schedules as $schedule)
                @if ($schedule->day == date('Y-m-d'))
                    @if ($schedule->hour >= date('H:i:s'))
                        <a class="dropdown-item" href="#">
                            <span>{{ date('g:i A', strtotime($schedule->hour)) }}</span>
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
    <div class="centeredDiv col-10" id="bikes-div" style="width: 100%">
        <h1>System Grid Test</h1>
    </div>
    <div class="col-2">
        @if (count($userSchedules) > 0)
            <table class="table table-striped table-hover">
                <thead style="font-size: 1em;">
                    <tr style="font-size: 1em;">
                        <th scope="col">Nombre</th>
                        <th scope="col">Apellido</th>
                        <th scope="col">Email</th>
                        <th scope="col">Talla de Calzado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($userSchedules as $userSchedule)
                        <tr style="font-size: 0.9em;">
                            <td>{{$userSchedule->user->name}}</td>
                            <td>{{$userSchedule->user->last_name}}</td>
                            <td>{{$userSchedule->user->email}}</td>
                            <td>{{$userSchedule->user->shoe_size}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <h2 class="text-center">No hay Productos Agregados</h2>
        @endif
    </div>
</div>

{{-- Table  --}}
{{-- @if (count($schedules) > 0)
    <table class="table table-striped table-hover">
        <thead style="font-size: 1em;">
            <tr style="font-size: 1em;">
                <th scope="col">ID</th>
                <th scope="col">Día</th>
                <th scope="col">Hora</th>
                <th scope="col">Límite de Reservación</th>
                <th scope="col">Instructor</th>
                <th scope="col">Sucursal</th>
                <th scope="col" colspan="2" class="text-center">Acción</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($schedules as $schedule)
                <tr style="font-size: 0.9em;">
                    <td>{{$schedule->id}}</td>
                    <td>{{$schedule->day}}</td>
                    <td>{{$schedule->hour}}</td>
                    <td>{{$schedule->reservation_limit}}</td>
                    <td>{{$schedule->instructor->name}}</td>
                    <td>{{$schedule->branch->name}}</td>
                    <td><button class="btn btn-primary btn-sm editProduct" id="editProduct-{{ $schedule->id }}" value="{{$schedule->id}}" data-myid="{{ $schedule->id }}" data-myday="{{ $schedule->day }}" data-toggle="modal" data-target="#editProductModal">Editar</button></td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <h2 class="text-center">No hay Productos Agregados</h2>
@endif --}}

{{-- Add, Delete & Edit Products Scripts --}}
<script>
    $(document).ready(function (){
        var product_id = null;
    })
</script>