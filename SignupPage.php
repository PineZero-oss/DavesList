<?php
session_start();

$errors = [
    'signup' => $_SESSION['login-register-error'] ?? '',
];

$activeForm = $_SESSION['active-form'] ?? 'login';

session_unset();

function isActiveForm($formName, $activeForm){

    return $activeForm === $formName ? 'active' : '';
}


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/bootstrap.min.css" >
        <link rel="stylesheet" href="userSignin.css">
        <script src="validation.js" defer></script>
    <title>Signup</title>
</head>
<body>


<div class="Container">

<h1>Signup</h1>

<p id="error-message"></p>

<form id="signupForm" action="userLoginRegister.php" method="post"  <?= isActiveForm('signup', $activeForm) ? 'class="active"' : '' ?> >

    <div>

    <label for="userName-input"> <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000"><path d="M367-527q-47-47-47-113t47-113q47-47 113-47t113 47q47 47 47 113t-47 113q-47 47-113 47t-113-47ZM160-160v-112q0-34 17.5-62.5T224-378q62-31 126-46.5T480-440q66 0 130 15.5T736-378q29 15 46.5 43.5T800-272v112H160Z"/></svg> </label>

    
    <input type="text" name="userName" id="userName-input" placeholder="username">

    </div>

    
    <div>

    <label for="uEmail-input"> <span>@</span></label>

    <input type="email" name="uEmail" id="uEmail-input" placeholder="email">
    </div>

    <div>

    <label for="uPassword-input"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#020202"><path d="M240-80q-33 0-56.5-23.5T160-160v-400q0-33 23.5-56.5T240-640h40v-80q0-83 58.5-141.5T480-920q83 0 141.5 58.5T680-720v80h40q33 0 56.5 23.5T800-560v400q0 33-23.5 56.5T720-80H240Zm296.5-223.5Q560-327 560-360t-23.5-56.5Q513-440 480-440t-56.5 23.5Q400-393 400-360t23.5 56.5Q447-280 480-280t56.5-23.5ZM360-640h240v-80q0-50-35-85t-85-35q-50 0-85 35t-35 85v80Z"/></svg></label>
    <input type="password" name="uPassword" id="uPassword-input" placeholder="password">
    </div>

    <div>
    <label for="uRepeatPassword-input"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000"><path d="M240-80q-33 0-56.5-23.5T160-160v-400q0-33 23.5-56.5T240-640h40v-80q0-83 58.5-141.5T480-920q83 0 141.5 58.5T680-720v80h40q33 0 56.5 23.5T800-560v400q0 33-23.5 56.5T720-80H240Zm296.5-223.5Q560-327 560-360t-23.5-56.5Q513-440 480-440t-56.5 23.5Q400-393 400-360t23.5 56.5Q447-280 480-280t56.5-23.5ZM360-640h240v-80q0-50-35-85t-85-35q-50 0-85 35t-35 85v80Z"/></svg></label>
    <input  type="password" name="urepeatPassword" id="uRepeatPassword-input" placeholder="repeat password">
    </div>

    <div>
    <button type="submit" name="signup"> Sign Up </button>
    </div>

    

</form>

<p>Already have an account? <a href="LoginPage.php">Login</a></p>


</div>
    
</body>
</html>