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
    <link rel="stylesheet" href="addproduct.css">
    <title>AddProducts</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary py-4 shadow-sm">
        <div class="container">
            <a class="navbar-brand text-uppercase fw-bold fs-3" href="#">DavesList</a>
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 flex-row justify-content-around align-content-center gap-3">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="SellerDashboard.php">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                            fill="#ff9696">
                            <path d="m313-440 224 224-57 56-320-320 320-320 57 56-224 224h487v80H313Z" />
                        </svg>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
    <!-- AddProducts-->
    <div class="container my-5">

        <!--success message-->
        <?php

        if (isset($_SESSION['status']) && $_SESSION != '') {

            ?>

            <div class="alert alert-success" role="alert">
                <?= $_SESSION['status'] ?>
            </div>


            <?php
            unset($_SESSION['status']);

        }


        ?>





        <?php
        $user_id = $_SESSION['user_id'];
        $id = $_GET['book_id'];
        $editData = $conn->query("SELECT * FROM addbooks WHERE book_Id ='$id' AND user_id = '$user_id'");


        if ($editData->num_rows > 0) {
            foreach ($editData as $row) {

                ?>
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6">
                        <section class="p-4 p-md-5 border border-3 rounded sectionBorder shadow-sm bg-white">
                            <form class="" action="addProductsDb.php" method="post" enctype="multipart/form-data">
                                <h1 class="text-center text-uppercase mb-4">Edit Products</h1>

                                <input type="hidden" name="ebook_id" value="<?php echo $row['book_Id'] ?>">

                                <div class="mb-3">
                                    <label for="bookname" class="form-label">Book Name</label>
                                    <input type="text" class="form-control" name="bName" value="<?php echo $row['bookName'] ?>"
                                        id="bookname" placeholder="Book Name" required>
                                </div>

                                <div class="mb-3">
                                    <label for="pricelisting" class="form-label">Price Listing </label>
                                    <input type="text" class="form-control" name="bPrice" id="pricelisting"
                                        value="<?php echo $row['bookPrice'] ?>" placeholder="Book Price (e.g) R100" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="inputGroupFile01">Upload Image</label>
                                    <input type="file" class="form-control" name="bImage" id="inputGroupFile01">
                                    <input type="hidden" name="old_image" value="<?php echo $row['bookImage']; ?>">
                                    <img src="<?php echo "uploads/" . $row['bookImage']; ?>" width="75" alt="Book Cover">
                                </div>

                                <div class="mb-4">
                                    <label for="pricelisting" class="form-label">Genre</label>
                                    <input type="text" class="form-control" id="pricelisting" name="bCategory"
                                        value="<?php echo $row['Category'] ?>" placeholder="Category (e.g Fantasy)" required>
                                </div>

                                <div class="text-center">
                                    <button type="submit" name="editBookData"
                                        class="btn btn-outline-warning w-100 py-2">Edit</button>
                                </div>
                            </form>
                        </section>
                    </div>
                </div>

                <?php





            }

        } else {

            echo "No data found";



        }


        ?>







    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>