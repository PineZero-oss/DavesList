<?php

session_start();
require_once 'userDdconfig.php';

//Adding New Book
if (isset($_POST['addNewBook'])) {

    $user_id = $_SESSION['user_id'];
    $bookname = $_POST['bName'];
    $bookprice = $_POST['bPrice'];
    $bookimage = $_FILES['bImage']['name'];
    $bookgenre = $_POST['bCategory'];

    // Added user_id to the insert query
    $addNewProduct = $conn->query("INSERT INTO addbooks(bookName, bookPrice, bookImage, Category, user_id) VALUES ('$bookname','$bookprice','$bookimage','$bookgenre', '$user_id')");


    if ($addNewProduct) {

        move_uploaded_file($_FILES['bImage']['tmp_name'], "uploads/" . $_FILES['bImage']['name']);
        $_SESSION['status'] = "Product has been successfully added";
        header('Location: AddProduct.php');
        exit();
    } else {

        $_SESSION['status'] = "Product failed to be added";
        header('Location: AddProduct.php');
        exit();


    }

}


//Modify book data
if (isset($_POST['editBookData'])) {

    $user_id = $_SESSION['user_id'];
    $eBook_id = $_POST['ebook_id'];
    $eBookname = $_POST['bName'];
    $eBookprice = $_POST['bPrice'];
    $newBookimage = $_FILES['bImage']['name'];
    $oldBookimage = $_POST['old_image'];
    $eBookgenre = $_POST['bCategory'];

    if ($newBookimage != '') {

        $updated_files = $newBookimage;

    } else {

        $updated_files = $oldBookimage;

    }

    
    $updateBookdata = $conn->query("UPDATE addbooks SET bookName='$eBookname', bookPrice='$eBookprice', bookImage='$updated_files', Category='$eBookgenre' WHERE book_Id='$eBook_id' AND user_id='$user_id'");

    if ($updateBookdata) {

        if ($_FILES['bImage']['name'] != '') {
            move_uploaded_file($_FILES['bImage']['tmp_name'], "uploads/" . $_FILES['bImage']['name']);
            unlink("uploads/" . $oldBookimage);


        }

        $_SESSION['status'] = "Product has been successfully updated";
        header('Location: SellerDashboard.php');
        exit();
    } else {

        $_SESSION['status'] = "Product failed to be updated";
        header('Location: editProducts.php');
        exit();

    }

}



if (isset($_POST['deleteBook'])) {

    $user_id = $_SESSION['user_id'];
    $dBookid = $_POST['dBookid'];
    $dBookimage = $_POST['dBookImage'];

    // Added ownership check to the delete query
    $deleteBook = $conn->query("DELETE FROM addbooks WHERE book_Id='$dBookid' AND user_id='$user_id'");

    if ($deleteBook) {
        unlink("uploads/" . $dBookimage);
        $_SESSION['status'] = "Product has been successfully deleted";
        header('Location: SellerDashboard.php');
        exit();
    } else {

        $_SESSION['status'] = "Product failed to be deleted";
        header('Location: SellerDashboard.php');
        exit();

    }

}








?>