{{-- Table with the Info --}}
<div class="row text-center mx-0 py-4">
    <h3 class="mr-4">Reportes</h3>
        <select class="dropdown" id="selectReport">
            <option value="hoy" selected="selected">Hoy</option>
            {{-- <option value="semana">Esta semana</option>
            <option value="mes">Este mes</option> --}}
        </select>
    {{-- <button class="btn btn-success btn-sm mx-4 justify-content-right" id="Imprimir">Imprimir</button> --}}
</div>

{{-- Table  --}}
@if (count($sales) > 0)
    <table class="table table-striped table-hover">
        <thead style="font-size: 1em;">
            <tr style="font-size: 1em;">
                <th scope="col">ID</th>
                <th scope="col">Fecha/Hora Compra</th>
                <th scope="col">Cliente</th>
                <th scope="col">Producto</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sales as $sale)
                <tr style="font-size: 0.9em;">
                    {{-- <th scope="row">{{$product->id}}</th> --}}
                    <td>{{$sale->id}}</td>
                    <td>{{$sale->purchase->created_at}}</td>
                    <td>{{$sale->purchase->client->name}} {{$sale->purchase->client->last_name}}</td>
                    <td>{{$sale->purchase->product->description}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <h2 class="text-center">Aún no se ha realizado ninguna venta</h2>
@endif