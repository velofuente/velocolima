function drawMainBikes(x,y){
    var bikesContainer = $("#bikes-div");

    var number_of_rows = x;
    var number_of_cols = y;
    // var tbody = $("<tbody>").attr("id", "bodyTableBicis");
    // var firstChar = "a";

    // console.log( disabledBikes );
    // console.log( instructorBikes );

    //Run into the DisabledBikes to obtain only the numbers
    // for (var index = 0; index < disabledBikes.length; index++) {
    //     console.log(Object.values(disabledBikes[index]));
    // }
    // function prueba(){
    //     if($.inArray("1", disabledBikes) != -1){
    //         return "encontrado";
    //     } else{
    //         return "pues no";
    //     }
    // }
    // console.log("tipo:" + typeof Array.from(disabledBikes));
    var count = 1;
    var bikeNum = 1;
    for (var i = 0; i < number_of_rows; i++){
        // var trow = $("<tr>").attr("id", firstChar);
        var divr = $("<div>").attr("id", "divr" + i).attr("class", "col-md-12");
        for (var j = 0; j < number_of_cols; j++){
            var classes = "bikes";
            if(selectedBike == count){
                classes = "selected";
                var ball = $("<span>").attr("class", classes).attr("id", "ball-" + count).text(bikeNum);
                divr.append(ball);
                bikeNum++;
            } else {
                if($.inArray(count.toString(), JSON.parse(reservedPlaces)) != -1){
                    classes = "occupied";
                    var ball = $("<span>").attr("class", classes).attr("id", "ball-" + count).text(bikeNum);
                    divr.append(ball);
                    bikeNum++;
                } else if($.inArray(count.toString(), JSON.parse(disabledBikes)) != -1){
                    // Marca que el Occupied pertenece al array de DisabledBikes y no al ReservedPlaces
                    classes = "disabled";
                    var ball = $("<span>").attr("class", classes);
                    divr.append(ball);
                } else if($.inArray(count.toString(), JSON.parse(instructorBikes)) != -1){
                    classes = "instructor";
                    var ball = $("<span>").attr("class", classes).text("I");
                    divr.append(ball);
                } else{
                    var ball = $("<span>").attr("class", classes).attr("id", "ball-" + count).text(bikeNum);
                    divr.append(ball);
                    bikeNum++;
                }
            }
           
            count++;
            // var td = $("<td>").attr("id", firstChar + "" + j);
            // var bicycle = $("<p>").attr("class", "bikes").text(firstChar + "" + j);
            // td.append(bicycle);
            // trow.append(td);
            // console.log(j);
        }
        // console.log(i);
        bikesContainer.append(divr);
        // firstChar = nextChar(firstChar);
        // tbody.append(trow);
    }
    // console.log('ReservedPlaces: ' + reservedPlaces);
    // console.log('DisabledBikes: ' + disabledBikes);
    // console.log('InstructorBikes: ' + instructorBikes);
}

function tableCreate(){
    var table = $("<table>").attr("id", "tableBicis").attr("class", "table");
    var number_of_rows = 8;
    var number_of_cols = 8;
    var tbody = $("<tbody>").attr("id", "bodyTableBicis");
    var firstChar = "a";
    for (var i = 0; i < number_of_rows; i++){
        var trow = $("<tr>").attr("id", firstChar);
        for (var j = 0; j < number_of_cols; j++){
            var td = $("<td>").attr("id", firstChar + "" + j);
            var bicycle = $("<p>").attr("class", "bikes").text(firstChar + "" + j);
            td.append(bicycle);
            trow.append(td);
        }
        firstChar = nextChar(firstChar);
        tbody.append(trow);

    }

    function nextChar(c) {
        return String.fromCharCode(c.charCodeAt(0) + 1);
    }



    table.append(tbody);
    $("#dinamicTable").append(table);
    // for(var i = 0; i < 3; i++){
    //     var tr = tbl.insertRow();
    //     for(var j = 0; j < 2; j++){
    //         if(i == 2 && j == 1){
    //             break;
    //         } else {
    //             var td = tr.insertCell();
    //             td.appendChild(document.createTextNode('Cell'));
    //             td.style.border = '1px solid transparent';
    //             if(i == 1 && j == 1){
    //                 td.setAttribute('rowSpan', '2');
    //                 td.id = 12;
    //             }
    //         }
    //     }
    // }
    // body.appendChild(tbl);
}
// tableCreate();

//IMPORTANTE
drawMainBikes(x,y);



// var bikes = $('.bikes');
var selected;
$(document).on("click", ".bikes", function(e) {
    e.preventDefault();
    console.log(this.id);
// })
// bikes.click(function(e) {
    if ($(this).hasClass('bikes')) {
        var fullId = this.id;
        var splitedId = fullId.split("-");
        var ballId = splitedId[1];


        // selected = $('.selected');
        // selected.removeClass('selected');
        // selected.addClass('bikes');
        // $(this).removeClass('bikes');
        // $(this).addClass('selected');
        // $('#placeNum').html($(this).text());
        reservePlace(ballId, $(this), instructor);
        // location.href='#packages';
    } else {
        $(this).removeClass('selected');
        $(this).addClass('bikes');
        // $('#placeNum').html('--');
    }
});

document.getElementById('date').innerHTML = document.getElementById('date').innerHTML.toLocaleUpperCase();

document.getElementById('branch').innerHTML = document.getElementById('branch').innerHTML.toLocaleUpperCase();

