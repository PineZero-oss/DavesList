
//do not touch IM TELLING YOU NOW FROM THE PAST DAVE
const form = document.getElementById('signupForm');
const usernameInput = document.getElementById('userName-input');
const emailInput = document.getElementById('uEmail-input');
const passwordInput = document.getElementById('uPassword-input');
const repeatPasswordInput = document.getElementById('uRepeatPassword-input');
const errorMessage = document.getElementById('error-message');

form.addEventListener('submit', (e) =>{

    let errors = [];

function getSignupErrors(usernameInput, emailInput, passwordInput, repeatPasswordInput){ 
let errors = [];

if(usernameInput.value === '' || usernameInput.value == null){
errors.push('username is required');
usernameInput.parentElement.classList.add('incorrect');
}


if(emailInput.value === '' || emailInput.value == null){
errors.push('email is required');
emailInput.parentElement.classList.add('incorrect');
}

if(passwordInput.value === '' || passwordInput.value == null){
errors.push('password is required');
passwordInput.parentElement.classList.add('incorrect');
}

if(repeatPasswordInput.value === '' || repeatPasswordInput.value == null){
errors.push('please confirm your password');
repeatPasswordInput.parentElement.classList.add('incorrect');
}

if(passwordInput.value.length < 8){
errors.push('password must be at least 8 characters long');
passwordInput.parentElement.classList.add('incorrect');
}

if(!/\d/.test(passwordInput.value)){
errors.push('password must contain at least one number');
passwordInput.parentElement.classList.add('incorrect');
}

if(!/[A-Z]/.test(passwordInput.value)){
errors.push('password must contain at least one uppercase letter');
passwordInput.parentElement.classList.add('incorrect');
}

if(!/[a-z]/.test(passwordInput.value)){
errors.push('password must contain at least one lowercase letter');
passwordInput.parentElement.classList.add('incorrect');
}

if(passwordInput.value !== repeatPasswordInput.value){
errors.push('passwords do not match');
passwordInput.parentElement.classList.add('incorrect');
repeatPasswordInput.parentElement.classList.add('incorrect');
}

return errors;

}


//function to handle errors on the login page
function getLoginErrors(emailInput, passwordInput){

let errors = [];

if(emailInput.value === '' || emailInput.value == null){
errors.push('email must be filled out');
emailInput.parentElement.classList.add('incorrect');
}

if(passwordInput.value === '' || passwordInput.value == null){
errors.push('password must be filled out');
passwordInput.parentElement.classList.add('incorrect');
}   

return errors;
}



//if we have a username input, then we are on the signup page, otherwise we are on the login page
if(usernameInput){

    errors = getSignupErrors(usernameInput, emailInput, passwordInput, repeatPasswordInput);
}
else{

    errors = getLoginErrors(emailInput, passwordInput);

}
//if we have any errors, prevent the form from submitting and display the errors to the user
if(errors.length > 0){
    e.preventDefault();
    errorMessage.innerText = errors.join(". ");
}


})