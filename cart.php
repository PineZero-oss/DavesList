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
  <style>
    .qty {
      width: 60px
    }
  </style>
</head>

<body>
  <div class="container py-5">
    <div class="d-flex flex-column flex-md-row align-items-start justify-content-between mb-4 gap-3">
      <div>
        <h1 class="mb-1">Cart</h1>
        <p class="text-muted mb-0">Review your selected books and continue to checkout.</p>
      </div>
      <?php if (!empty($cart)): ?>
        <span class="badge bg-primary fs-6 py-2 px-3"><?= count($cart) ?> item<?= count($cart) !== 1 ? 's' : '' ?></span>
      <?php endif; ?>
    </div>

    <?php if (empty($cart)): ?>
      <div class="card shadow-lg rounded-4 p-4 text-center border-0">
        <h2 class="h5 mb-3">Your cart is currently empty</h2>
        <p class="text-muted mb-4">Add your favorite books to the cart and they'll appear here.</p>
        <a href="homepage.php" class="btn btn-secondary btn-lg ">Continue shopping</a>
      </div>
    <?php else: ?>
      <div class="row gx-4 gy-4">
        <div class="col-12 col-xl-8">
          <div class="list-group shadow-lg rounded-4 overflow-hidden">
            <?php
            $total = 0.0;
            foreach ($cart as $book_id => $qty):
              $stmt = $conn->prepare("SELECT bookName, bookPrice, bookImage FROM addbooks WHERE book_Id = ?");
              $stmt->bind_param('i', $book_id);
              $stmt->execute();
              $res = $stmt->get_result();
              if ($row = $res->fetch_assoc()) {
                $line = $row['bookPrice'] * $qty;
                $total += $line;
                ?>
                <div class="list-group-item cart-item p-3 border-0">
                  <div class="row g-3 align-items-center">
                    <div class="col-auto">
                      <img src="<?= htmlspecialchars('uploads/' . $row['bookImage']) ?>"
                        alt="<?= htmlspecialchars($row['bookName']) ?> cover" class="cart-item-image rounded">
                    </div>
                    <div class="col">
                      <h5 class="mb-2"><?= htmlspecialchars($row['bookName']) ?></h5>
                      <div class="d-flex flex-column flex-sm-row gap-3 align-items-sm-center text-muted small mb-2">
                        <span class="fw-semibold">Unit price: R<?= number_format($row['bookPrice'], 2) ?></span>
                        <span>Quantity: <strong><?= intval($qty) ?></strong></span>
                      </div>
                      <p class="mb-0 fw-semibold">Line total: R<?= number_format($line, 2) ?></p>
                    </div>
                  </div>
                </div>
                <?php
              }
            endforeach;
            ?>
          </div>
        </div>

        <div class="col-12 col-xl-4">
          <div class="card shadow-sm rounded-4 summary-card border-0">
            <div class="card-body p-4">
              <h2 class="h5 mb-3">Order summary</h2>
              <div class="d-flex justify-content-between mb-2 text-muted">
                <span>Items</span>
                <span><?= count($cart) ?></span>
              </div>
              <div class="d-flex justify-content-between align-items-center mb-4">
                <span class="fw-semibold">Total</span>
                <span class="fs-4 fw-bold">R<?= number_format($total, 2) ?></span>
              </div>
              <a href="#" class="btn btn-primary w-100 rounded-pill mb-2">Checkout</a>
              <a href="homepage.php" class="btn btn-outline-secondary w-100 rounded-pill mb-2">Continue shopping</a>
              <form method="post" action="addToCart.php">
                <button type="submit" name="clearCart" value="1" class="btn btn-outline-danger w-100 rounded-pill">Clear
                  cart</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    <?php endif; ?>
  </div>
</body>

</html>