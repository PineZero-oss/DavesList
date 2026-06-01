<?php
session_start();
require_once 'userDdconfig.php';

//category filter
 $sql = "SELECT * FROM addbooks";
 if (isset($_GET['category']) && $_GET['category'] !== '') {
    $category = $conn->real_escape_string($_GET['category']);
    $sql .= " WHERE Category = '$category'";
 }

 //search functionality
 if (isset($_GET['searchBook']) && $_GET['searchBook'] !== '') {
    $searchBook = $conn->real_escape_string($_GET['searchBook']);
    $sql .= " WHERE BookName LIKE '%$searchBook%' OR Category LIKE '%$searchBook%'";
 }
 


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
       <link rel="stylesheet" href="css/bootstrap.min.css" >
       <link rel="stylesheet" href="homePage.css">
    <title>Homepage</title>
</head>
<body>

<nav class="navbar navbar-expand-lg bg-body-tertiary py-4 ">
  <div class="container-fluid h-75">
    <a class="navbar-brand text-uppercase fw-bold fs-3" href="#">DavesList</a>
    <button class="navbar-toggler  justify-content-center" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <br>

         <form class="d-flex gap-1" role="search" method="get">
        <input class="form-control me-auto" type="search" placeholder="Search book..." aria-label="Search" name="searchBook"/>
        <button class="btn btn-outline-secondary" type="submit">Search</button>
      </form>

      <br>


      <ul class="navbar-nav ms-auto mb-2 mb-lg-0 flex-row justify-content-around align-content-center gap-4">
        <li class="nav-item">
          <a href="userLogin.php" class="btn btn-primary px-4 shadow-sm">Login</a>
        </li>

        <li class="nav-item">
          
        <a class="nav-link" role="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling"  href="#offcanvasScrolling" aria-controls="offcanvasScrolling"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#ff9696"><path d="M600-120h240v-33q-25-23-56-35t-64-12q-33 0-64 12t-56 35v33Zm162.5-137.5Q780-275 780-300t-17.5-42.5Q745-360 720-360t-42.5 17.5Q660-325 660-300t17.5 42.5Q695-240 720-240t42.5-17.5ZM480-480Zm2-140q-58 0-99 41t-41 99q0 48 27 84t71 50q0-23 .5-44t8.5-38q-14-8-20.5-22t-6.5-30q0-25 17.5-42.5T482-540q15 0 28.5 7.5T533-512q11-5 23-7t24-2h36q-13-43-49.5-71T482-620ZM370-80l-16-128q-13-5-24.5-12T307-235l-119 50L78-375l103-78q-1-7-1-13.5v-27q0-6.5 1-13.5L78-585l110-190 119 50q11-8 23-15t24-12l16-128h220l16 128q13 5 24.5 12t22.5 15l119-50 110 190-85 65H696q-1-5-2-10.5t-3-10.5l86-65-39-68-99 42q-22-23-48.5-38.5T533-694l-13-106h-79l-14 106q-31 8-57.5 23.5T321-633l-99-41-39 68 86 64q-5 15-7 30t-2 32q0 16 2 31t7 30l-86 65 39 68 99-42q24 25 54 42t65 22v184h-70Zm210 40q-25 0-42.5-17.5T520-100v-280q0-25 17.5-42.5T580-440h280q25 0 42.5 17.5T920-380v280q0 25-17.5 42.5T860-40H580Z"/></svg></a>

       </li>
     </ul>
     
    </div>
  </div>
</nav>

 <!-- offcanvas items go here-->

   <!-- sidebar for account settings-->

<div class="offcanvas offcanvas-start" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="offcanvasScrolling" aria-labelledby="offcanvasScrollingLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title text-uppercase" id="offcanvasScrollingLabel">daveslist</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <div class="text-center py-4">
      <h5 class="fw-bold">Greetings, Guest!</h5>
      <p class="text-muted mb-4">Join the DavesList community to list your own books, manage your cart, and become a partner.</p>
      <a href="userLogin.php" class="btn btn-primary w-100 mb-2">Login</a>
      <a href="userSignup.php" class="btn btn-outline-secondary w-100">Sign Up</a>
    </div>
  </div>
</div>

  <!-- homepage banner-->
