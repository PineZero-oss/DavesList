
<?php  

//handle login and registration in this file

session_start();
require_once 'userDdconfig.php';

if(isset($_POST['signup'])){

    $username = $_POST['userName'];
    $email = $_POST['uEmail'];
    $password = password_hash($_POST['uPassword'], PASSWORD_DEFAULT);

    //check if email already exists in database
    $checkUserEmail = $conn->query("SELECT * FROM users WHERE uEmail = '$email'");
    if($checkUserEmail->num_rows > 0){

        $_SESSION['login-register-error'] = 'email already exists'; //can be removed 
        $_SESSION['active-form'] = 'signup';
        header('Location: SignupPage.php');
        exit();
        
        }else{
            if($conn->query("INSERT INTO users (userName, uEmail, uPassword) VALUES ('$username', '$email', '$password')")){  
                header('Location: LoginPage.php');
                exit();
            } else {
                $_SESSION['login-register-error'] = 'Registration failed: ' . $conn->error;
                $_SESSION['active-form'] = 'signup';
                header('Location: SignupPage.php');
                exit();
            }
        }

  
}


if(isset($_POST['login'])){

    $email = $_POST['uEmail'];
    $password = $_POST['uPassword'];

    $result = $conn->query("SELECT * FROM users WHERE uEmail = '$email'");

    if($result->num_rows > 0){

        $userLoginData = $result->fetch_assoc();
        //verify password used to check if it matches the hashed password in the database
        if(password_verify($password, $userLoginData['uPassword'])){

            $_SESSION['userName'] = $userLoginData['userName'];
            $_SESSION['uEmail'] = $userLoginData['uEmail'];
            header('Location: HomePage.php');
            exit();
        } else {
            $_SESSION['login-register-error'] = 'invalid email or password';
            $_SESSION['active-form'] = 'login';
            header('Location: LoginPage.php');
            exit();
        }


    }

    //if login fails, set error message and redirect back to login page
    $_SESSION['login-register-error'] = 'invalid email or password';
    $_SESSION['active-form'] = 'login';
    header('Location: LoginPage.php');
    exit();
    
}

?>