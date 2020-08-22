let createBtn = document.getElementById('add-tweet');
let roots = document.getElementById('root');
let charCount = document.querySelectorAll('.character-counter');
let tweetForm = document.getElementById('tweet-form');
let current = document.getElementById('current');


if (createBtn != null) {
    tweetForm[0].value = '';
    createBtn.disabled =true;
    let fileToUpload = document.getElementById('fileToUpload');
    createBtn.addEventListener("click", function tweet() {
        let formdata = new FormData();
        let image = document.getElementById('image_to_upload');
        let file = image.files[0];

        $.ajax({
            url: '../post/create',
            type: 'post',
            data: {body:tweetForm[0].value},
            success: function(response){
                if ( image.files.length == 0){
                    $( "#tweets" ).prepend(response);
                    tweetForm[0].value = '';
                    createBtn.disabled =true;
                    current.innerHTML = '0';
                }
            }
        });
        if (image.files.length != 0) {
            const  fileType = file['type'];
            const validImageTypes = ['image/jpg','image/gif', 'image/jpeg', 'image/png'];
            formdata.append("image", file);
            $.ajax({
                url: '../post/addImage',
                type: 'post',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (response) {
                    $("#tweets").prepend(response);
                    tweetForm[0].value = '';
                    createBtn.disabled = true;
                    current.innerHTML = '0';
                }
            });
        }
        // tweetForm.action ='../post/create';
        // tweetForm.submit();


           });


}
//characterCount
$('textarea').keyup( characterCount);
$('textarea').change( characterCount);
function characterCount(){

    var characterCount = $(this).val().length,
        current = $('#current'),
        maximum = $('#maximum'),
        tweetForm = $('#tweet-form')

    if (characterCount > 0) {
        createBtn.disabled = false;

    }

    current.text(characterCount);
    if (characterCount >= 1000) {
        current.text('Your twit is too large!', characterCount);
        createBtn.disabled = true;
        maximum.css('color', '#8f0001');
        current.css('color', '#8f0001');
        tweetForm.css('border-color', '#8f0001')
    } else {
        maximum.css('color', 'black');
        current.css('color', 'black');
        tweetForm.css('border-color', 'black')
    }
}
// sidebar function
$(document).ready(function () {

    $('#sidebarCollapse').on('click', function () {
        $('#sidebar').toggleClass('active');
    });

});


let validInputs = 0; // to count how many inputs are valid
let validation = document.getElementById('submit-button');
let registerForm = document.getElementById('register-form');
let loginForm = document.getElementById('login-form');
let validationLogin = document.getElementById('login-button');
let validationUpdate = document.getElementById('update-button');
let changePassword = document.getElementById('update-password');

function invalidFunc(invalid, input) {
    // when the input is invalid
    invalid.style.display = 'inline-block';
    input.style.boxShadow = '0px 2px #f0695a';
}

function validFunc(invalid, input) {
    // when the input is valid
    invalid.style.display = 'none';
    input.style.border = 'none';
    input.style.boxShadow = '0px 2px #ced4da';
    validInputs++;
}

function validateBio() {
    let input = document.getElementById('bio');
    let invalid = document.getElementById('invalid-bio');
    if (
        /(.){8,1000}/.test(input.value) === false) {
        invalidFunc(invalid, input); // make it invalid when regex is failed
    } else {
        validFunc(invalid, input); // make it valid when regex is fine
    }
}

function validatePassword() {
    let input = document.getElementById('pass');
    let invalid = document.getElementById('invalid-password');
    if (
        /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&_.])[A-Za-z\d@$!%*?&_.]{8,}$/.test(
            input.value
        ) === false
    ) {
        invalidFunc(invalid, input); // make it invalid when regex is failed
    } else {
        validFunc(invalid, input); // make it valid when regex is fine
    }
}

//------------------------CHANGE PASSWORD------------------------------------

function validateCurrentPassword() {
    let input = document.getElementById('curr-pass');
    let invalid = document.getElementById('invalid-curr-pass');
    if (
        /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&_.])[A-Za-z\d@$!%*?&_.]{8,}$/.test(
            input.value
        ) === false
    ) {
        invalidFunc(invalid, input); // make it invalid when regex is failed
    } else {
        validFunc(invalid, input); // make it valid when regex is fine
    }
}

//----------------------------------------------------------------------------


function validatePasswordRepeat() {
    let pass = document.getElementById('pass');
    let input = document.getElementById('pass-repeat');
    let invalid = document.getElementById('invalid-pass-repeat');
    if (input.value !== pass.value) {
        invalidFunc(invalid, input); // make it invalid when regex is failed
    } else {
        validFunc(invalid, input); // make it valid when regex is fine
    }
}

function validateEmail() {
    let input = document.getElementById('email');
    let str = input.value;
    let invalid = document.getElementById('invalid-email');
    if (
        /^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/.test(str) ===
        false
    ) {
        invalidFunc(invalid, input); // make it invalid when regex is failed
    } else {
        validFunc(invalid, input); // make it valid when regex is fine
    }
}

