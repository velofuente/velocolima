var purchaseToValidateId = null;

function drawMainBikes(x,y){
    var bikesContainer = $("#bikes-div");
    var number_of_rows = x;
    var number_of_cols = y;
    var count = 1;
    var bikeNum = 1;
    for (var i = 0; i < number_of_rows; i++) {
        var divr = $("<div>").attr("id", "divr" + i).attr("class", "col-md-12 my-4");
        for (var j = 0; j < number_of_cols; j++) {
            var classes = "bikes";
            if (selectedBike == count) {
                classes = "selected";
                var ball = $("<span>").attr("class", classes).attr("id", "ball-" + count).text(bikeNum);
                divr.append(ball);
                bikeNum++;
            } else {
                if ($.inArray(count.toString(), JSON.parse(reservedPlaces)) != -1) {
                    classes = "occupied";
                    var ball = $("<span>").attr("class", classes).attr("id", "ball-" + count).text(bikeNum);
                    divr.append(ball);
                    bikeNum++;
                } else if ($.inArray(count.toString(), JSON.parse(disabledBikes)) != -1) {
                    // Marca que el Occupied pertenece al array de DisabledBikes y no al ReservedPlaces
/*                     classes = "disabled";
                    var ball = $("<span>").attr("class", classes).text(count);
                    divr.append(ball); */
                } else if ($.inArray(count.toString(), JSON.parse(instructorBikes)) != -1) {
                    classes = "instructor";
                    var ball = $("<span>").attr("class", classes).text("I");
                    divr.append(ball);
                } else {
                    var ball = $("<span>").attr("class", classes).attr("id", "ball-" + count).data('bike', bikeNum).text(bikeNum);
                    divr.append(ball);
                    bikeNum++;
                }
            }
            count++;
        }
        bikesContainer.append(divr);
    }
}

