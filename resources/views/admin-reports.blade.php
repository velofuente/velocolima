{{-- Table with the Info --}}
<div class="row text-center mx-0 py-4">
    <h3>Reportes</h3>
    <div class="container-fluid">
        <select class="dropdown" id="ScheduleInstructor" onchange="scheduleByInstructor()">
            <option value="allDays" selected="selected">Fecha</option>
                <option value="hoy">Hoy</option>
                <option value="semana">Esta semana</option>
                <option value="mes">Este mes</option>
        </select>
    </div>
    <button class="btn btn-success btn-sm mx-4 justify-content-right" id="Imprimir">Imprimir</button>
</div>

{{-- Table  --}}
@if (count($products) > 0)
    <table class="table table-striped table-hover">
        <thead style="font-size: 1em;">
            <tr style="font-size: 1em;">
                <th scope="col">ID</th>
                <th scope="col">Cantidad de Clases</th>
                <th scope="col">Precio</th>
                <th scope="col">Descripción</th>
                <th scope="col">Vigencia</th>
                <th scope="col">Tipo</th>
                {{-- <th scope="col">Información</th> --}}
                <th scope="col">Estatus</th>
                <th scope="col" colspan="2" class="text-center">Acción</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr style="font-size: 0.9em;">
                    {{-- <th scope="row">{{$product->id}}</th> --}}
                    <td>{{$product->id}}</td>
                    <td>{{$product->n_classes}}</td>
                    <td>${{$product->price}}</td>
                    <td>{{$product->description}}</td>
                    <td>{{$product->expiration_days}} días</td>
                    {{-- <td>{{$product->type}}</td> --}}
                    @if ($product->type == 'Deals')
                        <td>Promoción</td>
                    @else
                        <td>Paquete</td>
                    @endif
                    {{-- <td>{{$product->status}}</td> --}}
                    @if ($product->status != "1")
                        <td>Deshabilitado</td>
                    @else
                        <td>Habilitado</td>
                    @endif
                    <td><button class="btn btn-primary btn-sm editProduct" id="editProduct-{{ $product->id }}" value="{{$product->id}}" data-myid="{{ $product->id }}" data-mynclasses="{{ $product->n_classes }}" data-myprice="{{ $product->price }}" data-mydescription="{{ $product->description }}" data-myexpiration="{{$product->expiration_days}}" data-mytype="{{ $product->type }}" data-mystatus="{{$product->status}}" data-toggle="modal" data-target="#editProductModal">Editar</button></td>
                    <td><button class="btn btn-danger btn-sm deleteProduct" id="deleteProduct-{{ $product->id }}" value="{{$product->id}}">Eliminar</button></td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <h2 class="text-center">No hay Productos Agregados</h2>
@endif