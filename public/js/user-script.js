var deviceSessionId = null;
var token_id = null;
var tokenBearer = null;
var csrfToken = $('#csrfToken').val();

$(document).ready(function() {
    // OpenPay.setId('mq3srrs4flndbb8qu1mm');
    // OpenPay.setApiKey('pk_1241cb6ad90940ca8c2970818786c8ad');
    // OpenPay.setSandboxMode(true);
    OpenPay.setId(opId);
    OpenPay.setApiKey(opPublicKey);
    OpenPay.setSandboxMode(opSandbox);
    //Se genera el id de dispositivo
    device_session_id = OpenPay.deviceData.setup("add-card-form", "deviceIdHiddenFieldName");
    $('#device_session_id').val(device_session_id);

    $('#add-card-button').on('click', function(event) {
        event.preventDefault();
        $("#add-card-button").prop( "disabled", true);
        OpenPay.token.extractFormAndCreate('add-card-form', sucess_callbak, error_callbak);
        console.log(OpenPay);
    });

    var sucess_callbak = function(response) {
        token_id = response.data.id;
        $('#token_id').val(token_id);
        addCard();
        // Submit Form
        // $('#add-card-form').submit();
    };

    // $(document).on("sumbtit", "#add-card-button", function(e) {
    //     e.preventDefault();
    //     console.log("Success");
    // })

    var error_callbak = function(response) {
        var errorMessage = getErrorCodeOP(response.data.error_code);
        console.log(errorMessage);
        Swal.fire({
            title: 'Error',
            text: errorMessage,
            type: 'error',
            confirmButtonText: 'Aceptar'
        })
        $("#add-card-button").prop("disabled", false);
    };

    function getErrorCodeOP(errorCode){
        switch (errorCode) {
            case 2005:
                message = "La fecha de expiración de la tarjeta es anterior a la fecha actual.";
                break;
            case 2006:
                $message = "El código de seguridad de la tarjeta (CVV2) no fue proporcionado.";
                break;
            case 2009:
                message = "El código de seguridad de la tarjeta (CVV2) es inválido.";
                break;
            case 3001:
                message = "Tarjeta declinada. Contacta a tu banco e inténtalo de nuevo.";
                break;
            case 3002:
                message = "La tarjeta ha expirado.";
                break;
            case 3003:
                message = "La tarjeta no tiene fondos suficientes.";
                break;
            case 3006:
                message = "La operación no esta permitida para este cliente o esta transacción. Contacta a tu banco.";
                break;
            case 3007:
                message = "Tarjeta declinada. Contacta a tu banco e inténtalo de nuevo.";
                break;
            case 3008:
                message = "La tarjeta no es soportada en transacciones en línea. Contacta a tu banco.";
                break;
            case 3010:
                message = "El banco ha restringido la tarjeta. Contacta a tu banco.";
                break;
            case 3012:
                message = "Se requiere solicitar al banco autorización para realizar este pago. Contacta a tu banco.";
                break;
            default:
                message = "Tarjeta no válida. Contacta a tu banco.";
        }
        return message;
    }

    function addCard(){
        tokenBearer = $('#tokenBearer').val();
        $.ajax({
            url: "/addCard",
            method: 'POST',
            /*headers: {
                'Authorization': `Bearer ${tokenBearer}`
            },*/
            data: {
                _token: csrfToken,
                token_id: token_id,
                device_session_id: device_session_id,
                customer_id: ''
            },
            beforeSend: function(){
                $.LoadingOverlay("show");
            },
            success: function(result){
                $.LoadingOverlay("hide");
                $("#add-card-button").prop( "disabled", false);
                if (result.status == "OK") {
                    //swal success
                    // alert(result.message);
                    window.location.replace("/user");
                } else {
                    $.LoadingOverlay("hide");
                    //swal error
                    Swal.fire({
                        title: 'Error',
                        // text: result.message,
                        text: result.message,
                        type: 'error',
                        confirmButtonText: 'Aceptar'
                    })
                }
            }
        });
        // console.log('token_id: ', token_id);
        // console.log('device_session_id: ', device_session_id);
        // console.log('Token CRSF: ', csrfToken);
        // console.log('Bearer: ', tokenBearer);
    };

    $(document).on("click", ".cancelClass", function(e) {
        e.preventDefault();
        var rawDate = $(this).val();
        var rawId = this.id;
        var explodedId = rawId.split("-");
        var explodedDate = rawDate.split("_");
        if (explodedId.length > 1) {
            var bookedClass_id = explodedId[1];
        } else {
            console.log("Malformed ID")
        }
        if (explodedDate.length > 1) {
            var classHour = explodedDate[0];
            var classDay = explodedDate[1];
        } else {
            console.log("Malformed ID")
            return;
        }
        console.log(bookedClass_id);
        cancelClass(bookedClass_id, classHour, classDay);
    });
});

