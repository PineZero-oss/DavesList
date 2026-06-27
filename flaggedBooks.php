<?php 

session_start();
require_once 'userDdconfig.php';

// Create the flagged_books table if it doesn't exist
$createTableQuery = "CREATE TABLE IF NOT EXISTS flagged_books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    book_Id INT NOT NULL,
    user_id INT NOT NULL,
    bookName VARCHAR(255) NOT NULL,
    bookImage VARCHAR(255) NOT NULL,
    flagged_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_flag (book_Id, user_id)
)";

if (!$conn->query($createTableQuery)) {
    die("Error creating flagged_books table: " . $conn->error);
}

if (isset($_POST['fBook_id'])) {
    $bookId = $_POST['fBook_id'];
    $userId = $_SESSION['user_id'];

    // Get book details from the addbooks table
    $getBookQuery = "SELECT bookName, bookImage FROM addbooks WHERE book_Id = ?";
    $stmt = $conn->prepare($getBookQuery);
    $stmt->bind_param("i", $bookId);
    $stmt->execute();
    $bookResult = $stmt->get_result();

    if ($bookResult->num_rows > 0) {
        $bookData = $bookResult->fetch_assoc();
        $bookName = $bookData['bookName'];
        $bookImage = $bookData['bookImage'];

        // Check if the book has already been flagged by this user
        $checkFlagQuery = "SELECT * FROM flagged_books WHERE book_Id = ? AND user_id = ?";
        $stmt = $conn->prepare($checkFlagQuery);
        $stmt->bind_param("ii", $bookId, $userId);
        $stmt->execute();
        $checkResult = $stmt->get_result();

        if ($checkResult->num_rows > 0) {
            // Book has already been flagged by this user
            $_SESSION['flag_status'] = "You have already reported this book.";
        } else {
            // Insert the flag into the database
            $insertFlagQuery = "INSERT INTO flagged_books (book_Id, user_id, bookName, bookImage) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($insertFlagQuery);
            $stmt->bind_param("iiss", $bookId, $userId, $bookName, $bookImage);
            if ($stmt->execute()) {
                $_SESSION['flag_status'] = "Book reported successfully.";
            } else {
                $_SESSION['flag_status'] = "Error reporting the book. Please try again.";
            }
        }
    } else {
        $_SESSION['flag_status'] = "Book not found.";
    }

    // Redirect back to the homepage or any other page
    header("Location: homepage.php");
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
                        <a href="index.php" class="btn btn-outline-danger btn-sm">Logout</a>
                        <a href="bookManagement.php" class="btn btn-outline-light btn-sm">Back</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


  

  <!-- Display added products-->

  <div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2 class="text-uppercase fw-bold m-0">User Account Management Dashboard</h2>
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
              <th scope="col">User Name</th>
              <th scope="col" class="text-center">Cover</th>
              <th scope="col">Genre</th>
              <th scope="col" class="text-center pe-4">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $current_user = $_SESSION['user_id'];
            $flaggedBook = $conn->query("
              SELECT fb.id, fb.book_Id, fb.bookName, fb.bookImage, ab.Category, u.userName
              FROM flagged_books fb
              LEFT JOIN addbooks ab ON fb.book_Id = ab.book_Id
              LEFT JOIN users u ON fb.user_id = u.id
              ORDER BY fb.book_Id DESC
            ");
            if ($flaggedBook->num_rows > 0) {
              $count = 1;
              foreach ($flaggedBook as $row) {
                ?>
                <tr>
                  <td class="ps-4 font-monospace text-muted"><?= $count++ ?></td>
                  <td class="fw-bold text-dark"><?= htmlspecialchars($row['bookName']) ?></td>
                  <td class="fw-bold text-primary"><?= htmlspecialchars($row['userName'] ?? 'Unknown') ?></td>
                  <td class="text-center">
                    <img src="<?= htmlspecialchars("uploads/" . $row['bookImage']) ?>" alt="Book Cover"
                      class="rounded shadow-sm border" style="width: 50px; height: 70px; object-fit: cover;">
                  </td>
                  <td><span
                      class="badge rounded-pill bg-light text-dark border"><?= htmlspecialchars($row['Category'] ?? 'N/A') ?></span>
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
