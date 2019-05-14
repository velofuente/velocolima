//variable que crear openpay
var deviceSessionId = null;
//solo se crea cuando hay una respuesta success
var token_id = null;
//token de usuario autenticado
var tokenBearer = null;
//se genera solo por laravel
var product_id = null;

$(document).ready(function() {
    OpenPay.setId('mwykro9vagcgwumpqaxb');
    OpenPay.setApiKey('pk_d72eec48f13042949140a7873ee1b3c2');
    OpenPay.setSandboxMode(true);
    //Se genera el id de dispositivo
    device_session_id = OpenPay.deviceData.setup("payment-form", "deviceIdHiddenFieldName");
});

$('#device_session_id').val(device_session_id);
//Bearer en Variable del Script
$('#pay-button').on('click', function(event) {
    event.preventDefault();
    $("#pay-button").prop( "disabled", true);
    OpenPay.token.extractFormAndCreate('payment-form', sucess_callbak, error_callbak);
});
var sucess_callbak = function(response) {
    token_id = response.data.id;
    $('#token_id').val(token_id);
    // product_id = $('#product_id').val();
    // console.log(product_id);
    // Submit Form
    makeCharge();
    $('#payment-form').submit();

    console.log("cargo realizado");
};
var error_callbak = function(response) {
    var desc = response.data.description != undefined ? response.data.description : response.message;
    alert("ERROR [" + response.status + "] " + desc);
    $("#pay-button").prop("disabled", false);
};
//Evitar que recargue la página
$('#payment-form').on('submit', function(e){
    e.preventDefault();
});

function makeCharge(){
    tokenBearer = $('#tokenBearer').val();
    $.ajax({
        url: "/makeCharge",
        method: 'POST',
        data: {
            _token: crfsToken,
            token_id: token_id,
            device_session_id: device_session_id,
            product_id: product_id
        },
        success: function(result){
            if (result.status == "OK") {
                //swal success
                // alert(result.message);
                window.location.replace("/user");
            } else {
                //swal error
                Swal.fire({
                    title: 'Woops!',
                    text: result.message,
                    type: 'error',
                    confirmButtonText: 'Aceptar'
                })
            }
        },
        failure: function (result) {
            //swal error de comunicación
            alert("Ocurrió un error en el pago, por favor intente de nuevo");
        }
    });
    // console.log('token_id: ', token_id);
    // console.log('device_session_id: ', device_session_id);
    // console.log('Token CRSF: ', crfsToken);
    // console.log('Bearer: ', tokenBearer);
}
$(document).on("click", ".pickClass", function(e) {
    var elementId = this.id;
    elementExploded = elementId.split("-")
    product_id = elementExploded[1];
    console.log(product_id);
})

// $(document).on("click", ".places", function(e) {
//     e.preventDefault();
//     console.log(this.id);
// })