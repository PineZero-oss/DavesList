<?php
session_start();
require_once 'userDdconfig.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: homepage.php');
    exit();
}

if (isset($_POST['clearCart'])) {
    unset($_SESSION['cart']);
    $_SESSION['cart_message'] = 'Cart cleared successfully.';
    header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? 'homepage.php'));
    exit();
}

$book_id = isset($_POST['book_id']) ? intval($_POST['book_id']) : 0;


// verify book exists
$stmt = $conn->prepare("SELECT book_Id FROM addbooks WHERE book_Id = ?");
$stmt->bind_param('i', $book_id);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows === 0) {
    $_SESSION['cart_message'] = 'Book not found.';
    header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? 'homepage.php'));
    exit();
}

if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// increment quantity
if (isset($_SESSION['cart'][$book_id])) {
    $_SESSION['cart'][$book_id]++;
} else {
    $_SESSION['cart'][$book_id] = 1;
}

$_SESSION['cart_message'] = 'Added to cart.';
header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? 'homepage.php'));
exit();

?>





 