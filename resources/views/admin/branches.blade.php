@extends('admin.app')

@section('extra_styles')
@stop

@section('content')
{{-- Table with the Info --}}
<div class="row text-center mx-0 py-4">
    <h3>Sucursales</h3>
    <button class="btn btn-success btn-sm mx-4 justify-content-right" data-toggle="modal" data-target="#addBranchModal">Añadir Sucursal</button>
</div>

{{-- Table  --}}
@if (count($branches) > 0)
    <table class="table table-striped table-hover" style="margin: 0">
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
                    <td><button class="btn btn-primary btn-sm editBranch" id="editBranch-{{ $branch->id }}" value="{{$branch->id}}" data-myid="{{ $branch->id }}" data-myname="{{ $branch->name }}" data-myaddress="{{ $branch->address }}" data-mymunicipality="{{ $branch->municipality }}" data-mystate="{{$branch->state}}" data-myphone="{{ $branch->phone }}" data-myx="{{ $branch->reserv_lim_x}}" data-myy="{{ $branch->reserv_lim_y}}" data-toggle="modal" data-target="#editBranchModal">Editar</button></td>
                    <td><button class="btn btn-danger btn-sm deleteBranch" id="deleteBranch-{{ $branch->id }}" value="{{$branch->id}}">Eliminar</button></td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <h2 class="text-center">No hay Sucursales Agendados</h2>
@endif

