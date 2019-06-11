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
                <th scope="col">Sucursal</th>
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
                    <td>{{$schedule->branch->name}}</td>
                    <td><button class="btn btn-primary btn-sm editSchedule" id="editSchedule-{{ $schedule->id }}" value="{{$schedule->id}}" data-myid="{{$schedule->id}}" data-myday="{{ $schedule->day }}" data-myhour="{{ $schedule->hour }}" data-myinstructor="{{ $schedule->instructor->id }}" data-myreservation="{{ $schedule->reservation_limit }}" data-mybranch="{{$schedule->branch->id}}" data-toggle="modal" data-target="#editScheduleModal">Editar</button></td>
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
                            <label for="day">Día: </label>
                            <input class="form-control" type="date" name="day" id="addDaySchedule">
                        </div>
                        <div class="col">
                            <label for="hour">Hora:</label>
                            <input class="form-control" type="time" name="hour" id="addHourSchedule">
                        </div>
                        <div class="col">
                            <label for="instructorInput">Instructor:</label>
                            <select class="form-control" name="instructorInput" id="addInstructorSchedule">
                                @foreach ($instructors as $instructor)
                                    <option value="{{$instructor->id}}" class="text-center">{{$instructor->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <label for="branchInput">Sucursal: </label>
                            <select class="form-control" name="branchInput" id="branchInput">
                                @foreach ($branches as $branch)
                                    <option value="{{$branch->id}}" class="text-center" id="addBranchSchedule">{{$branch->name}}</option>
                                @endforeach
                            </select>
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

{{-- Modal Edit Schedule --}}
<div class="modal fade bd-example-modal-lg" id="editScheduleModal" tabindex="-1" role="dialog" aria-labelledby="editScheduleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editScheduleModalLabel">Editar Horario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- <form method="POST" action="{{ route('addSchedule') }}" class="registration"> --}}
                    @csrf
                    <div class="row">
                        <div class="col">
                            <label for="day">Día:</label>
                            <input class="form-control" type="date" name="day" id="editDaySchedule">
                        </div>
                        <div class="col">
                            <label for="hour">Hora:</label>
                            <input class="form-control" type="time" name="hour" id="editHourSchedule">
                        </div>
                        <div class="col">
                            <label for="editInstructor">Instructor:</label>
                            <select class="form-control" name="editInstructor" id="editInstructorSchedule">
                                @foreach ($instructors as $instructor)
                                    <option value="{{$instructor->id}}" class="text-center">{{$instructor->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <label for="branchInput">Sucursal:</label>
                            <select class="form-control" name="branchInput" id="editBranchSchedule">
                                @foreach ($branches as $branch)
                                    <option value="{{$branch->id}}" class="text-center">{{$branch->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                {{-- </form> --}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success" id="editScheduleButton">Editar Horario</button>
            </div>
        </div>
    </div>
</div>

{{-- Add, Delete & Edit Schedule Scripts --}}
<script type="text/javascript">
    var crfsToken = '{{ csrf_token() }}';
</script>
{{-- <script src="{{asset('js/bike-grid-script.js')}}"></script> --}}

<script>
$(document).ready(function(){
    // var instructor_id = null;
    var schedule_id = null;
    var day = null;
    var hour = null;
    var instructor = null;
    var branch = null;

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

    //OnClick editSchedule Button
    $('.editSchedule').on('click', function (){
        // $(this).prop('disabled', true);
        event.preventDefault();

        //Get Full ID of the button (which contains the instructor ID)
        var fullId = this.id;
        //Split the ID of the fullId by his dash
        var splitedId = fullId.split("-");
        if(splitedId.length > 1){
            // console.log(splitedId);
            var instructorId = splitedId[1];
            // editSchedule(instructorId, this);
        } else {
            $(this).prop("disabled", false)
            console.log("Malformed ID")
        }
    })
    //OnClick editScheduleModal Button

    //When Modal Opened
    $('#editScheduleModal').on('show.bs.modal', function (event) {
        // Button that triggered the modal
        var button = $(event.relatedTarget)
        // Extract info from data-* attributes
        schedule_id = button.data('myid')
        day = button.data('myday') // Extract info from data-* attributes
        hour = button.data('myhour');
        instructor = button.data('myinstructor');
        branch = button.data('mybranch');
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-body #editDaySchedule').val(day)
        modal.find('.modal-body #editHourSchedule').val(hour)
        modal.find('.modal-body #editInstructorSchedule').val(instructor)
        modal.find('.modal-body #editBranchSchedule').val(branch)
    })

    //Edit Product Button Inside Modal
    $('#editScheduleButton').on('click', function(){
        $('#editScheduleButton').prop("disabled", true)
        event.preventDefault();

        day = $('#editDaySchedule').val(); // Extract info from data-* attributes
        hour = $('#editHourSchedule').val();
        instructor = $('#editInstructorSchedule').val();
        branch = $('#editBranchSchedule').val();

        editSchedule(schedule_id);
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
                day: $('#addDaySchedule').val(),
                hour: $('#addHourSchedule').val(),
                instructor_id: $('#addInstructorSchedule').val(),
                branch_id: $('#addBranchSchedule').val(),
                // class_id: 1,
                //reserv_lim_x: $('#x').val(),
                //reserv_lim_y: $('#y').val(),
                // room_id: 1,
                // disabledBikes: disabledBikes,
                // instructorBikes: instructorBikes
            },
            success: function(result){
                if(result.status == "OK"){
                    $.LoadingOverlay('hide');
                    Swal.fire({
                        title: 'Horario creado con éxito',
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

    function editSchedule(schedule_id){
        $.ajax({
            url: "editSchedule",
            type: 'POST',
            cache: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function(){
                $.LoadingOverlay("show");
            },
            data: {
                schedule_id: schedule_id,
                day: day,
                hour: hour,
                instructor_id: instructor,
                branch_id: branch,
            },
            success: function(result) {
                $.LoadingOverlay("hide");
                if(result.status == "OK"){
                    // console.log(result.status);
                    Swal.fire({
                        title: 'Producto Editado',
                        text: result.message,
                        type: 'success',
                        confirmButtonText: 'Aceptar'
                    })
                    window.location.reload();
                }
                else {
                    $.LoadingOverlay("hide");
                    Swal.fire({
                        title: 'Error',
                        text: result.message,
                        type: 'warning',
                        confirmButtonText: 'Aceptar'
                    })
                }
            },
            error: function(result){
                $.LoadingOverlay("hide");
                // alert(result);
                Swal.fire({
                    title: 'Error',
                    text: 'No se pudo procesar su solicitud',
                    type: 'warning',
                    confirmButtonText: 'Aceptar'
                })
            }
        });
    };

    function deleteSchedule(schedule_id, button){
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
                        schedule_id: schedule_id,
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
    };
})
</script>