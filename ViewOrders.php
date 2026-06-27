<?php
session_start();
require_once 'userDdconfig.php';

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    header('Location: userLoginRegister.php');
    exit();
}
$totalItems = 0;
$totalSpent = 0.0;
$orders = [];

$stmt = $conn->prepare("SELECT id, book_name, book_price, qty, total, image_path, status, created_at FROM orders WHERE buyer_id = ? ORDER BY created_at DESC");
$stmt->bind_param('i', $user_id);
$stmt->execute();
$res = $stmt->get_result();

while ($row = $res->fetch_assoc()) {
    $status = $row['status'];
    if ($status === 'Accepted') {
        $displayStatus = 'Accepted';
    } elseif ($status === 'Cancelled') {
        $displayStatus = 'Cancelled';
    } else {
        $displayStatus = 'Pending';
    }

    $orders[] = [
        'id' => (int) $row['id'],
        'name' => $row['book_name'],
        'price' => (float) $row['book_price'],
        'qty' => (int) $row['qty'],
        'total' => (float) $row['total'],
        'image' => !empty($row['image_path']) ? 'uploads/' . $row['image_path'] : '',
        'status' => $displayStatus,
        'date' => date('Y-m-d', strtotime($row['created_at']))
    ];
    $totalItems += (int) $row['qty'];
    $totalSpent += (float) $row['total'];
}
$stmt->close();

$hasOrder = !empty($orders);



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>
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

        .no-select {
            user-select: none
        }
    </style>
</head>

<body class="bg-light">
    <div class="container py-5">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start gap-3 mb-4">
            <div>
                <h1 class="h3 mb-1">My Orders</h1>
                <p class="text-muted mb-0">overview of recent book orders.</p>
            </div>
            <div class="d-flex gap-2 w-100 w-md-auto">
                <input id="orderSearch" class="form-control" placeholder="Search orders, titles or authors">
                <select id="statusFilter" class="form-select">
                    <option value="all">All status</option>
                    <option value="pending">Pending</option>
                    <option value="accepted">Accepted</option>
                    <option value="cancelled">Cancelled</option>
                </select>

                <a href="homepage.php" class="btn btn-outline-secondary">Back</a>
            </div>
        </div>

    <div class="row g-3 stats mb-4">
        <div class="col-6 col-md-3">
            <div class="card p-3 text-center">
                <div class="text-muted">Books</div>
                <div class="h4 mb-0"><?= $hasOrder ? count($orders) : 0 ?></div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card p-3 text-center">
                <div class="text-muted">Total quantity</div>
                <div class="h4 mb-0"><?= $hasOrder ? $totalItems : 0 ?></div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card p-3 text-center">
                <div class="text-muted">Spent</div>
                <div class="h4 mb-0 text-success"><?= $hasOrder ? 'R' . number_format($totalSpent, 2) : 'R0.00' ?></div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card p-3 text-center">
                <div class="text-muted">Status</div>
                <div class="h4 mb-0 text-warning"><?= $hasOrder ? 'Processing' : 'None' ?></div>
            </div>
        </div>
    </div>

        <div id="ordersGrid" class="row g-4">
            <?php if ($hasOrder): ?>
                <?php foreach ($orders as $order): ?>
                    <?php
                    $status = strtolower($order['status']);
                    $statusClass = 'bg-secondary';
                    if ($status === 'pending')
                        $statusClass = 'bg-info';
                    elseif ($status === 'accepted')
                        $statusClass = 'bg-success';
                    elseif ($status === 'cancelled')
                        $statusClass = 'bg-danger';
                    ?>
                    <div class="col-12 col-md-6 col-lg-4 order-card-item" data-status="<?= htmlspecialchars($status) ?>">
                        <div class="card order-card h-100 shadow-lg">
                            <img src="<?= htmlspecialchars($order['image']) ?>" class="card-img-top order-img" alt="Book cover">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title mb-1"><?= htmlspecialchars($order['name']) ?></h5>
                                <p class="text-muted mb-2">Qty: <?= intval($order['qty']) ?></p>
                                <div class="mb-2">
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
                                        <a href="#" class="btn btn-sm btn-outline-primary me-2" data-bs-toggle="modal"
                                            data-bs-target="#detailModal">Details</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="card shadow-lg rounded-4 p-4 text-center border-0">
                        <h2 class="h5 mb-3">You have not ordered any items yet.</h2>
                        <p class="text-muted mb-4">Add books to your cart and view them here!!</p>
                        <a href="homepage.php" class="btn btn-secondary btn-lg">Continue shopping</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>


        <div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Order Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-12 col-md-4">
                                <img src="<?= htmlspecialchars($order['image']) ?>" class="img-fluid rounded"
                                    alt="cover">
                            </div>
                            <div class="col-12 col-md-8">
                                <h5><?= htmlspecialchars($order['name']) ?></h5>
                                <p class="text-muted">Quantity: <?= intval($order['qty']) ?></p>
                                <p><strong>Unit price:</strong> R<?= number_format($order['price'], 2) ?></p>
                                <p><strong>Total:</strong> R<?= number_format($order['total'], 2) ?></p>
                                <p><strong>Status:</strong> <span
                                        class="badge <?= $statusClass ?>"><?= htmlspecialchars($order['status']) ?></span>
                                </p>
                                <hr>
                                <p class="mb-0 text-muted small">Shipping to: 123 Example St, City</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <a href="#" class="btn btn-primary">View Receipt</a>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Front-end-only search + filter
        const search = document.getElementById('orderSearch');
        const filter = document.getElementById('statusFilter');
        const items = Array.from(document.querySelectorAll('.order-card-item'));

        function applyFilters() {
            const q = search.value.toLowerCase();
            const status = filter.value;
            items.forEach(it => {
                const text = it.innerText.toLowerCase();
                const matchesQ = !q || text.includes(q);
                const matchesStatus = (status === 'all') || (it.dataset.status === status) || (status === 'pending' && it.dataset.status === 'pending') || (status === 'accepted' && it.dataset.status === 'accepted') || (status === 'cancelled' && it.dataset.status === 'cancelled');
                it.style.display = (matchesQ && matchesStatus) ? '' : 'none';
            });
        }

        search.addEventListener('input', applyFilters);
        filter.addEventListener('change', applyFilters);
    </script>
</body>

</html>
