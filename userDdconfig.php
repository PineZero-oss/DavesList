
<?php 

$host = 'localhost';
$users = 'root';
$database = 'users_db';
$password = '';



$conn = new mysqli($host, $users, $password, $database);


if($conn->connect_error){
    die('Connection Failed: ' . $conn->connect_error);
}


//kicking user when they refresh after deletion
if(isset($_SESSION['user_id']) && ( $_SESSION['role'] == 'buyer' || $_SESSION['role'] == 'seller')){
    $current_user_id = $_SESSION['user_id'];
    $checkUser = $conn->query("SELECT * FROM users WHERE id='$current_user_id'");
    if($checkUser->num_rows == 0) {
        session_unset();
        session_destroy();
        
        if(basename($_SERVER['PHP_SELF']) != 'userLogin.php') {
            header('Location: userLogin.php');
        }


        exit();
    }



}

 

?>