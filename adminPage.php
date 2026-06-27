<?php
session_start();
require_once 'userDdconfig.php';

// Access control: only admins allowed
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: userLogin.php');
    exit();
}

// getting total users and books for dashboard stats
$userCountRes = $conn->query("SELECT COUNT(*) as total FROM users WHERE uRole != 'admin'");
$totalUsers = $userCountRes->fetch_assoc()['total'] ?? 0;

$bookCountRes = $conn->query("SELECT COUNT(*) as total FROM addbooks");
$totalBooks = $bookCountRes->fetch_assoc()['total'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>Admin Dashboard - DavesList</title>
</head>

<body class="bg-light">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark py-3 shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold text-uppercase" href="#">DavesList Admin</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="adminNavbar">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <span class="navbar-text me-3 text-info">Logged in as: <strong><?= htmlspecialchars($_SESSION['userName']) ?></strong></span>
                    </li>
                    <li class="nav-item">
                        <a href="Index.php" class="btn btn-outline-danger btn-sm">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <h1 class="fw-bold m-0">Platform Overview</h1>
            <h5><span class="badge text-bg-dark text-white fw-bold px-3 py-2">Administrator Panel</span></h5>
        </div>

        <!-- Statistics overview -->
        <div class="row g-4">
            <!-- Users Card -->
            <div class="col-12 col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="text-uppercase text-muted small fw-bold">Total Users</h6>
                                <h2 class="display-5 fw-bold mb-0"><?= $totalUsers ?></h2>
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>

            <!-- Books Card -->
            <div class="col-12 col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="text-uppercase text-muted small fw-bold">Total Books</h6>
                                <h2 class="display-5 fw-bold mb-0"><?= $totalBooks ?></h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-5 card border-0 shadow-sm">
            <div class="card-body p-4 text-center py-5">
                <h4 class="fw-bold mb-3">Admin Utilities</h4>
                <p class="text-muted mb-4 mx-auto" style="max-width: 600px;">Use the following modules to manage the DavesList marketplace ecosystem. Platform settings are currently restricted.</p>
                <div class="d-flex justify-content-center gap-3">
                    <a class="btn btn-primary px-4 py-2" href="userManagement.php">User Management</a>
                    <a class="btn btn-outline-secondary px-4 py-2" disabled>Platform Settings</a>
                </div>
            </div>
        </div>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>