function tableCreate() {
    var table = $("<table>").attr("id", "tableBicis").attr("class", "table");
    var number_of_rows = 8;
    var number_of_cols = 8;
    var tbody = $("<tbody>").attr("id", "bodyTableBicis");
    var firstChar = "a";
    for (var i = 0; i < number_of_rows; i++) {
        var trow = $("<tr>").attr("id", firstChar);
        for (var j = 0; j < number_of_cols; j++) {
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
}

//IMPORTANTE
drawMainBikes(x,y);

var selected;
$(document).on("click", ".bikes", function(e) {
    e.preventDefault();
    if ($(this).hasClass('bikes')) {
        var fullId = this.id;
        var splitedId = fullId.split("-");
        var ballId = splitedId[1];
        const bikeNumber = $(this).data("bike");

        reservePlace(ballId, bikeNumber, $(this), instructor);
    } else {
        $(this).removeClass('selected');
        $(this).addClass('bikes');
    }
});

document.getElementById('date').innerHTML = document.getElementById('date').innerHTML.toLocaleUpperCase();

document.getElementById('branch').innerHTML = document.getElementById('branch').innerHTML.toLocaleUpperCase();

$('#profilePic').click(function() {
    document.location.href = "/instructors";
});

//TODO: modificar la variable hours
function reservePlace(id, bikeNumber, elementBall, instructor){
     console.log(instructor);
    // console.log(id);
    bike = id;
/*     switch (id) {
        case "2": bike = 1; break;
        case "9": bike = 2; break;
        case "13": bike = 3; break;
        case "20": bike = 4; break;
        case "26": bike = 5; break;
        case "27": bike = 6; break;
        case "28": bike = 7; break;
        case "29": bike = 8; break;
        case "30": bike = 9; break;
        case "35": bike = 10; break;
        case "36": bike = 11; break;
        case "39": bike = 12; break;
        case "40": bike = 13; break;
        case "41": bike = 14; break;
        default: bike = 14; break;
    } */

    $.ajax({
        url: "/api/validatePackageReservation",
        method: 'POST',
        data: {
            _token: crfsToken,
            schedule_id: $("#schedule_id").val(),
            bike: id,
        },
        beforeSend: function () {
            $.LoadingOverlay("show");
        },
        success: function(result){
            if (result.status == "OK") {
                //Obtener el id del paquete con el que se va a realizar la validaci??n
                if (typeof result.data != "undefined") {
                    if (typeof result.data.purchaseId != "undefined") {
                        purchaseToValidateId = result.data.purchaseId;
                        hasSelectedPlace = result.data.hasSelectedPlace;
                    }
                }
                
                $.LoadingOverlay("hide");
                if (purchaseToValidateId == null) {
                    showSwalError();
                    return;
                }
                swal.fire({
                    title: "Tu reserva ",
                    html: "<h6>" + document.getElementById('branch').textContent + "</h6>"  +
                        "<h6>CON: " + instructor + " </h6>" +
                        (hasSelectedPlace ? (`<h6>BICI: ${bikeNumber}</h6>`) : "") +
                        "<h6>" + result.message + "</h6>" +
                        // "<h6>Esta reservaci??n s??lo puede modificarse o cancelarse hasta " + cancelation_period + " horas antes de la clase.</h6>" +
                        "<h6>Tips: </h6>" +
                        "<ul>" +
                            "<li>S?? puntual, llega al menos 10 minutos antes de la clase." + (!hasSelectedPlace ? ' No hay lugares asignados.' : '') + "</li>" +
                            "<li>Tu reserva se respetar?? hasta 5 minutos despu??s del horario reservado, pasado ese tiempo, asignaremos " + (hasSelectedPlace ? 'la bici' : 'tu lugar') + " a las personas que est??n en lista de espera.</li>" +
                            "<li>Usa ropa c??moda que transpire y calcetas deportivas.</li>" +
                        "</ul>",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Reservar"
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: "/book",
                            method: 'POST',
                            data: {
                                _token: crfsToken,
                                schedule_id: $("#schedule_id").val(),
                                bike: id,
                                index_position: bikeNumber,
                                originalPurchaseId: purchaseToValidateId,
                            },
                            beforeSend: function () {
                                $.LoadingOverlay("show");
                            },
                            success: function(result) {
                                if(result.status == "OK"){
                                    selected = $('.selected');
                                    selected.removeClass('selected');
                                    selected.addClass('bikes');
                                    elementBall.removeClass('bikes');
                                    elementBall.addClass('selected');
                                    $('#placeNum').html($(this).text());
                                    $.LoadingOverlay("hide");
                                    swal.fire({
                                        title: 'Lugar reservado',
                                        text: result.message,
                                        type: 'success',
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'Aceptar'
                                    }).then((result) => {
                                        if (result.value) {
                                            $.LoadingOverlay("show");
                                            window.location.replace("/user");
                                        }
                                    });
                                } else {
                                    $.LoadingOverlay("hide");
                                    let showPurchase = true;
                                    if (typeof result.updateClass != "undefined") {
                                        if (result.updateClass == 1) {
                                            showPurchase = false;
                                            $("#ball-" + id).removeClass("bikes")
                                            $("#ball-" + id).addClass("occupied")
                                        }
                                    }
                                    showSwalError("Error", result.message, showPurchase);
                                }
                            }
                        });
                    }
                });
            } else {
                $.LoadingOverlay("hide");
                if (typeof result.data != "undefined") {
                    if (result.data.classLimit) {
                        showSwalError("Error", result.message, false);
                        return false;
                    }
                }
                showSwalError("Error", result.message, true);
            }
        },
        error: function(error){
            $.LoadingOverlay("hide");
            showSwalError();
            return;
        }
    });

    function showSwalError(title = "Error", message = "No fue posible procesar tu reservaci??n, int??ntalo de nuevo.", showBuyClasses = false) {
        if (showBuyClasses) {
            swal.fire({
                title: title,
                text: message,
                type: 'error',
                confirmButtonText: 'Comprar clases'
            }).then((result) => {
                if (result.value) {
                    $.LoadingOverlay("show");
                    window.location.replace("/schedule#packages");
                }
            });
        } else {
            swal.fire({
                title: title,
                text: message,
                type: 'error',
                confirmButtonText: 'Aceptar'
            });
        }
    }

}
