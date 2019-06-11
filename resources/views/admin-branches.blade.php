{{-- Table with the Info --}}
<div class="row text-center mx-0 py-4">
    <h3>Sucursales</h3>
    <button class="btn btn-success btn-sm mx-4 justify-content-right" data-toggle="modal" data-target="#addScheduleModal">Añadir Sucursal</button>
</div>

{{-- Table  --}}
@if (count($branches) > 0)
    <table class="table table-striped table-hover">
        <thead style="font-size: 1em;">
            <tr style="font-size: 1em;">
                <th scope="col">ID</th>
                <th scope="col">Nombre</th>
                <th scope="col">Dirección</th>
                <th scope="col">Municipio</th>
                <th scope="col">Estado</th>
                <th scope="col">Teléfono</th>
                <th scope="col" colspan="2" class="text-center">Acción</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($branches as $branch)
                <tr style="font-size: 0.9em;">
                    {{-- <th scope="row">{{$branch->id}}</th> --}}
                    <td>{{$branch->id}}</td>
                    <td>{{$branch->name }}</td>
                    <td>{{$branch->address }}</td>
                    <td>{{$branch->municipality}}</td>
                    <td>{{$branch->state}}</td>
                    <td>{{$branch->phone}}</td>
                    <td><button class="btn btn-primary btn-sm editSchedule" id="editSchedule-{{ $branch->id }}" value="{{$branch->id}}" data-toggle="modal" data-target="#editScheduleModal">Editar</button></td>
                    <td><button class="btn btn-danger btn-sm deleteSchedule" id="deleteSchedule-{{ $branch->id }}" value="{{$branch->id}}">Eliminar</button></td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <h2 class="text-center">No hay Sucursales Agendados</h2>
@endif

{{-- Modal Add Schedule --}}
<div class="modal fade" id="addScheduleModal" tabindex="-1" role="dialog" aria-labelledby="addScheduleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addScheduleModalLabel">Añadir Sucursal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- <form method="POST" action="{{ route('addSchedule') }}" class="registration"> --}}
                    @csrf
                    {{-- Branch's Name, Address & Municipality --}}
                    <div class="form-group row mb-3">
                        <div class="col-4 col-xs-4 col-sm-4 col-md-4">
                            <label for="name" class="mr-sm-2">Nombre:</label>
                            <input id="nameBranch" type="text" placeholder="Nombre" class="form-control{{ $errors->has('nameBranch') ? ' is-invalid' : '' }}" name="name" value="{{ old('nameBranch') }}" required autofocus >
                            @if ($errors->has('nameBranch'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('nameBranch') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-4 col-xs-4 col-sm-4 col-md-4 mx-auto">
                            <label for="address" class="mr-sm-2">Dirección:</label>
                            <input id="addressBranch" type="text" placeholder="Dirección" class="form-control{{ $errors->has('addressBranch') ? ' is-invalid' : '' }}" name="addressBranch" value="{{ old('addressBranch') }}" required autofocus >
                            @if ($errors->has('addressBranch'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('addressBranch') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-4 col-xs-4 col-sm-4 col-md-4">
                            <label for="municipality" class="mr-sm-2">Municipio:</label>
                            <input id="municipalitySchedule" type="text" placeholder="Municipio" class="form-control{{ $errors->has('municipalitySchedule') ? ' is-invalid' : '' }}" name="name" value="{{ old('municipalitySchedule') }}" required autofocus >
                            @if ($errors->has('municipalitySchedule'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('municipalitySchedule') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    {{-- Bike-Grid Modal --}}
                    <div class="form-group row mb-3">
                        <div class="col-4 col-xs-4 col-sm-4 col-md-4">
                            <label for="state" class="mr-sm-2">Estado:</label>
                            <input id="stateBranch" type="text" placeholder="Estado" class="form-control{{ $errors->has('nameBranch') ? ' is-invalid' : '' }}" name="name" value="{{ old('nameBranch') }}" required autofocus >
                            @if ($errors->has('nameBranch'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('nameBranch') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-4 col-xs-4 col-sm-4 col-md-4">
                            <label for="rows" class="mr-sm-2">Filas:</label>
                            <input class="form-control" maxlength="2" placeholder="Filas" type="number" name="x" id="x">
                        </div>
                        <div class="col-4 col-xs-4 col-sm-4 col-md-4">
                            <label for="columns" class="mr-sm-2">Columnas:</label>
                            <input class="form-control" maxlength="2" placeholder="Columnas" type="number" name="y" id="y">
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
                    <div class="row my-4" id="main-bikes">
                        <div class="centeredDiv" id="bikes-div">
                        </div>
                    </div>
                {{-- </form> --}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success" id="addScheduleButton">Añadir Sucursal</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Edit Schedule --}}
<div class="modal fade" id="editScheduleModal" tabindex="-1" role="dialog" aria-labelledby="editScheduleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Información</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- <form method="POST" action="{{ route('addInstructor') }}" class="registration"> --}}
                    @csrf
                    {{-- Instructor's Name --}}
                    <div class="form-group row mb-3">
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                        <div class="col-10 col-xs-10 col-sm-10 col-md-8 mx-auto">
                            <label for="name" class="mr-sm-2">Nombre:</label>
                            <input id="editInstructor" data-mytitle="" type="text" placeholder="Nombre(s)" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus >
                            @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                    </div>
                {{-- </form> --}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success" id="editInstructorButton">Editar Instructor</button>
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

    var day = null;
    var hour = null;
    var instructor_id = null;
    var reserv_lim_x = null;
    var reserv_lim_y = null;
    var disabledBikes = null;
    var instructorBikes = null;

    $('#addScheduleButton').on('click', function(event) {
        // event.preventDefault();
        $('#addScheduleButton').attr('disabled', true);
        addSchedule();
        var day = $('#day').val();
        var hour =  $('#hour').val();
        var instructor_id =  $('#instructorInput').val();
        var reserv_lim_x =  $('#x').val();
        var reserv_lim_y =  $('#y').val();
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
        console.log(day);
        console.log(hour);
        console.log(instructor_id);
        console.log(reserv_lim_x);
        console.log(reserv_lim_y);Prueba
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
            confirmButtonText: 'Sí, Eliminar Sucursal'
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
                                title: 'Sucursal Eliminado',
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