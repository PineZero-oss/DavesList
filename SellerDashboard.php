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

          <li class="nav-item"><a class="nav-link active" aria-current="page" href="Index.php"><svg
                xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#ff9696">
                <path
                  d="M240-200h120v-240h240v240h120v-360L480-740 240-560v360Zm-80 80v-480l320-240 320 240v480H520v-240h-80v240H160Zm320-350Z" />
              </svg></a>
          </li>

          <li class="nav-item"><a class="nav-link active" aria-current="page" href="AddProduct.php"><svg
                xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#ff9696">
                <path
                  d="M520-400h80v-120h120v-80H600v-120h-80v120H400v80h120v120ZM320-240q-33 0-56.5-23.5T240-320v-480q0-33 23.5-56.5T320-880h480q33 0 56.5 23.5T880-800v480q0 33-23.5 56.5T800-240H320Zm0-80h480v-480H320v480ZM160-80q-33 0-56.5-23.5T80-160v-560h80v560h560v80H160Zm160-720v480-480Z" />
              </svg> </a> </li>

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
      <p>Profile Controlls to be added here.</p>
    </div>
  </div>

  <!-- Display added products-->



  <div class="container py-5">


    <table class="table table-striped table-bordered py-5">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Book Name</th>
          <th scope="col">Price</th>
          <th scope="col">Cover</th>
          <th scope="col">Genre</th>
          <th scope="col">Modify</th>
        </tr>
      </thead>
      <tbody>


        <?php

        $addNewProduct = $conn->query("SELECT * FROM addbooks");
        if ($addNewProduct->num_rows > 0) {
          $count = 1;
          foreach ($addNewProduct as $row) {



            ?>

              <!-- display books -->
            <tr>
              <th scope="row" class="text-center"><?= $count++ ?></th>
              <td><?= htmlspecialchars($row['bookName']) ?></td>
              <td><?= htmlspecialchars($row['bookPrice']) ?></td>
              <td class="text-center">

                <img src="<?= htmlspecialchars("uploads/" . $row['bookImage']) ?>" alt="Book Cover" class="img-fluid"
                  style="max-width: 100px; height: auto;">
              </td>
              <td><?= htmlspecialchars($row['Category']) ?></td>

              <td>
                <a href="editProducts.php" type="button" class="btn btn-outline-warning">Edit</a>
                <a href="deleteProducts.php" type="button" class="btn btn-outline-danger">Delete</a>
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


  <footer>
    <p class="text-center">&copy; 2026 DavesList. All rights reserved.</p>
  </footer>
  <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>