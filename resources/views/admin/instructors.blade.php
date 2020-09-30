@extends('admin.app')

@section('content')
    {{-- Table with the Info --}}
    <div class="row text-center mx-0 py-4">
        <h3>Instructores</h3>
        <button class="btn btn-success btn-sm mx-4 justify-content-right" data-toggle="modal" data-target="#addInstructorModal">Añadir Instructor</button>
    </div>

    {{-- Table  --}}
    @if (count($instructors) > 0)
        <table class="table table-striped table-hover">
            <thead style="font-size: 1em;">
                <tr style="font-size: 1em;">
                    <th scope="col">ID</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Apellido</th>
                    <th scope="col">Email</th>
                    <th scope="col">Teléfono</th>
                    <th scope="col">Fecha de nacimiento</th>
                    {{-- <th scope="col">Información</th> --}}
                    {{-- <th scope="col">Estatus</th> --}}
                    <th scope="col" colspan="2" class="text-center">Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($instructors as $instructor)
                    <tr style="font-size: 0.9em;">
                        {{-- <th scope="row">{{$instructor->id}}</th> --}}
                        <td>{{$instructor->id}}</td>
                        <td>{{$instructor->name}}</td>
                        <td>{{$instructor->last_name}}</td>
                        <td>{{$instructor->email}}</td>
                        <td>{{$instructor->phone}}</td>
                        <td>{{ date('d-M-o', strtotime($instructor->birth_date)) }}</td>
                        {{-- <td>{{$instructor->bio}}</td> --}}
                        {{-- <td>Estatus</td> --}}
                        <td><button class="btn btn-primary btn-sm editInstructor" id="editInstructor-{{ $instructor->id }}" value="{{$instructor->id}}" data-myid="{{ $instructor->id }}" data-myname="{{ $instructor->name }}" data-mylastname="{{ $instructor->last_name }}" data-myemail="{{ $instructor->email }}" data-mybirthdate="{{$instructor->birth_date}}" data-myphone="{{ $instructor->phone }}" data-mybio="{{$instructor->bio}}" data-toggle="modal" data-target="#editInstructorModal">Editar</button></td>
                        <td><button class="btn btn-danger btn-sm deleteInstructor" id="deleteInstructor-{{ $instructor->id }}" value="{{$instructor->id}}">Eliminar</button></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <h2 class="text-center">No hay instructores agregados</h2>
    @endif

    {{-- Modal Add Instructor --}}
    <div class="modal fade" id="addInstructorModal" tabindex="-1" role="dialog" aria-labelledby="addInstructorModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addInstructorModalLabel">Añadir instructor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{-- Instructor's Name --}}
                    <div class="form-group row mb-1">
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                        <div class="col-10 col-xs-10 col-sm-10 col-md-8 mx-auto">
                            <label for="name" class="mr-sm-2">Nombre:</label>
                            <input id="nameInstructor" type="text" placeholder="Nombre(s)" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus >
                            @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                    </div>

                    {{-- Instructor's Last Name --}}
                    <div class="form-group row mb-3">
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                        <div class="col-10 col-xs-10 col-sm-10 col-md-8 mx-auto">
                                <label for="last_name" class="mr-sm-2">Apellido(s):</label>
                            <input id="last_nameInstructor" placeholder="Apellido(s)" type="text" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{ old('last_name') }}" required autofocus>
                            @if ($errors->has('last_name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('last_name') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                    </div>

                    {{-- Instructor's Email --}}
                    <div class="form-group row mb-3">
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                        <div class="col-10 col-xs-10 col-sm-10 col-md-8 mx-auto">
                            <label for="email" class="mr-sm-2">E-Mail:</label>
                            <input id="emailInstructor" placeholder="E-Mail" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                    </div>

                    {{-- Instructor's Birth Date --}}
                    <div class="form-group row mb-3">
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                        <div class="col-10 col-xs-10 col-sm-10 col-md-8 mx-auto">
                            <label for="name" class="mr-sm-2">Fecha de nacimiento:</label>
                            <div class="input-group">
                                <input id="birth_dateInstructor" min="1900-01-01" max="2100-12-31" type="date" class="form-control{{ $errors->has('birth_date') ? ' is-invalid' : '' }}" name="birth_date" value="{{ old('birth_date') }}" required >
                                @if ($errors->has('birth_date'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('birth_date') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                    </div>

                    {{-- Instructor's Phone --}}
                    <div class="form-group row mb-3">
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                        <div class="col-10 col-xs-10 col-sm-10 col-md-8 mx-auto">
                            <label for="name" class="mr-sm-2">Teléfono:</label>
                            <input id="phoneInstructor" placeholder="Teléfono" type="number" min="0" minlength="10" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" value="{{ old('phone') }}" required autofocus>
                            @if ($errors->has('phone'))
                                <span class="invalid-feedback" style="display: block !important" role="alert">
                                    <strong>{{ $errors->first('phone') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                    </div>

                    {{-- Instructor's Bio --}}
                    <div class="form-group row mb-3">
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                        <div class="col-10 col-xs-10 col-sm-10 col-md-8 mx-auto">
                            <label for="bio" class="mr-sm-2">Biografía</label>
                            <textarea id="bioInstructor" placeholder="Información Extra" type="textarea" class="form-control{{ $errors->has('bioInstructor') ? ' is-invalid' : '' }}" name="bioInstructor" value="{{ old('bioInstructor') }}" required autofocus>Coach Certificado Vélo</textarea>
                            @if ($errors->has('bioInstructor'))
                                <span class="invalid-feedback" style="display: block !important" role="alert">
                                    <strong>{{ $errors->first('bioInstructor') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                    </div>

                    {{-- Image Input --}}
                    <div class="form-group row my-4">
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                        <div class="col-10 col-xs-10 col-sm-10 col-md-8 mx-auto">
                            <label for="headImage">Imagen de perfil</label><input class="mb-2" type="file" id="profileImageAdd" name="profileImageAdd" accept="image/png, image/jpeg, image/jpg">
                            <label for="headImage">Imagen de cuerpo completo</label><input type="file" id="fullBodyPhotoAdd" name="fullBodyPhotoAdd" accept="image/png, image/jpeg, image/jpg">
                            @if ($errors->has('profileImage'))
                                <span class="invalid-feedback" style="display: block !important" role="alert">
                                    <strong>{{ $errors->first('profileImage') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-success" id="addInstructorButton">Añadir instructor</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Edit Instructor --}}
    <div class="modal fade" id="editInstructorModal" tabindex="-1" role="dialog" aria-labelledby="editInstructorModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar información</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{-- Instructor's Name --}}
                    <div class="form-group row mb-3">
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                        <div class="col-10 col-xs-10 col-sm-10 col-md-8 mx-auto">
                            <label for="name" class="mr-sm-2">Nombre:</label>
                            <input id="editNameInstructor" data-mytitle="" type="text" placeholder="Nombre(s)" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus >
                            @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                    </div>

                    {{-- Instructor's Last Name --}}
                    <div class="form-group row mb-3">
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                        <div class="col-10 col-xs-10 col-sm-10 col-md-8 mx-auto">
                                <label for="last_name" class="mr-sm-2">Apellido(s):</label>
                            <input id="editLastNameInstructor" placeholder="Apellido(s)" type="text" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{ old('last_name') }}" required>
                            @if ($errors->has('last_name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('last_name') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                    </div>

                    {{-- Instructor's Email --}}
                    <div class="form-group row mb-3">
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                        <div class="col-10 col-xs-10 col-sm-10 col-md-8 mx-auto">
                            <label for="email" class="mr-sm-2">E-Mail:</label>
                            <input id="editEmailInstructor" placeholder="E-Mail" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                    </div>

                    {{-- Instructor's Birth Date --}}
                    <div class="form-group row mb-3">
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                        <div class="col-10 col-xs-10 col-sm-10 col-md-8 mx-auto">
                            <label for="name" class="mr-sm-2">Fecha de nacimiento:</label>
                            <div class="input-group">
                                <input id="editBirthDateInstructor" min="1900-01-01" max="2100-12-31" type="date" class="form-control{{ $errors->has('birth_date') ? ' is-invalid' : '' }}" name="birth_date" value="{{ old('birth_date') }}" required>
                                @if ($errors->has('birth_date'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('birth_date') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                    </div>

                    {{-- Instructor's Phone --}}
                    <div class="form-group row mb-3">
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                        <div class="col-10 col-xs-10 col-sm-10 col-md-8 mx-auto">
                            <label for="name" class="mr-sm-2">Teléfono:</label>
                            <input id="editPhoneInstructor" placeholder="Teléfono" type="number" min="0" minlength="10" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" value="{{ old('phone') }}" required>
                            @if ($errors->has('phone'))
                                <span class="invalid-feedback" style="display: block !important" role="alert">
                                    <strong>{{ $errors->first('phone') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                    </div>

                    {{-- Instructor's Bio --}}
                    <div class="form-group row mb-3">
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                        <div class="col-10 col-xs-10 col-sm-10 col-md-8 mx-auto">
                            <label for="bio" class="mr-sm-2">Biografía</label>
                            <textarea id="editBioInstructor" placeholder="Información Extra" type="textarea" class="form-control{{ $errors->has('bioInstructor') ? ' is-invalid' : '' }}" name="bioInstructor" value="{{ old('bioInstructor') }}" required></textarea>
                            @if ($errors->has('bioInstructor'))
                                <span class="invalid-feedback" style="display: block !important" role="alert">
                                    <strong>{{ $errors->first('bioInstructor') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                    </div>

                    {{-- PHOTOS --}}
                    <div class="form-group row mb-3">
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                        <div class="col-10 col-xs-10 col-sm-10 col-md-8 mx-auto">
                            <label for="name" class="mr-sm-2">Imagen de perfil:</label>
                            <input id="profileImage" placeholder="Perfil" type="file" class="form-control{{ $errors->has('profileImage') ? ' is-invalid' : '' }}" name="profileImage" value="{{ old('profileImage') }}" accept="image/png, image/jpeg, image/jpg">
                            @if ($errors->has('profileImage'))
                                <span class="invalid-feedback" style="display: block !important" role="alert">
                                    <strong>{{ $errors->first('profileImage') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                    </div>

                    <div class="form-group row mb-3">
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                        <div class="col-10 col-xs-10 col-sm-10 col-md-8 mx-auto">
                            <label for="name" class="mr-sm-2">Imagen cuerpo completo:</label>
                            <input id="fullBodyPhoto" placeholder="Cuerpo completo" type="file" class="form-control{{ $errors->has('fullBodyPhoto') ? ' is-invalid' : '' }}" name="fullBodyPhoto" value="{{ old('fullBodyPhoto') }}" accept="image/png, image/jpeg, image/jpg">
                            @if ($errors->has('fullBodyPhoto'))
                                <span class="invalid-feedback" style="display: block !important" role="alert">
                                    <strong>{{ $errors->first('fullBodyPhoto') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-success" id="editInstructorButton">Editar instructor</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extra_scripts')
    <script>
        $("#instructors").children().addClass('active');
        // Select the Phone Input.
        var phone = document.getElementById('phoneInstructor');
        var editPhone = document.getElementById('editPhoneInstructor');

        // Lock the input to only numbers.
        phone.onkeydown = function(e) {
            if(!((e.keyCode > 95 && e.keyCode < 106)
            || (e.keyCode > 47 && e.keyCode < 58)
            || e.keyCode == 8 || e.keyCode == 9)) {
                return false;
            }
        }
        editPhone.onkeydown = function(e) {
            if(!((e.keyCode > 95 && e.keyCode < 106)
            || (e.keyCode > 47 && e.keyCode < 58)
            || e.keyCode == 8 || e.keyCode == 9)) {
                return false;
            }
        }

        {{-- Add, Delete & Edit Instructors Scripts --}}
        $(document).ready(function (){
            var instructor_id = null;
            var name = null;
            var last_name = null;
            var email = null;
            var birth_date = null;
            var phone = null;
            var bio = null;

            // // Jquery UI DatePicker (Safari)
            if ( $('[type="date"]').prop('type') != 'date' ) {
                $('[type="date"]').attr('placeholder', 'yyyy-mm-dd')
                $('[type="date"]').datepicker({
                    dateFormat: 'yy/mm/dd',
                    dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa", "Do"],
                    dayNamesShort: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab", "Dom"],
                    dayNames: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo"],
                    monthNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                    monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
                    currentText: "Hoy",
                    changeMonth: true,
                    changeYear: true,
                    yearRange: '-110:+0',
                    dateFormat: 'yy-mm-dd',
                    onSelect: function(dateText, inst) {
                        $(inst).val(dateText); // Write the value in the input
                    }
                });
            }

            //OnClick addInstructor Button
            $('#addInstructorButton').on('click', function(event) {
                event.preventDefault();
                addInstructor();
                $('#addInstructorButton').attr('disabled', true);
            })

            //OnClick deleteInstructor Button
            $('.deleteInstructor').on('click', function(event) {
                $(this).prop("disabled", true)
                event.preventDefault();

                //Get Full ID of the button (which contains the instructor ID)
                var fullId = this.id;
                //Split the ID of the fullId by his dash
                var splitedId = fullId.split("-");
                if (splitedId.length > 1) {
                    // console.log(splitedId);
                    var instructorId = splitedId[1];
                    getInstructorSchedule(instructorId, this);
                    // deleteInstructor(instructorId, this);
                } else {
                    $(this).prop("disabled", false)
                    console.log("Malformed ID")
                }
                // $('#deleteInstructorButton').attr('disabled', true);
            })

            //OnClick editInstructor Button
            $('.editInstructor').on('click', function () {
                // $(this).prop('disabled', true);
                event.preventDefault();

                //Get Full ID of the button (which contains the instructor ID)
                var fullId = this.id;
                //Split the ID of the fullId by his dash
                var splitedId = fullId.split("-");
                if (splitedId.length > 1) {
                    // console.log(splitedId);
                    var instructorId = splitedId[1];
                    // editInstructor(instructorId, this);
                } else {
                    $(this).prop("disabled", false)
                    console.log("Malformed ID")
                }
            })

            //OnClick editInstructorModal Button

            //When Modal Opened
            $('#editInstructorModal').on('show.bs.modal', function (event) {
                // Button that triggered the modal
                var button = $(event.relatedTarget)
                // Extract info from data-* attributes
                instructor_id = button.data('myid')
                name = button.data('myname') // Extract info from data-* attributes
                last_name = button.data('mylastname');
                email = button.data('myemail');
                birth_date = button.data('mybirthdate');
                phone = button.data('myphone');
                bio = button.data('mybio');
                // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                var modal = $(this)
                modal.find('.modal-body #editNameInstructor').val(name)
                modal.find('.modal-body #editLastNameInstructor').val(last_name)
                modal.find('.modal-body #editEmailInstructor').val(email)
                modal.find('.modal-body #editBirthDateInstructor').val(birth_date)
                modal.find('.modal-body #editPhoneInstructor').val(phone)
                modal.find('.modal-body #editBioInstructor').val(bio)
            })

            //Edit Instructor Button Inside Modal
            $('#editInstructorButton').on('click', function(){
                $('#editInstructorButton').prop("disabled", true)
                event.preventDefault();
                name = $('#editNameInstructor').val(); // Extract info from data-* attributes
                last_name = $('#editLastNameInstructor').val();
                email = $('#editEmailInstructor').val();
                birth_date = $('#editBirthDateInstructor').val();
                phone = $('#editPhoneInstructor').val();
                bio = $('#editBioInstructor').val();
                profileImage = $('#profileImage')[0].files[0];
                fullBodyPhoto = $('#fullBodyPhoto')[0].files[0];

                editInstructor(instructor_id);
            })

            function addInstructor(){
                let formData = new FormData();
                formData.append("name", $('#nameInstructor').val());
                formData.append("last_name", $('#last_nameInstructor').val());
                formData.append("email", $('#emailInstructor').val());
                formData.append("birth_date", $('#birth_dateInstructor').val());
                formData.append("phone", $('#phoneInstructor').val());
                formData.append("bio", $('#bioInstructor').val());
                if ($('#profileImageAdd').val() != "") {
                    formData.append("profileImageAdd", $('#profileImageAdd')[0].files[0]);
                }
                if ($('#fullBodyPhotoAdd').val() != "") {
                    formData.append("fullBodyPhotoAdd", $('#fullBodyPhotoAdd')[0].files[0]);
                }
                $.ajax({
                    url: '/addInstructor',
                    type: 'POST',
                    cache: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function(result) {
                        $.LoadingOverlay("hide");
                        if(result.status == "OK"){
                            $('.modal-backdrop').remove();
                            // $('.active-menu').trigger('click');
                            $('#addInstructorModal').modal('hide');
                            // Clear the modal inputs
                            $('#nameInstructor').val('');
                            $('#last_nameInstructor').val('');
                            $('#emailInstructor').val('');
                            $('#birth_dateInstructor').val('');
                            $('#phoneInstructor').val('');
                            Swal.fire({
                                title: 'Instructor Añadido',
                                text: result.message,
                                type: 'success',
                                confirmButtonText: 'Aceptar'
                            })
                            $('#addInstructorButton').attr('disabled', false);
                            window.location.replace('/admin/instructors');
                        }
                        else {
                            $.LoadingOverlay("hide");
                            Swal.fire({
                                title: 'Error',
                                text: result.message,
                                type: 'warning',
                                confirmButtonText: 'Aceptar'
                            })
                            $('#addInstructorButton').attr('disabled', false);
                        }
                    },
                    error: function(result){
                        $.LoadingOverlay("hide");
                        Swal.fire({
                            title: 'Error',
                            text: "No se pudo procesar la solicitud.",
                            type: 'warning',
                            confirmButtonText: 'Aceptar'
                        })
                        $('#editInstructorButton').prop("disabled", false);
                    }
                });
            }

            function getInstructorSchedule(instructor_id, button){
                $.ajax({
                    url: '/getInstructorSchedule',
                    type: 'POST',
                    cache: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        instructor_id: instructor_id,
                    },
                    success: function(result){
                        if (result.status == 'OK') {
                            deleteInstructor(instructor_id, button);
                        } else {
                            $(button).prop('disabled', false);
                            Swal.fire({
                                title: 'Error',
                                text: result.message,
                                type: 'warning',
                                confirmButtonText: 'Aceptar'
                            });
                        }
                    },
                    error: function(result){
                        $(button).prop('disabled', false);
                        Swal.fire({
                            title: 'Error',
                            text: 'Ha ocurrido un error al procesar la solicitud.',
                            type: 'error',
                            confirmButtonText: 'Aceptar'
                        })
                    }
                });
            }

            function deleteInstructor(instructor_id, button){
                // instructor_id = $('#deleteInstructorButton').val();
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "¡No se podrán revertir los cambios!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, Eliminar Instructor'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: '/deleteInstructor',
                            type: 'POST',
                            cache: false,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                instructor_id: instructor_id,
                            },
                            beforeSend: function(){
                                $.LoadingOverlay('show');
                            },
                            success: function(result) {
                                $.LoadingOverlay("hide");
                                if (result.status == "OK") {
                                    $('.modal-backdrop').remove();
                                    // $('.active-menu').trigger('click');
                                    Swal.fire({
                                        title: 'Instructor Eliminado',
                                        text: result.message,
                                        type: 'success',
                                        confirmButtonText: 'Aceptar'
                                    })
                                    window.location.replace('/admin/instructors');
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
                            }
                        });
                    } else {
                        $(button).prop("disabled", false)
                    }
                })
            }

            function editInstructor(instructor_id){
                let formData = new FormData();
                formData.append("instructor_id", instructor_id);
                formData.append("name", name);
                formData.append("last_name", last_name);
                formData.append("email", email);
                formData.append("birth_date", birth_date);
                formData.append("phone", phone);
                formData.append("bio", bio);
                if ($('#profileImage').val() != "") {
                    formData.append("profileImage", profileImage);
                }
                if ($('#fullBodyPhoto').val() != "") {
                    formData.append("fullBodyPhoto", fullBodyPhoto);
                }
                $.ajax({
                    url: "/editInstructor",
                    type: 'POST',
                    cache: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    beforeSend: function(){
                        $.LoadingOverlay("show");
                    },
                    data: formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: function(result) {
                        $.LoadingOverlay("hide");
                        if (result.status == "OK") {
                            $('.modal-backdrop').remove();
                            $('#editInstructorModal').modal('hide');
                            // Clear the modal inputs
                            Swal.fire({
                                title: 'Instructor Editado',
                                text: result.message,
                                type: 'success',
                                confirmButtonText: 'Aceptar'
                            })
                            window.location.replace('/admin/instructors');
                        } else {
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
                        Swal.fire({
                            title: 'Error',
                            type: 'error',
                            text: 'Ha ocurrido un error, favor de verificar que los datos ingresados son correctos.',
                            confirmButtonText: 'Aceptar'
                        });
                        $('#editInstructorButton').prop("disabled", false);
                    }
                });
            };
        })
    </script>
@endsection