<section class="Hero">

  <div id="myCarousel" class="carousel slide mb-6" data-bs-ride="carousel">
     <div class="carousel-indicators"> <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button> <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2" class=""></button> <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3" class=""></button>
     </div>

      <div class="carousel-inner"> <div class="carousel-item active"> <img src="raw/indexBannerimg1.jpg" class="d-block w-100" alt="bannerimg">
       <div class="container"> 
        <div class="carousel-caption text-start"> <h1>Want to sell your Books?.</h1>
         <p class="opacity-75">Sign up now and become a partner.</p>
     </div> 
    </div> 
  </div> 

  <div class="carousel-item"> <img src="raw/indexBannerimg2.jpg" class="d-block w-100" alt="bannerimg">
   <div class="container">
     <div class="carousel-caption"> <h1></h1> <p ></p> 
 </div> 

</div> 
</div>

 <div class="carousel-item"> <img src="raw/indexBannerimg3.jpg" class="d-block w-100" alt="bannerimg">
 <div class="container"> <div class="carousel-caption text-end"> <h1  class="text-item3">Feed your inner bookworm.</h1> <p>With <b>DAVESLIST</b>.</p> 
 </div> 

</div> 
</div> 
</div> 
<button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev"> <span class="carousel-control-prev-icon" aria-hidden="true"></span> <span class="visually-hidden">Previous</span> </button> <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next"> <span class="carousel-control-next-icon" aria-hidden="true"></span> <span class="visually-hidden">Next</span>
 </button>
  </div>
</section>

<div class="container my-5">
 <!--  <h2 class="text-center text-uppercase fw-bold mb-4">Featured Books</h2>
  Placeholder for a featured books section - could be a carousel or a few highlighted cards -->
 <!-- <div class="row mb-5">
    <div class="col-12 text-center">
      <p class="text-muted">Discover our hand-picked selection of amazing reads!</p>
    </div>
  </div> -->

  <h2 class="text-center text-uppercase fw-bold mb-4">Browse by Category</h2>
  <div class="d-flex  flex-wrap justify-content-center gap-3 mb-5">
    <a href="Index.php?category=Fantasy" class="btn btn-outline-secondary rounded-pill">Fantasy</a>
    <a href="Index.php?category=Action" class="btn btn-outline-secondary rounded-pill">Action</a>
    <a href="Index.php?category=Science Fiction" class="btn btn-outline-secondary rounded-pill">Science Fiction</a>
    <a href="Index.php?category=Thriller" class="btn btn-outline-secondary rounded-pill">Thriller</a>
    <a href="Index.php?category=Horror" class="btn btn-outline-secondary rounded-pill">Horror</a>
    <a href="Index.php?category=Romance" class="btn btn-outline-secondary rounded-pill">Romance</a>
    <a href="Index.php?category=Mystery" class="btn btn-outline-secondary rounded-pill">Mystery</a>
    <a href="Index.php?category=Biography" class="btn btn-outline-secondary rounded-pill">Biography</a>
    <a href="Index.php?category=Comedy" class="btn btn-outline-secondary rounded-pill">Comedy</a>
    <a href="Index.php" class="btn btn-outline-secondary rounded-pill">All Books</a>
  </div>
</div>

 <div class="container products-container pb-5">
 <!-- #region-->
 <div class="row">

 <?php 
 

 $displayBooks = $conn->query($sql);
 if($displayBooks->num_rows > 0){
  foreach($displayBooks as $row){
?>
    <div class="col-12 col-md-4 mb-3">
      <div class="card h-100">
        <img src="<?= htmlspecialchars("uploads/" . $row['bookImage']) ?>" class="card-img-top" alt="Book cover">
        <div class="card-body">
          <h5 class="card-title"><?= htmlspecialchars($row['bookName']) ?></h5>
          <p class="card-price">R<?= number_format($row['bookPrice'],2) ?></p>
          <p class="card-text"><span class="badge rounded-pill text-bg-warning text-white"><?= htmlspecialchars($row['Category']) ?></span></p>
        </div>
      </div>
    </div>
<?php
    }
  }
 ?>
    </div>
 </div>

<footer>
  <div class="container py-4">
    <p class="text-center text-muted m-0">&copy; 2026 DavesList. All rights reserved.</p>
    <div class="text-center mt-2">
      <a href="#" class="text-muted text-decoration-none mx-2">Privacy Policy</a>
      <a href="#" class="text-muted text-decoration-none mx-2">Terms of Service</a>
    </div>
  </div>
</footer>

  <script src="js/bootstrap.bundle.min.js"></script>

</body>
</html>