function cancelClass(bookedClass_id){
    checkCancelLimit(bookedClass_id);
}

function deleteUserCard(id){
    Swal.fire({
        title: 'Eliminar tarjeta',
        text: "Seguro que deseas eliminar esta tarjeta?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, Eliminar Tarjeta'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: "deleteUserCard",
                method: 'POST',
                data: {
                    _token: csrfToken,
                    card_id: id
                },
                success: function(result) {
                    $.LoadingOverlay("hide");
                    if (result.status == "OK") {
                        Swal.fire({
                            title: 'Tarjeta Eliminada',
                            text: result.message,
                            type: 'success',
                            confirmButtonText: 'Aceptar'
                        })
                        window.location.reload();
                    } else {
                        $.LoadingOverlay("hide");
                        Swal.fire({
                            title: 'Error',
                            text: result.message,
                            type: 'warning',
                            confirmButtonText: 'Aceptar'
                        });
                        // $(button).prop("disabled", false)
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
                    // $(button).prop("disabled", false)
                    // alert(result);
                }
            });
        } else {
            // $(button).prop("disabled", false)
        }
    })
}

 function checkCancelLimit(bookedClass_id){
    $.LoadingOverlay("show");
    $.ajax({
        url: "checkCancelLimit",
        method: 'POST',
        data: {
            _token: csrfToken,
            id: bookedClass_id
        },
        success: function(result) {
            $.LoadingOverlay("hide");

            if (result.status == 'OK') {
                if (!result.is_refundable) {
                    Swal.fire({
                        title: "Cancelación de clase",
                        html: "<h6>Esta clase no es reembolsable debido a que está fuera del periodo de cancelación.</h6>",
                        type: "warning",
                        showCancelButton: true,
                        cancelButtonText: "Lo he pensado mejor y no la cancelaré",
                        confirmButtonText: "Entiendo y aún la quiero cancelar",
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#4bb543',
                        reverseButtons: true,
                    }).then((result) => {
                        if (result.value) {
                            $.ajax({
                                url: "cancelClass",
                                method: 'POST',
                                data: {
                                    _token: csrfToken,
                                    id: bookedClass_id
                                },
                                beforeSend: function(){
                                    $.LoadingOverlay("show");
                                },
                                success: function(result){
                                    $.LoadingOverlay('hide');
                                    Swal.fire({
                                        title: 'Clase cancelada',
                                        text: result.message,
                                        type: 'success',
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'Aceptar'
                                    }).then((result) => {
                                        if (result.value) {
                                        window.location.replace("/user");
                                        }
                                    })
                                }
                            });
                        } else {
                        swal("Cancelado", "Clase no cancelada.", "info");
                        }
                    });
                } else {
                    $.ajax({
                        url: "cancelClass",
                        method: 'POST',
                        data: {
                            _token: csrfToken,
                            id: bookedClass_id
                        },
                        beforeSend: function(){
                            $.LoadingOverlay("show");
                        },
                        success: function(result){
                            $.LoadingOverlay('hide');
                            Swal.fire({
                                title: 'Clase cancelada',
                                text: result.message,
                                type: 'success',
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'Aceptar'
                            }).then((result) => {
                                if (result.value) {
                                window.location.replace("/user");
                                }
                            })
                        }
                    });
                }
            } else {
                Swal.fire({
                    title: "Cancelación de clase",
                    html: "<h6>"+result.message+"</h6>",
                    type: "error",
                    showCancelButton: true,
                    cancelButtonText: "Aceptar",
                })
            }
        },
        error: function(result){
        }
    });
 }