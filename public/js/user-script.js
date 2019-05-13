var deviceSessionId = null;
var token_id = null;
var tokenBearer = null;
var csrfToken = $('#csrfToken').val();

$(document).ready(function() {
    OpenPay.setId('mwykro9vagcgwumpqaxb');
    OpenPay.setApiKey('pk_d72eec48f13042949140a7873ee1b3c2');
    OpenPay.setSandboxMode(true);
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
        $('#add-card-form').submit();
    };

    var error_callbak = function(response) {
        var desc = response.data.description != undefined ? response.data.description : response.message;
        alert("ERROR [" + response.status + "] " + desc);
        $("#add-card-button").prop("disabled", false);
    };

    function addCard(){
        tokenBearer = $('#tokenBearer').val();
        console.log('si entro');
        $.ajax({
            url: "/api/addCard",
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${tokenBearer}`
            },
            data: {
                _token: csrfToken,
                token_id: token_id,
                device_session_id: device_session_id,
                customer_id: ''
            },
            success: function(result){
                console.log(result);
            }
        });
        console.log('token_id: ', token_id);
        console.log('device_session_id: ', device_session_id);
        console.log('Token CRSF: ', csrfToken);
        console.log('Bearer: ', tokenBearer);
    };
});