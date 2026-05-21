

<?php 

session_start();
require_once 'userDdconfig.php';


if(isset($_POST['addNewBook'])){

$bookname = $_POST['bName'];
$bookprice = $_POST['bPrice'];
$bookimage = $_FILES['bImage']['name'];
$bookgenre = $_POST['bCategory'];


 $addNewProduct = $conn->query( "INSERT INTO addbooks(bookName, bookPrice, bookImage, Category) VALUES ('$bookname','$bookprice','$bookimage','$bookgenre')");


if($addNewProduct){

move_uploaded_file($_FILES['bImage']['tmp_name'],"uploads/".$_FILES['bImage']['name'] );
$_SESSION['status'] = "Product has been successfully added";
header('Location: AddProduct.php');
exit();
}
else{

$_SESSION['status'] = "Product failed to be added";
header('Location: AddProduct.php');
exit();


}

}


?>