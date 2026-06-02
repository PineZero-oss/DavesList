<?php
session_start();
require_once 'userDdconfig.php';

$cart = $_SESSION['cart'] ?? [];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>Your Cart</title>
    <style> .qty { width:60px } </style>
</head>
<body>
  <div class="container py-4">
    <h1 class="mb-4">Your Cart</h1>
    <?php if (empty($cart)): ?>
      <p>Your cart is empty.</p>
      <a href="homepage.php" class="btn btn-secondary">Continue shopping</a>
    <?php else: ?>
      <table class="table">
        <thead><tr><th>Book</th><th>Price</th><th>Qty</th><th>Line total</th></tr></thead>
        <tbody>
        <?php
        $total = 0.0;
        foreach ($cart as $book_id => $qty):
            $stmt = $conn->prepare("SELECT bookName, bookPrice FROM addbooks WHERE book_Id = ?");
            $stmt->bind_param('i', $book_id);
            $stmt->execute();
            $res = $stmt->get_result();
            if ($row = $res->fetch_assoc()) {
                $line = $row['bookPrice'] * $qty;
                $total += $line;
        ?>
          <tr>
            <td><?= htmlspecialchars($row['bookName']) ?></td>
            <td>R<?= number_format($row['bookPrice'],2) ?></td>
            <td><?= intval($qty) ?></td>
            <td>R<?= number_format($line,2) ?></td>
          </tr>
        <?php
            }
        endforeach;
        ?>
        </tbody>
        <tfoot>
          <tr><th colspan="3">Total</th><th>R<?= number_format($total,2) ?></th></tr>
        </tfoot>
      </table>
      <a href="homepage.php" class="btn btn-secondary">Continue shopping</a>
      <a href="#" class="btn btn-primary">Checkout</a>
      <form method="post" action="addToCart.php" name="clearCart" class="d-inline">
       <button type="submit" class="btn btn-outline-danger">Clear Cart</button>
      </form>
      
    <?php endif; ?>
  </div>
</body>
</html>
