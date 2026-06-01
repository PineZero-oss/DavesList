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
                            <div class="text-primary mt-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-people" viewBox="0 0 16 16">
                                    <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8Zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022ZM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816ZM4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0Zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4Z"/>
                                </svg>
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
                            <div class="text-success mt-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentcolor" class="bi bi-book" viewBox="0 0 16 16">
                                    <path d="M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.933-.575-2.136-.964-3.545-.964-1.33 0-2.3.446-3.041.918V2.828zm14 0c-.885-.37-2.154-.769-3.388-.893-1.33-.134-2.458.063-3.112.752v9.746c.933-.575 2.136-.964 3.545-.964 1.33 0 2.3.446 3.041.918V2.828z"/>
                                </svg>
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