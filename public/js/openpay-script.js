//variable que crear openpay
var device_session_id = null;
//solo se crea cuando hay una respuesta success
var token_id = null;
//token de usuario autenticado
var tokenBearer = null;
//se genera solo por laravel
var product_id = null;
//variable para validar si se debe guardar la tarjeta o no
var checkbox = null;
var globalDataError = null;
//ID de la Tarjeta
var card_id = null;
$(document).ready(function() {
    OpenPay.setId(opId);
    OpenPay.setApiKey(opPublicKey);
    OpenPay.setSandboxMode(opSandbox);
    //Se genera el id de dispositivo
    device_session_id = OpenPay.deviceData.setup("payment-form", "deviceIdHiddenFieldName");

    $('#selectSavedCard').change(function(){
        console.log($('#selectSavedCard').val());
    });
});

$('#device_session_id').val(device_session_id);
//Bearer en Variable del Script

// Close Select Card Modal and Open No-Card Modal
/* $('#use-new-card-button').on('click', function(event) {
    $('#savedCardsModal').modal('hide');
    $('#newCardChargeModal').modal('show');
}); */

$('#pay-button').on('click', function(event) {
    event.preventDefault();
    $("#pay-button").prop( "disabled", true);
    OpenPay.token.extractFormAndCreate('payment-form', sucess_callbak, error_callbak);
});

/* $('#pay-selected-card-button').on('click', function(event) {
    event.preventDefault();
    $("#pay-selected-card-button").prop( "disabled", true);
    conditions = document.getElementsByClassName("buy-conditions")[0].checked;
    card_id = $('#selectSavedCard').val();
    makeChargeSavedCard();
}); */

var sucess_callbak = function(response) {
    token_id = response.data.id;
    conditions = document.getElementsByClassName('buy-customer-conditions')[0].checked;
    $('#token_id').val(token_id);
    checkbox = document.getElementById('dataCard');
    if(checkbox.checked)
    {
        saveCard();
    }
    else {
        makeCharge();

    };

    console.log("cargo realizado");
};

var sucess_callback = function(response) {
    token_id = response.data.id;
    $('#token_id').val(token_id);
    makeChargeSavedCard();
    console.log("cargo realizado");
};

var error_callbak = function(response) {
    // response.data.description != undefined ? response.data.description : response.message;
    // alert("ERROR [" + response.status + "] " + desc);
    // globalDataError = response.data;
    var errorMessage = getErrorCodeOP(response.data.error_code);
    globalDataError = response.data.error_code;
    console.log(response.data.error_code);
    Swal.fire({
        title: 'Error',
        text: errorMessage,
        type: 'error',
        confirmButtonText: 'Aceptar'
    })
    $("#pay-button").prop("disabled", false);
};

var error_callback = function(response) {
    var errorMessage = getErrorCodeOP(response.data.error_code);
    globalDataError = response.data.error_code;
    console.log(response.data.error_code);
    Swal.fire({
        title: 'Error',
        text: errorMessage,
        type: 'error',
        confirmButtonText: 'Aceptar'
    })
    $("#pay-selected-card-button").prop("disabled", false);
};

function getErrorCodeOP(errorCode){
    // if(errorCode == 2005) {
    //     return "Nel";
    // }
    switch (errorCode) {
        case 2005:
            message = "La fecha de expiraci??n de la tarjeta es anterior a la fecha actual.";
            break;
        case 2006:
            $message = "El c??digo de seguridad de la tarjeta (CVV2) no fue proporcionado.";
            break;
        case 2009:
            message = "El c??digo de seguridad de la tarjeta (CVV2) es inv??lido.";
            break;
        case 3001:
            message = "Tarjeta declinada. Contacta a tu banco e int??ntalo de nuevo.";
            break;
        case 3002:
            message = "La tarjeta ha expirado.";
            break;
        case 3003:
            message = "La tarjeta no tiene fondos suficientes.";
            break;
        case 3006:
            message = "La operaci??n no esta permitida para este cliente o esta transacci??n. Contacta a tu banco.";
            break;
        case 3007:
            message = "Tarjeta declinada. Contacta a tu banco e int??ntalo de nuevo.";
            break;
        case 3008:
            message = "La tarjeta no es soportada en transacciones en l??nea. Contacta a tu banco.";
            break;
        case 3010:
            message = "El banco ha restringido la tarjeta. Contacta a tu banco.";
            break;
        case 3012:
            message = "Se requiere solicitar al banco autorizaci??n para realizar este pago. Contacta a tu banco.";
            break;
        default:
            message = "Tarjeta no v??lida. Contacta a tu banco.";
    }
    console.log(errorCode);
    return message;
}

function saveCard(){
    tokenBearer = $('#tokenBearer').val();
    $.ajax({
        url: "/addCard",
        method: 'POST',
        data: {
            _token: crfsToken,
            token_id: token_id,
            device_session_id: device_session_id,
            customer_id: ''
        },
        beforeSend: function(){
            $.LoadingOverlay("show");
        },
        success: function(result){
            console.log(result);
        },
        complete: function() {
            makeCharge();
        }
    });
};

//Make Charge: New Card
function makeCharge(){
    tokenBearer = $('#tokenBearer').val();
    $.ajax({
        url: "/makeCharge",
        method: 'POST',
        data: {
            _token: crfsToken,
            token_id: token_id,
            device_session_id: device_session_id,
            product_id: product_id,
            conditions: conditions ? 1 : 0,
        },
        beforeSend: function(){
            $.LoadingOverlay("show");
        },
        success: function(result){
            $.LoadingOverlay("hide");
            $("#pay-button").prop( "disabled", false);
            if (result.status == "OK") {
                window.location.replace("/user");
            } else {
                $("#pay-selected-card-button").prop( "disabled", false);
                $.LoadingOverlay("hide");
                //swal error
                Swal.fire({
                    title: 'Error',
                    text: result.message,
                    type: 'error',
                    confirmButtonText: 'Aceptar'
                })
            }
        },
        error: function (result) {
            $("#pay-selected-card-button").prop( "disabled", false);
        },
        failure: function (result) {
            $("#pay-selected-card-button").prop( "disabled", false);
            //swal error de comunicaci??n
            alert("Ocurri?? un error en el pago, por favor intente de nuevo");
        }
    });
}

//Make Charge: Saved Card
function makeChargeSavedCard(){
    tokenBearer = $('#tokenBearer').val();
    $.ajax({
        url: "/makeChargeCard",
        method: 'POST',
        data: {
            _token: crfsToken,
            card_id: card_id,
            device_session_id: device_session_id,
            product_id: product_id,
            conditions: (conditions) ? 1 : 0,
        },
        beforeSend: function(){
            $.LoadingOverlay("show");
        },
        success: function(result){
            $.LoadingOverlay("hide");
            if (result.status == "OK") {
                window.location.replace("/user");
            } else {
                $("#pay-selected-card-button").prop( "disabled", false);
                $.LoadingOverlay("hide");
                //swal error
                Swal.fire({
                    title: 'Error',
                    text: result.message,
                    type: 'error',
                    confirmButtonText: 'Aceptar'
                });
            }
        },
        error: function (result) {
            $("#pay-selected-card-button").prop( "disabled", false);
        },
        failure: function (result) {
            $("#pay-selected-card-button").prop( "disabled", false);
            //swal error de comunicaci??n
            alert("Ocurri?? un error en el pago, por favor intente de nuevo");
        }
    });
}


/* $(document).on("click", ".pickClass", function(e) {
    var elementId = this.id;
    elementExploded = elementId.split("-")
    
     = elementExploded[1];
    console.log(product_id);
}) */