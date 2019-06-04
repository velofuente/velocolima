{{-- Table with the Info --}}
<div class="row text-center mx-0 py-4">
    <h3>Horarios</h3>
    <button class="btn btn-success btn-sm mx-4 justify-content-right" data-toggle="modal" data-target="#addScheduleModal">Añadir Horario</button>
</div>

{{-- Table  --}}
@if (count($schedules) > 0)
    <table class="table table-striped table-hover">
        <thead style="font-size: 1em;">
            <tr style="font-size: 1em;">
                <th scope="col">ID</th>
                <th scope="col">Día</th>
                <th scope="col">Hora</th>
                <th scope="col">Instructor</th>
                <th scope="col">Límite de Reservación</th>
                <th scope="col">Estatus</th>
                <th scope="col" colspan="2" class="text-center">Acción</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($schedules as $schedule)
                <tr style="font-size: 0.9em;">
                    {{-- <th scope="row">{{$schedule->id}}</th> --}}
                    <td>{{$schedule->id}}</td>
                    <td>{{ date('d-M-o', strtotime($schedule->day)) }}</td>
                    <td>{{ date('h:s A', strtotime($schedule->hour)) }}</td>
                    <td>{{$schedule->instructor->name}}</td>
                    <td>{{$schedule->reservation_limit}}</td>
                    <td>Estatus</td>
                    <td><button class="btn btn-primary btn-sm editSchedule" id="editSchedule-{{ $schedule->id }}" value="{{$schedule->id}}" data-toggle="modal" data-target="#editScheduleModal">Editar</button></td>
                    <td><button class="btn btn-danger btn-sm deleteSchedule" id="deleteSchedule-{{ $schedule->id }}" value="{{$schedule->id}}">Eliminar</button></td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <h2 class="text-center">No hay Instructores Agregados</h2>
@endif


{{-- Add, Delete & Edit Instructors Scripts --}}
