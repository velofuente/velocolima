<link rel="stylesheet" type="text/css" href="{{asset('css/admin-schedules-styles.css')}}">
{{-- Table with the Info --}}
<div class="row text-center mx-0 py-4">
    <h3>Horarios</h3>
    <button class="btn btn-success btn-sm mx-4 justify-content-right" id="buttonNextClasses">Clases Próximas</button>
    <button class="btn btn-success btn-sm mx-4 justify-content-right" id="buttonPreviousClasses">Clases Pasadas</button>
    <button class="btn btn-success btn-sm mx-4 justify-content-right" id="buttonTopAddSchedule" data-toggle="modal" data-target="#addScheduleModal">Añadir Horario</button>
</div>
{{-- Basic Table --}}
{{-- @if (count($schedules) > 0)
    <table class="table table-striped table-hover" id="tableNextClasses" style="margin: 0 0">
        <thead style="font-size: 1em;">
            <tr style="font-size: 1em;">
                <th scope="col">ID</th>
                <th scope="col">Fecha</th>
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
                    <td>{{$schedule->id}}</td>
                    <td>{{ date('d-M-o', strtotime($schedule->day)) }}</td>
                    <td>{{ date('g:i A', strtotime($schedule->hour)) }}</td>
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
@endif --}}

{{-- Table Next Clases --}}
@if (count($schedules) > 0)
    <table class="table table-striped table-hover" id="tableNextClasses" style="margin: 0 0">
        <thead style="font-size: 1em;">
            <tr style="font-size: 1em;">
                <th scope="col">ID</th>
                <th scope="col">Fecha</th>
                <th scope="col">Hora</th>
                <th scope="col">Instructor</th>
                <th scope="col">Descripción</th>
                <th scope="col">Límite de Reservación</th>
                <th scope="col">Bicis Reservadas</th>
                <th scope="col">Bicis Disponibles</th>
                <th scope="col">Sucursal</th>
                <th colspan="2" class="text-center">Acción</th>
            </tr>
        </thead>
        <tbody id="tableBodyNextClasses">
            {{-- <tr style="font-size: 0.9em;"> --}}
                {{-- <th scope="row">{{$schedule->id}}</th> --}}

                {{-- <td><button class="btn btn-primary btn-sm editSchedule" id="editSchedule-{{ $schedule->id }}" value="{{$schedule->id}}" data-myid="{{$schedule->id}}" data-myday="{{ $schedule->day }}" data-myhour="{{ $schedule->hour }}" data-myinstructor="{{ $schedule->instructor->id }}" data-myreservation="{{ $schedule->reservation_limit }}" data-mybranch="{{$schedule->branch->id}}" data-toggle="modal" data-target="#editScheduleModal">Editar</button></td>
                <td><button class="btn btn-danger btn-sm deleteSchedule" id="deleteSchedule-{{ $schedule->id }}" value="{{$schedule->id}}">Eliminar</button></td> --}}
            {{-- </tr> --}}
        </tbody>
    </table>
@else
    <h2 class="text-center">No hay Horarios Agendados</h2>
@endif

{{-- Table Previous Clases --}}
@if (count($schedules) > 0)
    <table class="table table-striped table-hover" id="tablePreviousClasses" style="margin: 0 0">
        <thead style="font-size: 1em;">
            <tr style="font-size: 1em;">
                <th scope="col">ID</th>
                <th scope="col">Fecha</th>
                <th scope="col">Hora</th>
                <th scope="col">Instructor</th>
                <th scope="col">Descripción</th>
                <th scope="col">Límite de Reservación</th>
                <th scope="col">Bicis Reservadas</th>
                <th scope="col">Bicis Disponibles</th>
                <th scope="col">Sucursal</th>
            </tr>
        </thead>
        <tbody id="tableBodyPreviousClasses">
            {{-- <tr style="font-size: 0.9em;"> --}}
                {{-- <th scope="row">{{$schedule->id}}</th> --}}

                {{-- <td><button class="btn btn-primary btn-sm editSchedule" id="editSchedule-{{ $schedule->id }}" value="{{$schedule->id}}" data-myid="{{$schedule->id}}" data-myday="{{ $schedule->day }}" data-myhour="{{ $schedule->hour }}" data-myinstructor="{{ $schedule->instructor->id }}" data-myreservation="{{ $schedule->reservation_limit }}" data-mybranch="{{$schedule->branch->id}}" data-toggle="modal" data-target="#editScheduleModal">Editar</button></td>
                <td><button class="btn btn-danger btn-sm deleteSchedule" id="deleteSchedule-{{ $schedule->id }}" value="{{$schedule->id}}">Eliminar</button></td> --}}
            {{-- </tr> --}}
        </tbody>
    </table>