{{-- Modal Add Schedule --}}
<div class="modal fade" id="addBranchModal" tabindex="-1" role="dialog" aria-labelledby="addBranchModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addBranchModalLabel">Añadir Sucursal</h5>
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
                            <input id="addBranchName" type="text" placeholder="Nombre" class="form-control{{ $errors->has('addBranchName') ? ' is-invalid' : '' }}" name="name" value="{{ old('addBranchName') }}" required autofocus >
                            @if ($errors->has('addBranchName'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('addBranchName') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-4 col-xs-4 col-sm-4 col-md-4 mx-auto">
                            <label for="address" class="mr-sm-2">Dirección:</label>
                            <input id="addBranchAddress" type="text" placeholder="Dirección" class="form-control{{ $errors->has('addBranchAddress') ? ' is-invalid' : '' }}" name="addBranchAddress" value="{{ old('addBranchAddress') }}" required autofocus >
                            @if ($errors->has('addBranchAddress'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('addBranchAddress') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-4 col-xs-4 col-sm-4 col-md-4">
                            <label for="municipality" class="mr-sm-2">Municipio:</label>
                            <input id="addBranchMunicipality" type="text" placeholder="Municipio" class="form-control{{ $errors->has('addBranchMunicipality') ? ' is-invalid' : '' }}" name="name" value="{{ old('addBranchMunicipality') }}" required autofocus >
                            @if ($errors->has('addBranchMunicipality'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('addBranchMunicipality') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    {{-- Branch's State, Rows & Columns --}}
                    <div class="form-group row mb-3">
                        <div class="col-3 col-xs-3 col-sm-3 col-md-3">
                            <label for="state" class="mr-sm-2">Estado:</label>
                            <input id="addBranchState" type="text" placeholder="Estado" class="form-control{{ $errors->has('addBranchState') ? ' is-invalid' : '' }}" name="name" value="{{ old('addBranchState') }}" required autofocus >
                            @if ($errors->has('addBranchState'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('addBranchState') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-3 col-xs-3 col-sm-3 col-md-3">
                            <label for="phone" class="mr-sm-2">Teléfono:</label>
                            <input id="addBranchPhone" type="number" placeholder="Teléfono" class="form-control{{ $errors->has('addBranchPhone') ? ' is-invalid' : '' }}" name="name" value="{{ old('addBranchPhone') }}" required autofocus >
                            @if ($errors->has('addBranchPhone'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('addBranchPhone') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-3 col-xs-3 col-sm-3 col-md-3">
                            <label for="rows" class="mr-sm-2">Filas:</label>
                            <input class="form-control" maxlength="2" placeholder="Filas" type="number" name="x" id="x">
                        </div>
                        <div class="col-3 col-xs-3 col-sm-3 col-md-3">
                            <label for="columns" class="mr-sm-2">Columnas:</label>
                            <input class="form-control" maxlength="2" placeholder="Columnas" type="number" name="y" id="y">
                        </div>
                    </div>
                    {{-- Show Status of Bike-Grid --}}
                    <div class="row my-4 mx-auto justify-content-center">
                        <div class="col text-center">
                            <p>Asiento Libre</p>
                            <span class="mx-auto common showBallFree">1</span>
                        </div>
                        <div class="col text-center">
                            <p>Asiento Instructor</p>
                            <span class="mx-auto showBallInstructor">1</span>
                        </div>
                        <div class="col text-center">
                            <p>Asiento Deshabilitado</p>
                            <span class="showBallDisabled">1</span>
                        </div>
                    </div>
                    {{-- Bike-Grid --}}
                    <div class="row my-4" id="main-bikes">
                        <div class="centeredDiv" id="bikes-div" style="width: 100%">
                        </div>
                    </div>
                {{-- </form> --}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success" id="addBranchButton">Añadir Sucursal</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Edit Schedule --}}
<div class="modal fade" id="editBranchModal" tabindex="-1" role="dialog" aria-labelledby="editBranchModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBranchModalLabel">Editar Sucursal</h5>
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
                            <input id="editBranchName" type="text" placeholder="Nombre" class="form-control{{ $errors->has('editBranchName') ? ' is-invalid' : '' }}" name="name" value="{{ old('editBranchName') }}" required autofocus >
                            @if ($errors->has('editBranchName'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('editBranchName') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-4 col-xs-4 col-sm-4 col-md-4 mx-auto">
                            <label for="address" class="mr-sm-2">Dirección:</label>
                            <input id="editBranchAddress" type="text" placeholder="Dirección" class="form-control{{ $errors->has('editBranchAddress') ? ' is-invalid' : '' }}" name="editBranchAddress" value="{{ old('editBranchAddress') }}" required autofocus >
                            @if ($errors->has('editBranchAddress'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('editBranchAddress') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-4 col-xs-4 col-sm-4 col-md-4">
                            <label for="municipality" class="mr-sm-2">Municipio:</label>
                            <input id="editBranchMunicipality" type="text" placeholder="Municipio" class="form-control{{ $errors->has('editBranchMunicipality') ? ' is-invalid' : '' }}" name="name" value="{{ old('editBranchMunicipality') }}" required autofocus >
                            @if ($errors->has('editBranchMunicipality'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('editBranchMunicipality') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    {{-- Branch's State, Rows & Columns --}}
                    <div class="form-group row mb-3">
                        <div class="col-3 col-xs-3 col-sm-3 col-md-3">
                            <label for="state" class="mr-sm-2">Estado:</label>
                            <input id="editBranchState" type="text" placeholder="Estado" class="form-control{{ $errors->has('editBranchState') ? ' is-invalid' : '' }}" name="name" value="{{ old('editBranchState') }}" required autofocus >
                            @if ($errors->has('editBranchState'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('editBranchState') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-3 col-xs-3 col-sm-3 col-md-3">
                            <label for="phone" class="mr-sm-2">Teléfono:</label>
                            <input id="editBranchPhone" type="number" placeholder="Teléfono" class="form-control{{ $errors->has('editBranchPhone') ? ' is-invalid' : '' }}" name="name" value="{{ old('editBranchPhone') }}" required autofocus >
                            @if ($errors->has('editBranchPhone'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('editBranchPhone') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-3 col-xs-3 col-sm-3 col-md-3">
                            <label for="rows" class="mr-sm-2">Filas:</label>
                            <input class="form-control" maxlength="2" placeholder="Filas" type="number" name="x" id="x">
                        </div>
                        <div class="col-3 col-xs-3 col-sm-3 col-md-3">
                            <label for="columns" class="mr-sm-2">Columnas:</label>
                            <input class="form-control" maxlength="2" placeholder="Columnas" type="number" name="y" id="y">
                        </div>
                    </div>
                    {{-- Show Status of Bike-Grid --}}
                    <div class="row my-4 mx-auto justify-content-center">
                        <div class="col text-center">
                            <p>Asiento Libre</p>
                            <span class="mx-auto common showBallFree">1</span>
                        </div>
                        <div class="col text-center">
                            <p>Asiento Instructor</p>
                            <span class="mx-auto showBallInstructor">1</span>
                        </div>
                        <div class="col text-center">
                            <p>Asiento Deshabilitado</p>
                            <span class="showBallDisabled">1</span>
                        </div>
                    </div>
                    {{-- Bike-Grid --}}
                    <div class="row my-4" id="main-bikes">
                        <div class="centeredDiv" id="bikes-div" style="width: 100%">
                        </div>
                    </div>
                {{-- </form> --}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success" id="editBranchButton">Editar Sucursal</button>
            </div>
        </div>
    </div>
</div>
@stop

@section('extra_scripts')
{{-- Add, Delete & Edit Schedule Scripts --}}
<script type="text/javascript">
    var crfsToken = '{{ csrf_token() }}';
</script>
<script src="{{asset('js/bike-grid-script.js')}}"></script>

<script>
// $(document).ready(function(){

    var branch_id = null;
    var name = null;
    var address = null;
    var municipality = null;
    var state = null;
    var phone = null;
    var reserv_lim_x = null;
    var reserv_lim_y = null;

    // OnClick addBranch Button
    $('#addBranchButton').on('click', function(event) {
        event.preventDefault();
        $('#addBranchButton').attr('disabled', true);
        name = $('#addBranchName').val();
        address =  $('#addBranchAddress').val();
        municipality =  $('#addBranchMunicipality').val();
        state =  $('#addBranchState').val();
        phone =  $('#addBranchPhone').val();
        reserv_lim_x =  $('#x').val();
        reserv_lim_y =  $('#y').val();
        addBranch();
    });

    //OnClick editBranch Button
    $('.editBranch').on('click', function (){
        // $(this).prop('disabled', true);
        event.preventDefault();

        //Get Full ID of the button (which contains the instructor ID)
        var fullId = this.id;
        //Split the ID of the fullId by his dash
        var splitedId = fullId.split("-");
        if(splitedId.length > 1){
            // console.log(splitedId);
            var instructorId = splitedId[1];
            // editBranch(instructorId, this);
        } else {
            $(this).prop("disabled", false)
            console.log("Malformed ID")
        }
    });
    //OnClick editBranchModal Button

    //When Modal Opened
    $('#editBranchModal').on('show.bs.modal', function (event) {
        // Button that triggered the modal
        var button = $(event.relatedTarget)
        // Extract info from data-* attributes
        branch_id = button.data('myid')
        name = button.data('myname') // Extract info from data-* attributes
        address = button.data('myaddress');
        municipality = button.data('mymunicipality');
        state = button.data('mystate');
        phone = button.data('myphone');
        reserv_lim_x = button.data('myx');
        reserv_lim_y = button.data('myy');
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-body #editBranchName').val(name);
        modal.find('.modal-body #editBranchAddress').val(address);
        modal.find('.modal-body #editBranchMunicipality').val(municipality);
        modal.find('.modal-body #editBranchState').val(state);
        modal.find('.modal-body #editBranchPhone').val(phone);
        modal.find('.modal-body #x').val(reserv_lim_x);
        modal.find('.modal-body #y').val(reserv_lim_y);
    });

    //OnClick deleteBranch Button
    $('.deleteBranch').on('click', function(event) {
        $(this).prop("disabled", true)
        event.preventDefault();

        //Get Full ID of the button (which contains the Schedule ID)
        var fullId = this.id;
        //Split the ID of the fullId by his dash
        var splitedId = fullId.split("-");
        if(splitedId.length > 1){
            // console.log(splitedId);
            var branchId = splitedId[1];
            deleteBranch(branchId, this);
        } else {
            $(this).prop("disabled", false)
            console.log("Malformed ID")
        }
        // $('#deleteBranchButton').attr('disabled', true);
    });

    function addBranch(){
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
            url: "/addBranch",
            method: 'POST',
            beforeSend: function(){
                $.LoadingOverlay('show');
            },
            data: {
                _token: crfsToken,
                name: name,
                address: address,
                municipality: municipality,
                state: state,
                phone: phone,
                reserv_lim_x: reserv_lim_x,
                reserv_lim_y: reserv_lim_y,
                disabledBikes: disabledBikes,
                instructorBikes: instructorBikes
            },
            success: function(result){
                if(result.status == "OK"){
                    $.LoadingOverlay('hide');
                    $('.modal-backdrop').remove();
                    // $('.active-menu').trigger('click');
                    $('#addBranchModal').modal('hide');
                    Swal.fire({
                        title: 'Sucursal creada con éxito',
                        text: result.message,
                        type: 'success',
                        confirmButtonText: 'Aceptar'
                    })
                    window.location.replace("/admin/branches");
                } else {
                    $.LoadingOverlay('hide');
                    Swal.fire({
                        title: 'Error',
                        text: result.message,
                        type: 'error',
                        confirmButtonText: 'Aceptar'
                    })
                    $('#addBranchButton').attr('disabled', false);
                }
            }
        });
    }

    function deleteBranch(branch_id, button){
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
                    url: '/deleteBranch',
                    type: 'POST',
                    cache: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        branch_id: branch_id,
                    },
                    success: function(result) {
                        $.LoadingOverlay("hide");
                        if (result.status == "OK") {
                            $('.modal-backdrop').remove();
                            // $('.active-menu').trigger('click');
                            Swal.fire({
                                title: 'Sucursal Eliminado',
                                text: result.message,
                                type: 'success',
                                confirmButtonText: 'Aceptar'
                            })
                            window.location.replace("/admin/branches");
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
// })
</script>
@stop