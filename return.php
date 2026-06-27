<?php
session_start();
require_once 'userDdconfig.php';

// Log return visit
$logData = "Payment ID: " . ($_GET['m_payment_id'] ?? 'unknown') . " | Status: " . ($_GET['payment_status'] ?? 'unknown');
file_put_contents('payfast_return_log.txt', date('Y-m-d H:i:s') . " - " . $logData . "\n", FILE_APPEND);

$paymentId = $_GET['m_payment_id'] ?? null;

if ($paymentId) {
    // Check payment status
    $checkQuery = "SELECT status FROM orders WHERE payment_id = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param('s', $paymentId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        if ($row['status'] == 'completed') {
            $message = "Payment successful! Your order has been placed.";
            $class = "success";
        } else {
            $message = "Payment received but not yet confirmed. Please wait...";
            $class = "info";
        }
    } else {
        $message = "Order not found.";
        $class = "warning";
    }
} else {
    $message = "Return from PayFast.";
    $class = "info";
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>Payment Status</title>
</head>
<body>
    <div class="container py-5">
        <div class="alert alert-<?= $class ?> alert-dismissible fade show" role="alert">
            <h4 class="alert-heading">Payment Status</h4>
            <p><?= $message ?></p>
            <hr>
            <a href="ViewOrders.php" class="btn btn-primary">View My Orders</a>
            <a href="homepage.php" class="btn btn-secondary">Continue Shopping</a>
        </div>
    </div>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>

