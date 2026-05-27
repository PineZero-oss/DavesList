<?php

session_start();
require_once 'userDdconfig.php';

//Adding New Book
if (isset($_POST['addNewBook'])) {

    $bookname = $_POST['bName'];
    $bookprice = $_POST['bPrice'];
    $bookimage = $_FILES['bImage']['name'];
    $bookgenre = $_POST['bCategory'];


    $addNewProduct = $conn->query("INSERT INTO addbooks(bookName, bookPrice, bookImage, Category) VALUES ('$bookname','$bookprice','$bookimage','$bookgenre')");


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

    $updateBookdata = $conn->query("UPDATE addbooks SET bookName='$eBookname', bookPrice='$eBookprice', bookImage='$updated_files', Category='$eBookgenre' WHERE book_Id='$eBook_id'");

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

    $dBookid = $_POST['dBookid'];
    $dBookimage = $_POST['dBookImage'];



    $deleteBook = $conn->query("DELETE FROM addbooks WHERE book_Id='$dBookid'");

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