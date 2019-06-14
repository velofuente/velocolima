{{-- Table with the Info --}}
<div class="row text-center mx-0 py-4">
    <h3>Ventas</h3>
    <button class="btn btn-success btn-sm mx-4 justify-content-right" data-toggle="modal" data-target="#addUserModal">Añadir Venta</button>
</div>

{{-- Table Products --}}
@if (count($products) > 0)
    <table class="table table-striped table-hover" style="margin-bottom: 3em">
        <thead style="font-size: 1em;">
            <tr style="font-size: 1em;">
                <th scope="col">ID</th>
                <th scope="col">Cantidad de Clases</th>
                <th scope="col">Precio</th>
                <th scope="col">Descripción</th>
                <th scope="col">Vigencia</th>
                <th scope="col">Tipo</th>
                <th scope="col">Estatus</th>
                {{-- <th scope="col">Sucursal</th> --}}
                <th scope="col" colspan="2" class="text-center">Acción</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr style="font-size: 0.9em;">
                    {{-- <th scope="row">{{$product->id}}</th> --}}
                    <td>{{$product->id}}</td>
                    <td>{{$product->n_classes}}</td>
                    <td>{{$product->price}}</td>
                    <td>{{$product->description}}</td>
                    <td>{{$product->expiration_days}}</td>
                    <td>{{$product->type}}</td>
                    <td>{{$product->status}}</td>
                    {{-- <td>{{$user->branch->name}}</td> --}}
                    <td><button class="btn btn-primary btn-sm editUser" id="editUser-{{ $product->id }}" value="{{$product->id}}"
                        data-myid="{{ $product->id }}" data-mynclasses="{{ $product->n_classes }}" data-myprice="{{ $product->price }}"
                        data-mydescription="{{$product->description}}" data-myexpirationdays="{{ $product->expiration_days }}" data-mytype="{{$product->type}}" data-toggle="modal" data-target="#editUserModal">Editar</button></td>
                    <td><button class="btn btn-danger btn-sm deleteUser" id="deleteUser-{{ $product->id }}" value="{{$product->id}}">Eliminar</button></td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <h2 class="text-center">No hay Productos Agregados</h2>
@endif

{{-- Table Users --}}
@if (count($users) > 0)
    <table class="table table-striped table-hover">
        <thead style="font-size: 1em;">
            <tr style="font-size: 1em;">
                <th scope="col">ID</th>
                <th scope="col">Nombre</th>
                <th scope="col">Apellido</th>
                <th scope="col">Correo</th>
                <th scope="col">Fecha de nacimiento</th>
                <th scope="col">Teléfono</th>
                <th scope="col">Género</th>
                {{-- <th scope="col">Sucursal</th> --}}
                <th scope="col" colspan="2" class="text-center">Acción</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr style="font-size: 0.9em;">
                    {{-- <th scope="row">{{$product->id}}</th> --}}
                    <td>{{$user->id}}</td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->last_name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->birth_date}}</td>
                    <td>{{$user->phone}}</td>
                    <td>{{$user->gender}}</td>
                    {{-- <td>{{$user->branch->name}}</td> --}}
                    <td><button class="btn btn-primary btn-sm editUser" id="editUser-{{ $user->id }}" value="{{$user->id}}" data-myid="{{ $user->id }}" data-myname="{{ $user->name }}" data-mylastname="{{ $user->last_name }}" data-myemail="{{$user->email}}" data-mybirthdate="{{ $user->birth_date }}" data-myphone="{{$user->phone}}" data-toggle="modal" data-target="#editUserModal">Editar</button></td>
                    <td><button class="btn btn-danger btn-sm deleteUser" id="deleteUser-{{ $user->id }}" value="{{$user->id}}">Eliminar</button></td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <h2 class="text-center">No hay Usuarios Agregados</h2>
@endif