
<?php  

//handle login and registration in this file

session_start();
require_once 'userDdconfig.php';



if(isset($_POST['signup'])){

    $username = $_POST['userName'];
    $email = $_POST['uEmail'];
    $password = password_hash($_POST['uPassword'], PASSWORD_DEFAULT);
    $role = $_POST['role'];


    //check if email already exists in database
    $checkUserEmail = $conn->query("SELECT * FROM users WHERE uEmail = '$email'");
    if($checkUserEmail->num_rows > 0){

        $_SESSION['login-register-error'] = 'email already exists'; //can be removed 
        $_SESSION['active-form'] = 'signup';
        header('Location: userSignup.php');
        exit();
        
        }else{
            if($conn->query("INSERT INTO users (userName, uEmail, uPassword, uRole) VALUES ('$username', '$email', '$password', '$role')")){  
                header('Location: userLogin.php');
                exit();
            } else {
                $_SESSION['login-register-error'] = 'Registration failed: ' . $conn->error;
                $_SESSION['active-form'] = 'signup';
                header('Location: userSignup.php');
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
        if(password_verify($password, $userLoginData['uPassword']) && $userLoginData['uEmail'] === $email) {

            $_SESSION['userName'] = $userLoginData['userName'];
            $_SESSION['uEmail'] = $userLoginData['uEmail'];
            $_SESSION['user_id'] = $userLoginData['id'];
            $_SESSION['role'] = $userLoginData['uRole'];
            if($_SESSION['role'] === 'admin') {
                header('Location: adminPage.php');
            } else {
                header('Location: homepage.php');
            }

            exit();
        } else {
            $_SESSION['login-register-error'] = 'invalid email or password';
            header('Location: userLogin.php');
            exit();
        }
    }

    //if login fails, set error message and redirect back to login page
    $_SESSION['login-register-error'] = 'invalid email or password';
    $_SESSION['active-form'] = 'login';
    header('Location: userLogin.php');
    exit();
}

//handle user deletion by admin
 if(isset($_POST['deleteUser'])){

    $dusername = $_POST['dusername'];
    $duserEmail = $_POST['duserEmail'];
    $user_id = $_POST['deleteUser'];
    
    $deleteUserId = "DELETE FROM users WHERE id = '$user_id' AND userName = '$dusername' AND uEmail = '$duserEmail'";
    if($conn->query($deleteUserId)){
        $_SESSION['dstatus'] = "user deleted successfully";
        header('Location: userManagement.php');
        exit();
    } else {
        $_SESSION['dstatus'] = "failed to delete user: " . $conn->error;
        header('Location: userManagement.php');
        exit();
    }


    }



?>