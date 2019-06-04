function drawMainBikes(rows,cols){
    var bikesContainer = $("#bikes-div");

    var number_of_rows = rows;
    var number_of_cols = cols;
    var count = 1;
    for (var i = 0; i < number_of_rows; i++){
        var divr = $("<div>").attr("id", "divr" + i).attr("class", "col-md-12");
        for (var j = 0; j < number_of_cols; j++){
            var classes = "bikes common";
            var ball = $("<span>").attr("class", classes).attr("id", "ball-" + count).text(count);
            divr.append(ball);
            count++;
        }
        bikesContainer.append(divr);
    }
}

var selected;
$(document).on("click", ".common", function(e) {
    e.preventDefault();
    if ($(this).hasClass('bikes')) {
        $(this).removeClass('bikes');
        $(this).addClass('disabled');
    } else if ($(this).hasClass('disabled')) {
        $(this).removeClass('disabled');
        $(this).addClass('instructor');
    } else if($(this).hasClass('instructor')){
        $(this).removeClass('instructor');
        $(this).addClass('bikes');
    }
});

$('#x, #y').on('input', function (){
    var x = $('#x').val();
    var y = $('#y').val();
    document.getElementById('bikes-div').innerHTML = "";
    drawMainBikes(x,y);
});

function sendGrid(){
    var disabledBikes = [];
    var instructor_bike = [];
    $( ".disabled" ).each(function () {
        disabledBikes.push($(this).text());
    })
    //return disabledBikes;
    $( ".instructor" ).each(function () {
        instructor_bike.push($(this).text());
    })
    $.ajax({
        url: "addSchedule",
        method: 'POST',
        data: {
            _token: crfsToken,
            day: $('#day').val(),
            hour: $('#hour').val(),
            instructor_id: 1,
            class_id: 1,
            reserv_lim_x: $('#x').val(),
            reserv_lim_y: $('#y').val(),
            room_id: 1,
            array_disabled: disabledBikes,
            bike_instructor: instructor_bike
        },
        success: function(result){
            if(result.status == "OK"){
                Swal.fire({
                    title: 'Creado con exito',
                    text: result.message,
                    type: 'success',
                    confirmButtonText: 'Aceptar'
                  })
            } else {
                Swal.fire({
                    title: 'Woops!',
                    text: result.message,
                    type: 'error',
                    confirmButtonText: 'Aceptar'
                  })
            }
            console.log(result);
        }
    });
}