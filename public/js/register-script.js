function CustomValidation(){
    this.invalidities = [];
    this.validityChecks = [];
}

CustomValidation.prototype = {
    addInvalidity: function(message){
        this.invalidities.push(message);
    },

    getInvalidities: function () {
        return this.invalidities.join('. \n');
    },

    checkValidity: function(input){
        for (var i = 0; i < this.validityChecks.length; i++){
            var isInvalid = this.validityChecks[i].isInvalid(input);
            if (isInvalid){
                this.addInvalidity(this.validityChecks[i].invalidityMessage);
                this.validityChecks[i].element.classList.add('invalid');
                this.validityChecks[i].element.classList.remove('valid');
            } else{
                this.validityChecks[i].element.classList.remove('invalid');
                this.validityChecks[i].element.classList.add('valid');
            }
        }
    }
};

var nameValidityChecks = [
    {
        isInvalid: function(input){
            return input.value.length < 3;
        },
        invalidityMessage: 'Este campo debe tener al menos 3 caracteres',
        element: document.querySelector('#nameError1')
    },
    {
        isInvalid: function(input){
            var illegalCharacters = input.value.match((/[^a-zA-ZÀ-ÿ\u00f1\u00d1]/g));
            return illegalCharacters ? true : false;
        },
        invalidityMessage: 'Solamente se permiten letras y números',
        element: document.querySelector('#nameError2')
    }
]

var lastNameValidityChecks = [
    {
        isInvalid: function(input){
            return input.value.length < 3;
        },
        invalidityMessage: 'Este campo debe tener al menos 3 caracteres',
        element: document.querySelector('#lastNameError1')
    },
    {
        isInvalid: function(input){
            var illegalCharacters = input.value.match((/[^a-zA-ZÀ-ÿ\u00f1\u00d1]/g));
            return illegalCharacters ? true : false;
        },
        invalidityMessage: 'Solamente se permiten letras y números',
        element: document.querySelector('#lastNameError2')
    }
]
var passwordValidityChecks = [
    {
        isInvalid: function(input){
            return input.value.length < 7 | input.value.length > 100;
        },
        invalidityMessage: 'Este campo debe tener al menos 7 caracteres',
        element: document.querySelector('#passwordError1')
    },
    {
        isInvalid: function(input){
            return !input.value.match((/[0-9]/g))
        },
        invalidityMessage: 'Este campo debe tener al menos un número',
        element: document.querySelector('#passwordError2')
    },
    {
        isInvalid: function(input){
            return !input.value.match((/[a-z]/g))
        },
        invalidityMessage: 'Este campo debe tener al menos una letra minúscula',
        element: document.querySelector('#passwordError3')
    },
    {
        isInvalid: function(input){
            return !input.value.match((/[A-Z]/g))
        },
        invalidityMessage: 'Este campo debe tener al menos una letra mayúscula',
        element: document.querySelector('#passwordError4')
    }
]

var nameInput = document.getElementById('name');
var lastNameInput = document.getElementById('last_name');
var passwordInput = document.getElementById('password');

nameInput.CustomValidation = new CustomValidation();
nameInput.CustomValidation.validityChecks = nameValidityChecks;

lastNameInput.CustomValidation = new CustomValidation();
lastNameInput.CustomValidation.validityChecks = lastNameValidityChecks;

passwordInput.CustomValidation = new CustomValidation();
passwordInput.CustomValidation.validityChecks = passwordValidityChecks;

var inputs = document.querySelectorAll('input:not([type="submit"])');
for (var i = 0; i < inputs.length; i++){
    inputs[i].addEventListener('keyup', function(){
        this .CustomValidation.checkValidity(this);
    })
}