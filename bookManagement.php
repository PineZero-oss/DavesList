
<?php

session_start();
require_once 'userDdconfig.php';




?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <title>ProductPage</title>
</head>

<body>

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
                        <a href="adminPage.php" class="btn btn-outline-light btn-sm">Back</a>
                    </li>
                    
                </ul>
            </div>
        </div>
    </nav>


  

  <!-- Display added products-->

  <div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2 class="text-uppercase fw-bold m-0">User Account Management Dashboard</h2>
      <a href="flaggedBooks.php" class="btn btn-primary shadow-sm px-4">view reported books</a>
    </div>

    <!-- Summary Cards -->


    <?php
    if (isset($_SESSION['dstatus']) && $_SESSION['dstatus'] != '') {
      ?>
      <div class="alert alert-success" role="alert">
        <?= $_SESSION['dstatus'] ?>
      </div>
      <?php
      unset($_SESSION['dstatus']);
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
            $addNewProduct = $conn->query("SELECT * FROM addbooks ORDER BY book_Id DESC");
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

  <footer>
    <p class="text-center">&copy; 2026 DavesList. All rights reserved.</p>
  </footer>
  <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>