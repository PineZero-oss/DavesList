






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="homePage.css">

    <title>HomePage</title>
</head>
<body>
    
<!--Navigation bar -->  
<nav class="navbar">
    <ul>
        <li><a href="#">DavesList</a></li>
        <li><a href="#"></a></li>
        <li><a href="#"></a></li>
        <li><a class="shoppingcart" href=""><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#ff9696"><path d="M223.5-103.5Q200-127 200-160t23.5-56.5Q247-240 280-240t56.5 23.5Q360-193 360-160t-23.5 56.5Q313-80 280-80t-56.5-23.5Zm400 0Q600-127 600-160t23.5-56.5Q647-240 680-240t56.5 23.5Q760-193 760-160t-23.5 56.5Q713-80 680-80t-56.5-23.5ZM246-720l96 200h280l110-200H246Zm-38-80h590q23 0 35 20.5t1 41.5L692-482q-11 20-29.5 31T622-440H324l-44 80h480v80H280q-45 0-68-39.5t-2-78.5l54-98-144-304H40v-80h130l38 80Zm134 280h280-280Z"/></svg></a></li>

        <a class="sidebarbtn btn justify-content-flex-start" data-bs-toggle="offcanvas" href="#offcanvasExample"  aria-controls="offcanvasExample">
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000"><path d="M120-240v-80h720v80H120Zm0-200v-80h720v80H120Zm0-200v-80h720v80H120Z"/></svg>
</a>




    </ul>

</nav>

<!-- Sidebar-->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">


  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasExampleLabel">DavesList</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>


  <!-- finish sidebar later-->

  <div class="offcanvas-body">
    
    <div class="offcanvas-content">


       <ul>
        <li><a href="#">Home</a></li>
        <li><a href="#">About</a></li>
        <li><a href="#">Shop</a></li>
        <li><a href="#">Cart</a></li>
      </ul>

    </div>
    <br>
   
       
      
   
    

      <button class="btn SellerLoginbtn align-items-center" type="button" data-bs-toggle="button" aria-pressed="false" autocomplete="off">
        Login
      </button>
        <p>login to be able to list products on the site!</p>
      
  </div>
</div>


<!--searchbar note to self make it functional -->
<div class="searchbar-container">
  <form class="container-fluid">
    <div class="input-group">
      <button class="searchbtn input-group-text" id="searchbar"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#ff9696"><path d="M784-120 532-372q-30 24-69 38t-83 14q-109 0-184.5-75.5T120-580q0-109 75.5-184.5T380-840q109 0 184.5 75.5T640-580q0 44-14 83t-38 69l252 252-56 56ZM380-400q75 0 127.5-52.5T560-580q0-75-52.5-127.5T380-760q-75 0-127.5 52.5T200-580q0 75 52.5 127.5T380-400Z"/></svg></button>
      <input type="text" class="form-control" placeholder="searchbar" aria-label="Username" aria-describedby="searchbar"/>
    </div>
  </form>
</div>



<!-- Carousel, just some banner images -->
<div id="carouselExample" class="carousel carousel-dark slide" data-bs-ride="carousel">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="raw/bannerimg1.jpg" class="d-block w-100" alt="Slide 1">
    </div>
    <div class="carousel-item">
      <img src="raw/bannerimg2.jpg" class="d-block w-100" alt="Slide 2">
    </div>
    <div class="carousel-item">
      <img src="raw/bannerimg3.jpg" class="d-block w-100" alt="Slide 3">
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>

<!-- cards to display products --->
 
 

 <div class="container products-container my-4 align-center justify-content-center">

  <div class="row">
    <!-- Card 1 -->
    <div class="col-12 col-md-5 mb-3">
      <div class="card h-100">
        <img src="raw/SigninBackground.jpg" class="card-img-top" alt="...">
        <div class="card-body">
          <h5 class="card-title">Card title</h5>
          <p class="card-price">R</p>
          <a href="#" class="btn btn-primary">Add to cart</a>
        </div>
      </div>
    </div>

    <!-- Card 2 -->
    <div class="col-12 col-md-5 mb-3">
      <div class="card h-100" >
        <img src="raw/SigninBackground.jpg" class="card-img-top" alt="...">
        <div class="card-body">
          <h5 class="card-title">Card title</h5>
          <p class="card-price">R</p>
          <a href="#" class="btn btn-primary">Add to cart</a>
        </div>
      </div>
    </div>

    <!-- product item -->
    <div class="col-12 col-md-5 mb-3">
      <div class="card h-100" >
        <img src="raw/SigninBackground.jpg" class="card-img-top" alt="...">
        <div class="card-body">
         <h5 class="card-title">Card title</h5>
          <p class="card-price">R</p>
          <a href="#" class="btn btn-primary">Add to cart</a>
        </div>
      </div>
    </div>

    <!-- product item -->
    <div class="col-12 col-md-5 mb-3">
      <div class="card h-100" >
        <img src="raw/SigninBackground.jpg" class="card-img-top" alt="...">
        <div class="card-body">
         <h5 class="card-title">Card title</h5>
          <p class="card-price">R</p>
          <a href="#" class="btn btn-primary">Add to cart</a>
        </div>
      </div>
    </div>

  </div>

</div>






 


<footer class="Page-Footer"></footer>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>