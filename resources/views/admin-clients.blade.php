{{-- Table with the Info --}}
<div class="row text-center mx-0 py-4">
    <h3>Clientes</h3>
</div>

{{-- Table  --}}
@if (count($clients) > 0)
    <table class="table table-striped table-hover">
        <thead style="font-size: 1em;">
            <tr style="font-size: 1em;">
                <th scope="col">ID</th>
                <th scope="col">Nombre</th>
                <th scope="col">Apellido</th>
                <th scope="col">Correo</th>
                <th scope="col">Fecha de nacimiento</th>
                <th scope="col">Teléfono</th>
                <th scope="col">Talla de Calzado</th>
                <th scope="col">Clases disponibles</th>
                <th scope="col">Clases Reservadas</th>
            </tr>
        </thead>
        <tbody id="table-clients">
            @foreach ($clients as $client)
                <tr style="font-size: 0.9em;">
                    <td>{{$client->id}}</td>
                    <td>{{$client->name}}</td>
                    <td>{{$client->last_name}}</td>
                    <td>{{$client->email}}</td>
                    <td>{{$client->birth_date}}</td>
                    <td>{{$client->phone}}</td>
                    <td>{{$client->shoe_size}}</td>
                    <td>{{($client->availableClasses->clases) ? $client->availableClasses->clases : 'N/D'}}</td>
                    <td>{{($client->bookedClasses) ? $client->bookedClasses : 'N/D'}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <h2 class="text-center">No hay Clientes Agregados</h2>
@endif