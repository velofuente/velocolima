function setParameters() {
    OpenPay.setId('mwykro9vagcgwumpqaxb');
    OpenPay.setApiKey('pk_d72eec48f13042949140a7873ee1b3c2');
    var deviceSessionId = OpenPay.deviceData.setup("payment-form", "deviceIdHiddenFieldName");
};
// $('#pay-button').on('click', function(event) {
//     event.preventDefault();
//     $("#pay-button").prop( "disabled", true);
//     OpenPay.token.extractFormAndCreate('payment-form', success_callbak, error_callbak);
// });