
<?php 

$host = 'localhost';
$users = 'root';
$database = 'users_db';
$password = '';



$conn = new mysqli($host, $users, $password, $database);


if($conn->connect_error){
    die('Connection Failed: ' . $conn->connect_error);
}












?>