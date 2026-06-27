<?php

session_start();
require_once 'userDdconfig.php';

//first change
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] !== 'seller' && $_SESSION['role'] !== 'admin')) {
  header('Location: homepage.php');
  exit();
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <title>ProductPage</title>
</head>

<body class="bg-bg-gradient" style="background: linear-gradient(to right, #f8f9fa, #e9ecef);">

  <nav class="navbar navbar-expand-lg bg-body-tertiary py-4 ">
    <div class="container-fluid h-75">
      <a class="navbar-brand text-uppercase fw-bold fs-3" href="#">DavesList</a>
      <button class="navbar-toggler  justify-content-center" type="button" data-bs-toggle="collapse"
        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
        aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <br>



        <ul class="navbar-nav ms-auto mb-2 mb-lg-0 flex-row justify-content-around align-content-center gap-3">

          <li class="nav-item"></a>
          </li>

          <li class="nav-item">

            <a class="nav-link" role="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling"
              href="#offcanvasScrolling" aria-controls="offcanvasScrolling"><svg xmlns="http://www.w3.org/2000/svg"
                height="24px" viewBox="0 -960 960 960" width="24px" fill="#ff9696">
                <path
                  d="M600-120h240v-33q-25-23-56-35t-64-12q-33 0-64 12t-56 35v33Zm162.5-137.5Q780-275 780-300t-17.5-42.5Q745-360 720-360t-42.5 17.5Q660-325 660-300t17.5 42.5Q695-240 720-240t42.5-17.5ZM480-480Zm2-140q-58 0-99 41t-41 99q0 48 27 84t71 50q0-23 .5-44t8.5-38q-14-8-20.5-22t-6.5-30q0-25 17.5-42.5T482-540q15 0 28.5 7.5T533-512q11-5 23-7t24-2h36q-13-43-49.5-71T482-620ZM370-80l-16-128q-13-5-24.5-12T307-235l-119 50L78-375l103-78q-1-7-1-13.5v-27q0-6.5 1-13.5L78-585l110-190 119 50q11-8 23-15t24-12l16-128h220l16 128q13 5 24.5 12t22.5 15l119-50 110 190-85 65H696q-1-5-2-10.5t-3-10.5l86-65-39-68-99 42q-22-23-48.5-38.5T533-694l-13-106h-79l-14 106q-31 8-57.5 23.5T321-633l-99-41-39 68 86 64q-5 15-7 30t-2 32q0 16 2 31t7 30l-86 65 39 68 99-42q24 25 54 42t65 22v184h-70Zm210 40q-25 0-42.5-17.5T520-100v-280q0-25 17.5-42.5T580-440h280q25 0 42.5 17.5T920-380v280q0 25-17.5 42.5T860-40H580Z" />
              </svg></a>

          </li>
        </ul>

      </div>
    </div>
  </nav>

  <!-- offcanvas items go here-->

  <!-- sidebar for account settings-->

  <div class="offcanvas offcanvas-start" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1"
    id="offcanvasScrolling" aria-labelledby="offcanvasScrollingLabel">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title text-uppercase" id="offcanvasScrollingLabel">daveslist</h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
      <?php if (isset($_SESSION['userName'])): ?>
        <div class="text-center mb-4">
          <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-2"
            style="width: 64px; height: 64px;">
            <span class="fs-2 fw-bold"><?= strtoupper(substr($_SESSION['userName'], 0, 1)) ?></span>
          </div>
          <h5 class="fw-bold mb-0"><?= htmlspecialchars($_SESSION['userName']) ?></h5>
          <p class="text-muted small"><?= htmlspecialchars($_SESSION['uEmail']) ?></p>
        </div>

        <hr>

        <div class="d-grid gap-2">
          <a href="homepage.php" class="btn btn-outline-primary text-start border-0 py-2">
            Home
          </a>
          <a href="OrdersReceived.php" class="btn btn-outline-secondary text-start  border-0 py-2">
            View Orders
          </a>
          <a href="index.php" class="btn btn-outline-danger text-start border-0 py-2">
            Logout
          </a>
        </div>
      <?php else: ?>
        <div class="text-center py-4">
          <p class="text-muted mb-4">You are not logged in.</p>
          <a href="LoginPage.php" class="btn btn-primary w-100 mb-2">Login</a>
          <a href="SignupPage.php" class="btn btn-outline-secondary w-100">Sign Up</a>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <!-- Display added products-->

  <div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2 class="text-uppercase fw-bold m-0">Seller Dashboard</h2>
      <a href="AddProduct.php" class="btn btn-primary shadow-sm px-4">Add Book</a>
    </div>



    <!-- Summary Cards -->
    <div class="row g-4 mb-5">
      <div class="col-12 col-sm-6 col-xl-4 ">
        <div class="card border-0 shadow-sm bg-primary text-white h-100">
          <div class="card-body">
            <h6 class="text-uppercase opacity-75 fw-bold small">Total Inventory</h6>
            <?php
            $current_user = $_SESSION['user_id'];
            $countRes = $conn->query("SELECT COUNT(*) as total FROM addbooks WHERE user_id = '$current_user'");
            $countAvg = $conn->query("SELECT AVG(bookPrice) as avgPrice FROM addbooks WHERE user_id = '$current_user'");
            $total = $countRes->fetch_assoc()['total'] ?? 0;
            $avgPrice = $countAvg->fetch_assoc()['avgPrice'] ?? 0;
            ?>
            <h2 class="mb-0 fw-bold"><?= $total ?> Books</h2>
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-6 col-xl-4">
        <div class="card border-0 shadow-sm bg-white h-100 border-start border-4">
          <div class="card-body">
            <h6 class="text-uppercase text-muted fw-bold small">Active Listings</h6>
            <h2 class="mb-0 fw-bold"><?= $total ?> Listed</h2>
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-6 col-xl-4">
        <div class="card border-0 shadow-sm bg-white h-100 border-start border-4">
          <div class="card-body">
            <h6 class="text-uppercase text-muted fw-bold small">Avg. Listing Price</h6>
            <h2 class="mb-0 fw-bold">R<?= number_format($avgPrice, 2) ?></h2>
          </div>
        </div>
      </div>
    </div>


    <?php
    if (isset($_SESSION['status']) && $_SESSION['status'] != '') {
      ?>
      <div class="alert alert-success" role="alert">
        <?= $_SESSION['status'] ?>
      </div>
      <?php
      unset($_SESSION['status']);
    }
    ?>



    <div class="card shadow-sm border-0">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 shadow-lg">
          <thead class="table-light">
            <tr>
              <th scope="col" class="ps-4">#</th>
              <th scope="col">Book Name</th>
              <th scope="col">Price</th>
              <th scope="col" class="text-center">Cover</th>
              <th scope="col">Genre</th>
              <th scope="col" class="text-center pe-4">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $current_user = $_SESSION['user_id'];
            $addNewProduct = $conn->query("SELECT * FROM addbooks WHERE user_id = '$current_user'");
            if ($addNewProduct->num_rows > 0) {
              $count = 1;
              foreach ($addNewProduct as $row) {
                ?>
                <tr>
                  <td class="ps-4 font-monospace text-muted"><?= $count++ ?></td>
                  <td class="fw-bold text-dark"><?= htmlspecialchars($row['bookName']) ?></td>
                  <td class="fw-bold text-primary">R <?= number_format($row['bookPrice'], 2) ?></td>
                  <td class="text-center">
                    <img src="<?= htmlspecialchars("uploads/" . $row['bookImage']) ?>" alt="Book Cover"
                      class="rounded shadow-sm border" style="width: 50px; height: 70px; object-fit: cover;">
                  </td>
                  <td><span
                      class="badge rounded-pill bg-light text-dark border"><?= htmlspecialchars($row['Category']) ?></span>
                  </td>
                  <td class="text-center pe-4">
                    <div class="btn-group shadow-sm">
                      <a href="editProducts.php?book_id=<?= $row['book_Id'] ?>" class="btn btn-sm btn-white border">Edit</a>
                      <form action="addProductsDb.php" method="post" class="d-inline">
                        <input type="hidden" name="dBookid" value="<?php echo $row['book_Id']; ?>">
                        <input type="hidden" name="dBookImage" value="<?php echo $row['bookImage']; ?>">
                        <button type="submit" name="deleteBook" class="btn btn-sm btn-outline-danger"
                          onclick="return confirm('Remove this book from listings?')">Delete</button>
                      </form>
                    </div>
                  </td>
                </tr>
                <?php
              }
            } else {
              ?>
              <tr>
                <td colspan="6" class="text-center">NO RECORDS FOUND.</td>
              </tr>
              <?php
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <footer>
    <p class="text-center">&copy; 2026 DavesList. All rights reserved.</p>
  </footer>
  <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>
