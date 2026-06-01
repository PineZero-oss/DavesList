
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
      <a href="bookManagement.php" class="btn btn-primary shadow-sm px-4">Manage Books</a>
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
        <table class="table table-hover align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th scope="col" class="ps-4">#</th>
              <th scope="col">username</th>
              <th scope="col">email</th>
              <th scope="col" class="text-center">role</th>
              <th scope="col" class="text-center pe-4">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $current_user = $_SESSION['role'];
            $diplayProfiles = $conn->query("SELECT * FROM users WHERE uRole != 'admin' ORDER BY id DESC");
            if ($diplayProfiles->num_rows > 0) {
              $count = 1;
              foreach ($diplayProfiles as $row) {
                ?>
                <tr>
                  <td class="ps-4 font-monospace text-muted"><?= $count++ ?></td>
                  <td class="fw-bold text-dark"><?= htmlspecialchars($row['userName']) ?></td>
                  <td class="fw-bold text-primary"><?= htmlspecialchars($row['uEmail']) ?></td>
                  <td class="text-center">
                    <span class="badge rounded-pill bg-info text-white"><?= htmlspecialchars($row['uRole']) ?></span>
                  </td>
                  <td class="text-center pe-4">
                    <div class="btn-group shadow-sm">
                      
                      <form action="userLoginRegister.php" method="post" class="d-inline">
                        <input type="hidden" name="dusername" value="<?php echo $row['userName']; ?>">
                        <input type="hidden" name="duserEmail" value="<?php echo $row['uEmail']; ?>">
                        <button type="submit" name="deleteUser" value="<?php echo $row['id']; ?> "class="btn btn-sm btn-outline-danger"
                          onclick="return confirm('Remove this user from the site?')">Delete</button>
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