@else
    <h2 class="text-center">No hay Horarios Agendados</h2>
@endif

{{-- Modal Add Schedule --}}
<div class="modal fade bd-example-modal-lg" id="addScheduleModal" tabindex="-1" role="dialog" aria-labelledby="addScheduleModalLabel" aria-hidden="true">1
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
                            <input class="form-control" min="1900-01-01" max="2100-12-31" type="date" name="day" id="addDaySchedule">
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
                            <select class="form-control" name="branchInput" id="addBranchSchedule">
                                @foreach ($branches as $branch)
                                    <option value="{{$branch->id}}" class="text-center" >{{$branch->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 mx-auto text-center mt-3">
                            <label for="descriptionInput">Descripción:</label>
                            <input type="text" class="form-control" name="descriptionInput" id="addDescriptionSchedule" maxlength="27">
                            <label for="descriptionInput" class="font-weight-light" style="font-size: 14px">(máximo 27 caracteres)</label>
                        </div>
                    </div>
                    <div class="addScheduleErrors">
                        <ul id="addErrorsList">
                        </ul>
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
                            <input class="form-control" min="1900-01-01" max="2100-12-31" type="date" name="day" id="editDaySchedule">
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
                    <div class="row">
                        <div class="col-6 mx-auto text-center mt-3">
                            <label for="editDescription">Descripción:</label>
                            <input type="text" class="form-control" name="editDescription" id="editDescriptionSchedule" maxlength="27">
                            <label for="descriptionInput" class="font-weight-light" style="font-size: 14px">(máximo 27 caracteres)</label>
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

{{-- <script src="{{asset('js/bike-grid-script.js')}}"></script> --}}

{{-- Add, Delete & Edit Schedule Scripts --}}
<script type="text/javascript">
    var crfsToken = '{{ csrf_token() }}';
</script>

{{-- All the Functions --}}
<script>
    // Min Date to create a Schedule = Today
    addDaySchedule.min = new Date().toISOString().split("T")[0];

    $(document).ready(function(){
        // var instructor_id = null;
        var schedule_id = null;
        var day = null;
        var hour = null;
        var instructor = null;
        var branch = null;
        var description = null;

        $('#buttonTopAddSchedule').hide();
        $('table').hide();
        $('#buttonNonReservedBikes').hide();
        $('#buttonReservedBikes').hide();

        $('#buttonNextClasses').on('click', function(event){
            getNextClasses();
        });

        $('#buttonPreviousClasses').on('click', function(event){
            getPreviousClasses();
        });

        if ( $('[type="date"]').prop('type') != 'date' ) {
            $('[type="date"]').attr('placeholder', 'yyyy-mm-dd')
            $('[type="date"]').datepicker({
                // showButtonPanel: true,
                dateFormat: 'yy/mm/dd',
                dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa", "Do"],
                dayNamesShort: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab", "Dom"],
                dayNames: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo"],
                monthNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
                currentText: "Hoy",
                changeMonth: true,
                changeYear: true,
                minDate: 0,
                yearRange: '1920:2019',
                dateFormat: 'yy-mm-dd',
                onSelect: function(dateText, inst) {
                    $(inst).val(dateText); // Write the value in the input
                }
            });
        }

        if ( $('[type="time"]').prop('type') != 'time' ) {
            $('[type="time"]').attr('placeholder', '23:00')
        }

        $('#addScheduleButton').on('click', function(event) {
            // event.preventDefault();
            $('#addScheduleButton').attr('disabled', true);
            addSchedule();
        });

        function addSchedule(button){
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
            $('#addErrorsList').empty()
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
                    description: $('#addDescriptionSchedule').val(),
                    branch_id: $('#addBranchSchedule').val(),
                },
                success: function(result){
                    if(result.status == "OK"){
                        $.LoadingOverlay('hide');
                        // $('.modal-backdrop').remove();
                        // $('.active-menu').trigger('click');
                        $('#addScheduleModal').modal('hide');
                        $('#addScheduleButton').prop('disabled', false);
                        $('#buttonNextClasses').click();
                        Swal.fire({
                            title: 'Horario creado con éxito',
                            text: result.message,
                            type: 'success',
                            confirmButtonText: 'Aceptar'
                        });
                    } else {
                        $('#addScheduleButton').prop('disabled', false);
                        $.LoadingOverlay('hide');
                        // $.each(result.error.message, function( index, value ) {
                        //     $('#addErrorsList').append(
                        //         '<li>'+value+'</li>',
                        //     );
                        // });
                        // $('#addErrorsList').show().delay(4000).hide('slow');
                        Swal.fire({
                            title: 'Error',
                            text: result.message,
                            type: 'warning',
                            confirmButtonText: 'Aceptar'
                        })
                    }
                    // console.log(result);
                }, error: function(result){
                    $.LoadingOverlay('hide');
                    $('#addScheduleButton').prop('disabled', false);
                    Swal.fire({
                        title: 'Error',
                        text: 'Ocurrió un error al procesar la solicitud',
                        type: 'error',
                        confirmButtonText: 'Aceptar'
                    })
                }
            });
        }
    });

    //OnClick deleteSchedule Button
    $(document).on('click','.deleteSchedule', function(event){
        event.preventDefault();
        $(this).prop("disabled", true)
        //Get Full ID of the button (which contains the Schedule ID)
        var fullId = this.id;
        //Split the ID of the fullId by his dash
        var splitedId = fullId.split("-");
        if(splitedId.length > 1){
            // console.log(splitedId);
            var ScheduleId = splitedId[1];
            scheduledReservedPlaces(ScheduleId, this);
            // deleteSchedule(ScheduleId, this);
        } else {
            $(this).prop("disabled", false)
            console.log("Malformed ID")
        }
        // $('#deleteScheduleButton').attr('disabled', true);
    });

    //OnClick editSchedule Button
    $(document).on('click', '.editSchedule', function(event){
        // $(this).prop('disabled', true);
        event.preventDefault();
        // console.log('simón')
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
        description = button.data('mydescription');
        branch = button.data('mybranch');
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-body #editDaySchedule').val(day)
        modal.find('.modal-body #editHourSchedule').val(hour)
        modal.find('.modal-body #editInstructorSchedule').val(instructor)
        modal.find('.modal-body #editDescriptionSchedule').val(description)
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
        description = $('#editDescriptionSchedule').val();

        editSchedule(schedule_id);
    })

    function scheduledReservedPlaces(schedule_id, button){
        $.ajax({
            url: 'scheduledReservedPlaces',
            type: 'POST',
            cache: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function(){
                // $.LoadingOverlay("show");
                $(button).prop('disabled', true);
            },
            data: {
                schedule_id: schedule_id,
            },
            success: function(result){
                if(result.status == "OK"){
                    // $.LoadingOverlay("hide");
                    $(button).prop('disabled', false);
                    deleteSchedule(schedule_id, this);
                } else {
                    $.LoadingOverlay("hide");
                    $(button).prop('disabled', false);
                    Swal.fire({
                        title: 'No se puede eliminar',
                        text: result.message,
                        type: 'warning',
                        confirmButtonText: 'Aceptar'
                    });
                }
            },
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
                description: description,
                branch_id: branch,
            },
            success: function(result) {
                $.LoadingOverlay("hide");
                if(result.status == "OK"){
                    // $('.modal-backdrop').remove();
                    // $('.active-menu').trigger('click');
                    $('#editScheduleButton').prop('disabled', false);
                    $('#editScheduleModal').modal('hide');
                    Swal.fire({
                        title: 'Producto Editado',
                        text: result.message,
                        type: 'success',
                        confirmButtonText: 'Aceptar'
                    })
                    getNextClasses();
                }
                else {
                    $.LoadingOverlay("hide");
                    $('#editScheduleButton').prop('disabled', false);
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

    // Clickable Rows on Tables
    $('#tableNextClasses').on('click', 'tr', function(event){
        var id = $(this).attr('id');
        var fullId = id.split('-');
        if (fullId.length > 1){
            var splittedId = fullId[1];
            scheduleOperations = splittedId;
            operationsSchedule = scheduleOperations;
        }
        if(!$(event.target).hasClass('text-center')) {
            $('#frameView').load('admin-operations');
        }
    });

    function getNextClasses(){
        $('#tableNextClasses').removeClass('table-striped table-hover');
        $.ajax({
            url: "getNextClasses",
            method: 'GET',
            beforeSend: function(){
                $.LoadingOverlay('show');
            },
            success: function(result){
                $.LoadingOverlay('hide');
                $('#tableBodyNextClasses').empty();
                $.each(result, function(index, value){
                    if(value.object.description != null){
                        $('#tableBodyNextClasses').append(
                            '<tr style="font-size: 0.9em;" class="rowNextClasses" id="rowSchedule-'+value.object.id+'"><td>'+value.object.id+'</td><td>'+value.formatDay+'</td><td>'+value.formatHour+'</td><td>'+value.object.instructor.name+'</td><td>'+value.object.description+'</td><td>'+value.object.reservation_limit+'</td><td>'+value.reservedBikes+'</td><td>'+value.availableBikes+'</td><td>'+value.object.branch.name+'</td><td class="text-center"><button class="btn btn-primary btn-sm editSchedule text-center" id="editSchedule-'+value.object.id+'" value="'+value.object.id+'" data-myid="'+value.object.id+'" data-myday="'+value.object.day+'" data-myhour="'+value.object.hour+'" data-myinstructor="'+value.object.instructor_id+'"data-mydescription="'+value.object.description+'" data-myreservation="'+value.object.reservation_limit+'" data-mybranch="'+value.object.branch_id+'" data-toggle="modal" data-target="#editScheduleModal">Editar</button></td><td class="text-center"><button class="btn btn-danger btn-sm deleteSchedule text-center" id="deleteSchedule-'+value.object.id+'" value="'+value.object.id+'">Eliminar</button></td></tr>',
                        );
                    } else {
                        $('#tableBodyNextClasses').append(
                            '<tr style="font-size: 0.9em;" class="rowNextClasses" id="rowSchedule-'+value.object.id+'"><td>'+value.object.id+'</td><td>'+value.formatDay+'</td><td>'+value.formatHour+'</td><td>'+value.object.instructor.name+'</td><td><i>Sin descripción</i></td><td>'+value.object.reservation_limit+'</td><td>'+value.reservedBikes+'</td><td>'+value.availableBikes+'</td><td>'+value.object.branch.name+'</td><td class="text-center"><button class="btn btn-primary btn-sm editSchedule text-center" id="editSchedule-'+value.object.id+'" value="'+value.object.id+'" data-myid="'+value.object.id+'" data-myday="'+value.object.day+'" data-myhour="'+value.object.hour+'" data-myinstructor="'+value.object.instructor_id+'"data-mydescription="'+value.object.description+'" data-myreservation="'+value.object.reservation_limit+'" data-mybranch="'+value.object.branch_id+'" data-toggle="modal" data-target="#editScheduleModal">Editar</button></td><td class="text-center"><button class="btn btn-danger btn-sm deleteSchedule text-center" id="deleteSchedule-'+value.object.id+'" value="'+value.object.id+'">Eliminar</button></td></tr>',
                        );
                    }
                });
                $('#tableNextClasses').show();
                $('#tablePreviousClasses').hide();
                $('#buttonTopAddSchedule').show();
                $('#buttonReservedBikes').show();
                $('#buttonNonReservedBikes').show();
            },
            error: function(result){
                $.LoadingOverlay('hide'),
                Swal.fire({
                    title: 'Error',
                    text: 'Ha ocuriddo un error al procesar la solicitud',
                    // text: result.message,
                    type: 'error',
                    confirmButtonText: 'Aceptar'
                })
            }
        });
    }

    function getPreviousClasses(){
        $.ajax({
            url: "getPreviousClasses",
            method: 'GET',
            beforeSend: function(){
                $.LoadingOverlay('show');
            },
            success: function(result){
                $.LoadingOverlay('hide');
                $('#tableBodyPreviousClasses').empty();
                $.each(result, function(index, value){
                    if(value.object.description != null){
                        $('#tableBodyPreviousClasses').append(
                        '<tr style="font-size: 0.9em;" class="rowPreviousClasses"><td>'+value.object.id+'</td><td>'+value.formatDay+'</td><td>'+value.formatHour+'</td><td>'+value.object.instructor.name+'</td><td>'+value.object.description+'</td><td>'+value.object.reservation_limit+'</td><td>'+value.reservedBikes+'</td><td>'+value.availableBikes+'</td><td>'+value.object.branch.name+'</td></tr>'
                        );
                    } else {
                        $('#tableBodyPreviousClasses').append(
                            '<tr style="font-size: 0.9em;" class="rowPreviousClasses"><td>'+value.object.id+'</td><td>'+value.formatDay+'</td><td>'+value.formatHour+'</td><td>'+value.object.instructor.name+'</td><td><i>Sin descripción</i></td><td>'+value.object.reservation_limit+'</td><td>'+value.reservedBikes+'</td><td>'+value.availableBikes+'</td><td>'+value.object.branch.name+'</td></tr>'
                        );
                    }
                });
                $('#tableNextClasses').hide();
                $('#buttonTopAddSchedule').hide();
                $('#buttonReservedBikes').hide();
                $('#buttonNonReservedBikes').hide();
                $('#tablePreviousClasses').show('fast');
            }
        });
    }

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
                            // console.log(result.status);
                            // $('.modal-backdrop').remove();
                            // $('.active-menu').trigger('click');
                            $('#buttonNextClasses').click();
                            Swal.fire({
                                title: 'Horario Eliminado',
                                text: result.message,
                                type: 'success',
                                confirmButtonText: 'Aceptar'
                            })
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
</script>