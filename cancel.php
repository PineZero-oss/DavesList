<?php
session_start();
require_once 'userDdconfig.php';

$paymentId = $_GET['m_payment_id'] ?? null;

if ($paymentId) {
    // Update order status to cancelled
    $updateQuery = "UPDATE orders SET status = 'cancelled' WHERE payment_id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param('s', $paymentId);
    $stmt->execute();
}

// Log cancellation
file_put_contents('payfast_cancel_log.txt', date('Y-m-d H:i:s') . " - Payment cancelled for " . ($paymentId ?? 'unknown') . "\n", FILE_APPEND);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>Payment Cancelled</title>
</head>
<body>
    <div class="container py-5">
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <h4 class="alert-heading">Payment Cancelled</h4>
            <p>Your payment has been cancelled. You can try again or continue shopping.</p>
            <hr>
            <a href="cart.php" class="btn btn-primary">Back to Cart</a>
            <a href="homepage.php" class="btn btn-secondary">Continue Shopping</a>
        </div>
    </div>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
