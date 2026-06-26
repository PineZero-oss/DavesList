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

$stmt = $conn->prepare("SELECT book_Id, user_id, bookName, bookPrice, bookImage FROM addbooks WHERE book_Id = ?");
$stmt->bind_param('i', $book_id);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows === 0) {
    $_SESSION['cart_message'] = 'Book not found.';
    header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? 'homepage.php'));
    exit();
}

$bookData = $res->fetch_assoc();
$seller_id = $bookData['user_id'] ?? null;
$book_name = $bookData['bookName'] ?? 'Book';
$book_price = (float)($bookData['bookPrice'] ?? 0);
$book_image = $bookData['bookImage'] ?? '';

if (!isset($_SESSION[$cart_key]) || !is_array($_SESSION[$cart_key])) {
    $_SESSION[$cart_key] = [];
}

if (isset($_SESSION[$cart_key][$book_id])) {
    $_SESSION[$cart_key][$book_id]++;
} else {
    $_SESSION[$cart_key][$book_id] = 1;
}

if ($seller_id) {
    $existingOrderStmt = $conn->prepare("SELECT id, qty FROM orders WHERE buyer_id = ? AND seller_id = ? AND book_id = ? AND status = 'Pending' ORDER BY id DESC LIMIT 1");
    $existingOrderStmt->bind_param('iii', $user_id, $seller_id, $book_id);
    $existingOrderStmt->execute();
    $existingOrderResult = $existingOrderStmt->get_result();

    if ($existingOrderResult->num_rows > 0) {
        $existingOrder = $existingOrderResult->fetch_assoc();
        $newQty = intval($existingOrder['qty']) + 1;
        $newTotal = $book_price * $newQty;

        $updateOrderStmt = $conn->prepare("UPDATE orders SET qty = ?, total = ? WHERE id = ?");
        $updateOrderStmt->bind_param('idi', $newQty, $newTotal, $existingOrder['id']);
        $updateOrderStmt->execute();
        $updateOrderStmt->close();
    } else {
        $insertOrderStmt = $conn->prepare("INSERT INTO orders (buyer_id, seller_id, book_id, book_name, book_price, qty, total, image_path, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'Pending')");
        $insertOrderStmt->bind_param('iiisddis', $user_id, $seller_id, $book_id, $book_name, $book_price, $qtyValue, $totalValue, $book_image);
        $qtyValue = 1;
        $totalValue = $book_price;
        $insertOrderStmt->execute();
        $insertOrderStmt->close();
    }

    $existingOrderStmt->close();
}

$_SESSION['cart_message'] = 'Added to cart.';
header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? 'homepage.php'));
exit();

?>





 