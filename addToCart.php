<?php
session_start();
require_once 'userDdconfig.php';

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    $_SESSION['cart_message'] = 'Please log in first.';
    header('Location: userLoginRegister.php');
    exit();
}
$cart_key = 'cart_' . $user_id;

if (isset($_POST['clearCart'])) {
    unset($_SESSION[$cart_key]);
    $_SESSION['cart_message'] = 'Cart cleared successfully.';
    header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? 'homepage.php'));
    exit();
}

$book_id = isset($_POST['book_id']) ? intval($_POST['book_id']) : 0;

if ($book_id <= 0) {
    $_SESSION['cart_message'] = 'Book not found.';
    header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? 'homepage.php'));
    exit();
}

$stmt = $conn->prepare("SELECT book_Id FROM addbooks WHERE book_Id = ?");
$stmt->bind_param('i', $book_id);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows === 0) {
    $_SESSION['cart_message'] = 'Book not found.';
    header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? 'homepage.php'));
    exit();
}

if (!isset($_SESSION[$cart_key]) || !is_array($_SESSION[$cart_key])) {
    $_SESSION[$cart_key] = [];
}

if (isset($_SESSION[$cart_key][$book_id])) {
    $_SESSION[$cart_key][$book_id]++;
} else {
    $_SESSION[$cart_key][$book_id] = 1;
}

$_SESSION['cart_message'] = 'Added to cart.';
header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? 'homepage.php'));
exit();

?>





 