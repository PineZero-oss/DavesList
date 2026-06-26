<?php
session_start();
require_once 'userDdconfig.php';

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    header('Location: userLoginRegister.php');
    exit();
}



if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accept_order'])) {
    $order_id = (int) $_POST['accept_order'];
    $acceptStmt = $conn->prepare("UPDATE orders SET status = 'Accepted' WHERE id = ? AND seller_id = ?");
    $acceptStmt->bind_param('ii', $order_id, $user_id);
    $acceptStmt->execute();
    $acceptStmt->close();
    $successMessage = 'Order accepted successfully.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancelled_order'])) {
    $order_id = (int) $_POST['cancelled_order'];
    $cancelStmt = $conn->prepare("UPDATE orders SET status = 'Cancelled' WHERE id = ? AND seller_id = ?");
    $cancelStmt->bind_param('ii', $order_id, $user_id);
    $cancelStmt->execute();
    $cancelStmt->close();
    $successMessage = 'Order cancelled successfully.';
}

$ordersStmt = $conn->prepare("SELECT id, buyer_id, book_id, book_name, book_price, qty, total, image_path, status, created_at FROM orders WHERE seller_id = ? ORDER BY created_at DESC");
$ordersStmt->bind_param('i', $user_id);
$ordersStmt->execute();
$ordersResult = $ordersStmt->get_result();

$orders = [];
while ($row = $ordersResult->fetch_assoc()) {
    $orders[] = [
        'id' => (int) $row['id'],
        'name' => $row['book_name'],
        'price' => (float) $row['book_price'],
        'qty' => (int) $row['qty'],
        'total' => (float) $row['total'],
        'image' => !empty($row['image_path']) ? 'uploads/' . $row['image_path'] : '',
        'status' => $row['status'],
        'date' => date('Y-m-d', strtotime($row['created_at'])),
        'buyer_id' => (int) $row['buyer_id']
    ];
}
$ordersStmt->close();

$hasOrder = !empty($orders);
$totalItems = 0;
$totalSpent = 0.0;
$pendingCount = 0;
$acceptedCount = 0;
$cancelledCount = 0;