$('#profilePic').click(function(){
    document.location.href = "/instructors";
});
//TODO: modificar la variable hours
function reservePlace(id, elementBall, instructor){
    console.log(instructor);
    var today = new Date();
    var hh = today.getHours();
    var mm = today.getMinutes();
    var ss = today.getSeconds()
    today = hh + ":" + mm + ":" + ss;
    console.log(today);
    console.log(scheduleHour);
    console.log(scheduleHourBeforeCancelation);
    if(today<scheduleHourBeforeCancelation){
        console.log("a tiempo");
            Swal.fire({
                title: "Tu reserva ",
                html: "<h6>" + document.getElementById('branch').textContent + "</h6>"  +
                    "<h6>CON: " + instructor + " </h6>" +
                    "<h6>BICI: " + id + " </h6>" +
                    "<h6>Esta reservación sólo puede modificarse o cancelarse hasta " + cancelation_period + " horas antes de la clase.</h6>" +
                    "<h6>Tips: </h6>" +
                    "<ul>" +
                    "<li>Se puntual, llega al menos 10 min antes de la clase.</li>" +
                    "<li>Si llegaras tarde avisanos para guardar tu lugar 15 minutos</li>" +
                    "<li>Usa ropa comoda que transpire y calcetas deportivas</li>" +
                    "</ul>",
                type: "warning",
                showCancelButton: true,
                // confirmButtonClass: "btn-danger",
                confirmButtonText: "Reservar"
                // cancelButtonText: "Cancelar",
                // closeOnConfirm: false,
                // closeOnCancel: false
              }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "/book",
                        method: 'POST',
                        data: {
                            _token: crfsToken,
                            schedule_id: $("#schedule_id").val(),
                            bike: id,
                        },
                        success: function(result){
                            if(result.status == "OK"){
                                selected = $('.selected');
                                selected.removeClass('selected');
                                selected.addClass('bikes');
                                elementBall.removeClass('bikes');
                                elementBall.addClass('selected');
                                $('#placeNum').html($(this).text());
                                // Swal.fire({
                                //     title: 'Lugar reservado',
                                //     text: result.message,
                                //     type: 'success',
                                //     confirmButtonText: 'Aceptar',
                                //   })
                                // window.location.replace("/user");
                                Swal.fire({
                                    title: 'Lugar reservado',
                                    text: result.message,
                                    type: 'success',
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'Aceptar'
                                }).then((result) => {
                                    if (result.value) {
                                    window.location.replace("/user");
                                    }
                                });
                            } else {
                                if(typeof result.updateClass != "undefined"){
                                    if (result.updateClass == 1) {
                                        $("#ball-" + id).removeClass("bikes")
                                        $("#ball-" + id).addClass("occupied")
                                    }
                                }
                                Swal.fire({
                                    title: 'Error',
                                    text: result.message,
                                    type: 'error',
                                    confirmButtonText: 'Aceptar'
                                })
                            }
                            // console.log(result);
                        }
                    });
                } else {
                  swal("Cancelado", "Clase no reservada", "info");
                }
            });
        }else{
            console.log("tarde");
                    Swal.fire({
                        title: "Tu reserva ",
                        html: "<h6>" + document.getElementById('branch').textContent + "</h6>"  +
                        "<h6>CON: " + instructor + " </h6>" +
                        "<h6>BICI: " + id + " </h6>" +
                        "<h6>Esta reservación no es cancelable, debido a que se está realizando antes de " + cancelation_period + " horas del inicio de la clase.</h6>" +
                        "<h6>Tips: </h6>" +
                        "<ul>" +
                        "<li>Se puntual, llega al menos 10 min antes de la clase.</li>" +
                        "<li>Si llegaras tarde avisanos para guardar tu lugar 15 minutos</li>" +
                        "<li>Usa ropa comoda que transpire y calcetas deportivas</li>" +
                        "</ul>",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "Reservar",
                        cancelButtonText: "Cancelar",
                        closeOnConfirm: false,
                        closeOnCancel: false
                      }).then((result) => {
                        if (result.value) {
                            $.ajax({
                                url: "/book",
                                method: 'POST',
                                data: {
                                    _token: crfsToken,
                                    schedule_id: $("#schedule_id").val(),
                                    bike: id,
                                },
                                success: function(result){
                                    if(result.status == "OK"){
                                        selected = $('.selected');
                                        selected.removeClass('selected');
                                        selected.addClass('bikes');
                                        elementBall.removeClass('bikes');
                                        elementBall.addClass('selected');
                                        $('#placeNum').html($(this).text());
                                        // Swal.fire({
                                        //     title: 'Lugar reservado',
                                        //     text: result.message,
                                        //     type: 'success',
                                        //     confirmButtonText: 'Aceptar',
                                        //   })
                                        // window.location.replace("/user");
                                        Swal.fire({
                                            title: 'Lugar reservado',
                                            text: result.message,
                                            type: 'success',
                                            confirmButtonColor: '#3085d6',
                                            confirmButtonText: 'Aceptar'
                                        }).then((result) => {
                                            if (result.value) {
                                            window.location.replace("/user");
                                            }
                                        });
                                    } else {
                                        if(typeof result.updateClass != "undefined"){
                                            if (result.updateClass == 1) {
                                                $("#ball-" + id).removeClass("bikes")
                                                $("#ball-" + id).addClass("occupied")
                                            }
                                        }
                                        Swal.fire({
                                            title: 'Error',
                                            text: result.message,
                                            type: 'error',
                                            confirmButtonText: 'Aceptar'
                                        })
                                    }
                                    // console.log(result);
                                }
                            });
                        } else {
                          swal("Cancelado", "Clase no reservada", "info");
                        }
                    });
    }
}