function validateDate() {
    let input = document.getElementById('date');
    let str = input.value;
    let invalid = document.getElementById('invalid-date');
    if (/\d{4}-\d{1,2}-\d{1,2}/.test(str) === false) {
        invalidFunc(invalid, input); // make it invalid when regex is failed
    } else {
        validFunc(invalid, input); // make it valid when regex is fine
    }
}

function validateFirstName() {
    let input = document.getElementById('firstName');
    let invalid = document.getElementById('invalid-first-name');
    const reg = /[a-zA-Z]{3,30}/g;
    if (reg.test(input.value) !== true) {
        invalidFunc(invalid, input); // make it invalid when regex is failed
    } else {
        validFunc(invalid, input); // make it valid when regex is fine
    }
}

function validateLastName() {
    let input = document.getElementById('lastName');
    let invalid = document.getElementById('invalid-last-name');
    const reg = /[a-zA-Z]{3,30}/g;
    if (reg.test(input.value) !== true) {
        invalidFunc(invalid, input); // make it invalid when regex is failed
    } else {
        validFunc(invalid, input); // make it valid when regex is fine
    }
}

function validateUsername() {
    let input = document.getElementById('username');
    let invalid = document.getElementById('invalid-username');
    const reg = /[a-zA-Z0-9]{3,15}/g;
    if (reg.test(input.value) !== true) {
        invalidFunc(invalid, input); // make it invalid when regex is failed
    } else {
        validFunc(invalid, input); // make it valid when regex is fine
    }
}

$("input").keyup(function () {
    const characterCount = $(this).val().length,
        current = $('#current'),
        maximum = $('#maximum'),
        tweetForm = $('#tweet-form');
    current.text(characterCount);
    if (characterCount >= 1000) {
        current.text('Your bio is too large!', characterCount);
        maximum.css('color', '#8f0001');
        current.css('color', '#8f0001');
    } else {
        maximum.css('color', 'black');
        current.css('color', 'black');
        tweetForm.css('border-color', 'black')
    }
});

if (changePassword != null) {
    changePassword.onclick = function () {
        validInputs = 0;
        validatePassword();
        validatePasswordRepeat();
        validateCurrentPassword();
        if (validInputs === 3) {
            let updatePass= document.getElementById('password-form');

            updatePass.action = 'inform';
            updatePass.submit();
        } else {
            let formControls = document.querySelectorAll('.password-control'); // after button is clicked validate on every change of input
            for (const formControl of formControls) {
                formControl.addEventListener('change', function (event) {
                    validatePassword();
                    validatePasswordRepeat();
                    validateCurrentPassword();
                });
            }
        }
    }
}

if (validationUpdate != null) {
    validationUpdate.onclick = function () {
        console.log("sss");
        //inform.html validation
        validInputs = 0;
        validateFirstName(); // checking all inputs
        validateEmail();
        validateLastName();
        validateUsername();
        validateDate();
        validateBio();
        if (validInputs === 6) {
            let updateForm= document.getElementById('update-form');

            updateForm.action = 'inform';
            updateForm.submit();
        } else {
            let formControls = document.querySelectorAll('.form-control'); // after button is clicked validate on every change of input
            for (const formControl of formControls) {
                formControl.addEventListener('change', function (event) {
                    validateFirstName(); // checking all inputs
                    validateEmail();
                    validateLastName();
                    validateUsername();
                    validateDate();
                    validateBio();
                });
            }
        }
    }
}

if (validationLogin != null) {// validation on login page
    validationLogin.onclick = function () {
        validInputs = 0;
        validateEmail();
        validatePassword();
        if (validInputs === 2) {
            // if all inputs are fine go to profile page
            loginForm.action = 'login';
            loginForm.submit();
        } else {
            let formControls = document.querySelectorAll('.form-control'); // after button is clicked validate on every change of input
            for (const formControl of formControls) {
                formControl.addEventListener('change', function (event) {
                    validateEmail();
                    validatePassword();
                });
            }
        }
    }
}


if (validation != null) {  // validation on register page
    validation.onclick = function () {
        //on submit button clicked
        validInputs = 0;
        validateFirstName(); // checking all inputs
        validateEmail();
        validateLastName();
        validateUsername();
        validateDate();
        validatePassword();
        validatePasswordRepeat();
        if (validInputs === 7) {
            // if all inputs are fine go to profile page
            //  window.location.href = 'home';
            registerForm.action = 'registration';
            registerForm.submit();
        } else {
            let formControls = document.querySelectorAll('.form-control'); // after button is clicked validate on every change of input
            for (const formControl of formControls) {
                formControl.addEventListener('change', function (event) {
                    validateFirstName();
                    validateEmail();
                    validateLastName();
                    validateUsername();
                    validateDate();
                    validatePassword();
                    validatePasswordRepeat();
                });
            }

        }
    }

}