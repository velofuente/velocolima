@foreach($data as $row)
    <tr>
        <td>{{ $row->id}}</td>
        <td>{{ $row->name }}</td>
        <td>{{ $row->last_name }}</td>
        <td>{{ $row->email }}</td>
        <td>{{ $row->phone }}</td>
        <td><button class="btn btn-success btn-sm salesUser" id="salesUser-{{ $row->id }}" value="{{$row->id}}" data-toggle="modal" data-target="#addSaleUserModal">Venta</button></td>
    </tr>
@endforeach
{{-- <tr>
    <td colspan="6" align="center">
        {!! $data->links() !!}
    </td>
</tr> --}}

<script>
    //OnClick Sales User Button
    $('.salesUser').on('click', function(event) {
        $('#addSaleUserModal').modal('show');
        // $(this).prop("disabled", true)
        event.preventDefault();

        //Get Full ID of the button (which contains the instructor ID)
        var fullId = this.id;
        //Split the ID of the fullId by his dash
        var splitedId = fullId.split("-");
        if(splitedId.length > 1){
            // console.log(splitedId);
            var userId = splitedId[1];
            client_id = userId;
        } else {
            $(this).prop("disabled", false)
            console.log("Malformed ID")
        }
    });
</script>