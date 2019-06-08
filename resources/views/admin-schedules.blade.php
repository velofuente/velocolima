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
    <h2 class="text-center">No hay Horarios Agendados</h2>
@endif

{{-- Modal Add Schedule --}}
<div class="modal fade bd-example-modal-lg" id="addScheduleModal" tabindex="-1" role="dialog" aria-labelledby="addScheduleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addScheduleModalLabel">Añadir Horario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- <form method="POST" action="{{ route('addSchedule') }}" class="registration"> --}}
                    @csrf
                    <div class="row">
                        <div class="col">
                            Filas: <input class="form-control" maxlength="2" type="text" name="x" id="x">
                        </div>
                        <div class="col">
                            Columnas: <input class="form-control" maxlength="2" type="text" name="y" id="y">
                        </div>
                        <div class="col">
                            Día: <input class="form-control" type="date" name="day" id="day">
                        </div>
                        <div class="col">
                            Hora: <input class="form-control" type="time" name="hour" id="hour">
                        </div>
                        <div class="col">
                            Instructor <select class="form-control" name="instructorInput" id="instructorInput">
                                @foreach ($instructors as $instructor)
                                    <option value="{{$instructor->id}}" class="text-center" id="scheduleInstructor">{{$instructor->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row my-4 mx-auto justify-content-center">
                        <div class="col">
                            <p>Asiento Libre</p>
                            <span class="mx-auto common showBallFree">1</span>
                        </div>
                        <div class="col">
                            <p>Asiento Instructor</p>
                            <span class="mx-auto showBallInstructor">1</span>
                        </div>
                        <div class="col">
                            <p>Asiento Deshabilitado</p>
                            <span class="showBallDisabled">1</span>
                        </div>
                    </div>
                    {{-- <div class="row">
                        <div class="col my-4">
                            <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                            <div class="col-10 col-xs-10 col-sm-10 col-md-8 mx-auto">
                                Instructor <select class="form-control" name="instructorInput" id="instructorInput">
                                    @foreach ($instructors as $instructor)
                                        <option value="{{$instructor->id}}" class="text-center" id="scheduleInstructor">{{$instructor->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                        </div>
                    </div> --}}
                    <div class="row my-4" id="main-bikes">
                        <div class="centeredDiv" id="bikes-div">
                        </div>
                    </div>
                {{-- </form> --}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success" id="addScheduleButton">Añadir Horario</button>
            </div>
        </div>
    </div>
</div>

{{-- Add, Delete & Edit Schedule Scripts --}}
<script type="text/javascript">
    var crfsToken = '{{ csrf_token() }}';
</script>
<script src="{{asset('js/bike-grid-script.js')}}"></script>

<script>
$(document).ready(function(){
    $('#addScheduleButton').on('click', function(event) {
        // event.preventDefault();
        $('#addScheduleButton').attr('disabled', true);
        addSchedule();
    });

    //OnClick deleteSchedule Button
    $('.deleteSchedule').on('click', function(event) {
        $(this).prop("disabled", true)
        event.preventDefault();

        //Get Full ID of the button (which contains the Schedule ID)
        var fullId = this.id;
        //Split the ID of the fullId by his dash
        var splitedId = fullId.split("-");
        if(splitedId.length > 1){
            // console.log(splitedId);
            var ScheduleId = splitedId[1];
            deleteSchedule(ScheduleId, this);
        } else {
            $(this).prop("disabled", false)
            console.log("Malformed ID")
        }
        // $('#deleteScheduleButton').attr('disabled', true);
    })

    function addSchedule(){
        //Array to get disabled bikes and instructor bike(s)
        var disabledBikes = [];
        var instructorBikes = [];
        //Select each ball with class "disabled" and push it into the array
        $( ".disabled" ).each(function () {
            disabledBikes.push($(this).text());
        })
        //Same as above, but with instructor(s) bike(s);
        $( ".instructor" ).each(function () {
            instructorBikes.push($(this).text());
        })
        $.ajax({
            url: "addSchedule",
            method: 'POST',
            beforeSend: function(){
                $.LoadingOverlay('show');
            },
            data: {
                _token: crfsToken,
                day: $('#day').val(),
                hour: $('#hour').val(),
                instructor_id: $('#instructorInput').val(),
                // class_id: 1,
                reserv_lim_x: $('#x').val(),
                reserv_lim_y: $('#y').val(),
                // room_id: 1,
                disabledBikes: disabledBikes,
                instructorBikes: instructorBikes
            },
            success: function(result){
                if(result.status == "OK"){
                    $.LoadingOverlay('hide');
                    Swal.fire({
                        title: 'Creado con exito',
                        text: result.message,
                        type: 'success',
                        confirmButtonText: 'Aceptar'
                    })
                    window.location.reload();
                } else {
                    $.LoadingOverlay('hide');
                    Swal.fire({
                        title: 'Woops!',
                        text: result.message,
                        type: 'error',
                        confirmButtonText: 'Aceptar'
                    })
                }
                // console.log(result);
            }
        });
    }

    function deleteSchedule(Schedule_id, button){
        // Schedule_id = $('#deleteScheduleButton').val();
        Swal.fire({
            title: '¿Estás seguro?',
            text: "No se podrán revertir los cambios!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, Eliminar Horario'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: 'deleteSchedule',
                    type: 'POST',
                    cache: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        schedule_id: Schedule_id,
                    },
                    success: function(result) {
                        $.LoadingOverlay("hide");
                        if (result.status == "OK") {
                            console.log(result.status);
                            Swal.fire({
                                title: 'Horario Eliminado',
                                text: result.message,
                                type: 'success',
                                confirmButtonText: 'Aceptar'
                            })
                            window.location.reload();
                        } else {
                            $.LoadingOverlay("hide");
                            Swal.fire({
                                title: 'Error',
                                text: result.message,
                                type: 'warning',
                                confirmButtonText: 'Aceptar'
                            });
                            $(button).prop("disabled", false)
                        }
                    },
                    error: function(result){
                        $.LoadingOverlay("hide");
                        Swal.fire({
                            title: 'Error',
                            text: "No se pudo procesar la solicitud.",
                            type: 'warning',
                            confirmButtonText: 'Aceptar'
                        });
                        $(button).prop("disabled", false)
                        // alert(result);
                    }
                });
            } else {
                $(button).prop("disabled", false)
            }
        })
    }
})
</script>