if ($hasOrder) {
    foreach ($orders as $order) {
        $totalItems += intval($order['qty']);
        $totalSpent += floatval($order['total']);

        if (strtolower($order['status']) === 'pending') {
            $pendingCount++;
        }
        if (strtolower($order['status']) === 'accepted') {
            $acceptedCount++;
        }
        if (strtolower($order['status']) === 'cancelled') {
            $cancelledCount++;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders Received</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --card-radius: .75rem
        }

        .order-card {
            border-radius: var(--card-radius);
            overflow: hidden;
            box-shadow: 0 6px 18px rgba(16, 24, 40, .06)
        }

        .order-img {
            height: 180px;
            object-fit: cover
        }

        .badge-status {
            font-size: .75rem;
            padding: .45em .6em;
            border-radius: .5rem
        }

        .stats .card {
            border-radius: .5rem
        }
    </style>
</head>

<body class="bg-light">
    <div class="container py-5">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start gap-3 mb-4">
            <div>
                <h1 class="h3 mb-1">Orders Received</h1>
                <p class="text-muted mb-0">Review incoming orders and accept them when ready.</p>
            </div>
            <div class="d-flex gap-2 w-100 w-md-auto">
                <input id="orderSearch" class="form-control" placeholder="Search orders or titles">
                <select id="statusFilter" class="form-select">
                    <option value="all">All status</option>
                    <option value="pending">Pending</option>
                    <option value="cancelled">Cancelled</option>
                    <option value="accepted">Accepted</option>
                </select>
                <a href="homepage.php" class="btn btn-outline-secondary">Back</a>
            </div>
        </div>

        <?php if (!empty($successMessage)): ?>
            <div class="alert alert-success"><?= htmlspecialchars($successMessage) ?></div>
        <?php endif; ?>

        <div class="row g-3 stats mb-4">
            <div class="col-6 col-md-3">
                <div class="card p-3 text-center">
                    <div class="text-muted">Orders</div>
                    <div class="h4 mb-0"><?= $hasOrder ? count($orders) : 0 ?></div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card p-3 text-center">
                    <div class="text-muted">Items</div>
                    <div class="h4 mb-0"><?= $hasOrder ? $totalItems : 0 ?></div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card p-3 text-center">
                    <div class="text-muted">Pending</div>
                    <div class="h4 mb-0 text-warning"><?= $pendingCount ?></div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card p-3 text-center">
                    <div class="text-muted">Accepted</div>
                    <div class="h4 mb-0 text-success"><?= $acceptedCount ?></div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card p-3 text-center">
                    <div class="text-muted">Cancelled</div>
                    <div class="h4 mb-0 text-danger"><?= $cancelledCount ?></div>
                </div>
            </div>
        </div>

        <div id="ordersGrid" class="row g-4">
            <?php if ($hasOrder): ?>
                <?php foreach ($orders as $index => $order): ?>
                    <?php
                    $status = strtolower($order['status']);
                    $statusClass = 'bg-secondary';
                    if ($status === 'pending')
                        $statusClass = 'bg-warning text-dark';
                    elseif ($status === 'accepted')
                        $statusClass = 'bg-success';
                    ?>
                    <div class="col-12 col-md-6 col-lg-4 order-card-item" data-status="<?= htmlspecialchars($status) ?>">
                        <div class="card order-card h-100 shadow-lg">
                            <img src="<?= htmlspecialchars($order['image']) ?>" class="card-img-top order-img" alt="Book cover">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title mb-1"><?= htmlspecialchars($order['name']) ?></h5>
                                <p class="text-muted mb-2">Qty: <?= intval($order['qty']) ?></p>
                                <div class="mb-3">
                                    <span
                                        class="badge <?= $statusClass ?> badge-status"><?= htmlspecialchars($order['status']) ?></span>
                                    <small class="text-muted ms-2">Ordered <?= htmlspecialchars($order['date']) ?></small>
                                </div>
                                <div class="mt-auto d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="text-muted small">Unit price:</div>
                                        <div class="fw-semibold">R<?= number_format($order['price'], 2) ?></div>
                                    </div>
                                    <div class="text-end">
                                        <?php if (strtolower($order['status']) === 'pending'): ?>
                                            <form method="post" class="d-inline me-2">
                                                <input type="hidden" name="accept_order" value="<?= (int) $order['id'] ?>">
                                                <button type="submit" class="btn btn-sm btn-primary">Accept</button>
                                            </form>
                                            <form method="post" class="d-inline">
                                                <input type="hidden" name="cancelled_order" value="<?= (int) $order['id'] ?>">
                                                <button type="submit" class="btn btn-sm btn-outline-danger">Cancel</button>
                                            </form>
                                        <?php elseif (strtolower($order['status']) === 'accepted'): ?>
                                            <span class="btn btn-sm btn-outline-success disabled">Accepted</span>
                                        <?php else: ?>
                                            <span class="btn btn-sm btn-outline-danger disabled">Cancelled</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="card shadow-lg rounded-4 p-4 text-center border-0">
                        <h2 class="h5 mb-3">No orders received yet.</h2>
                        <p class="text-muted mb-4">When a buyer places an order, it will appear here.</p>
                        <a href="homepage.php" class="btn btn-secondary btn-lg">Continue shopping</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const search = document.getElementById('orderSearch');
        const filter = document.getElementById('statusFilter');
        const items = Array.from(document.querySelectorAll('.order-card-item'));

        function applyFilters() {
            const q = search.value.toLowerCase();
            const status = filter.value;
            items.forEach(it => {
                const text = it.innerText.toLowerCase();
                const matchesQ = !q || text.includes(q);
                const matchesStatus = (status === 'all') || (it.dataset.status === status);
                it.style.display = (matchesQ && matchesStatus) ? '' : 'none';
            });
        }

        search.addEventListener('input', applyFilters);
        filter.addEventListener('change', applyFilters);
    </script>
</body>

</html>