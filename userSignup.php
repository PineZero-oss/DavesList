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
    <title>Sign up</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary py-4 shadow-sm">
        <div class="container">
            <a class="navbar-brand text-uppercase fw-bold fs-3" href="#">DavesList</a>
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 flex-row justify-content-around align-content-center gap-3">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="Index.php">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                            fill="#ff9696">
                            <path d="m313-440 224 224-57 56-320-320 320-320 57 56-224 224h487v80H313Z" />
                        </svg>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
   
    <div class="container my-5">
        <div class="row justify-content-center">

        <?php if (isset($_SESSION['login-register-error'])): ?>

                        <div class="alert alert-warning" role="alert">
                            <?= $_SESSION['login-register-error'] ?>
                        </div>

                    <?php endif; ?>
                    <?php unset($_SESSION['login-register-error']); ?>

                    
            <div class="col-md-8 col-lg-6">
                <section class="p-4 p-md-5 border border-3 rounded sectionBorder shadow-sm bg-white">
                    <form class="" id="userSigupForm" action="userLoginRegister.php" method="post">
                        <h1 class="text-center text-uppercase mb-4">sign up</h1>

                        <div class="mb-3">
                            <label for="username" class="form-label">username</label>
                            <input type="text" class="form-control" name="userName" id="userName-input"
                                placeholder="Enter username" required>
                        </div>

                        <div class="mb-3">
                            <label for="useremail" class="form-label">email</label>
                            <input type="email" class="form-control" name="uEmail" id="uEmail-input"
                                placeholder="enter email" required>
                        </div>


                        <div class="mb-4">
                            <label for="userpassword" class="form-label">password</label>
                            <input type="password" class="form-control" id="uPassword-input" name="uPassword"
                                placeholder="enter password" required>
                        </div>


                        <div class="mb-4">
                            <label for="repeatuserpassword" class="form-label">repeat password</label>
                            <input type="password" class="form-control" id="uRepeatPassword-input" name="uRepeatPassword"
                                placeholder="repeat password" required>
                        </div>

                        <div class="input-group mb-4">
                            <select class="form-select" id="inputGroupSelect04"
                                aria-label="Example select with button addon" name="role">
                                <option value="" selected>choose role...</option>
                                <option value="buyer">buyer</option>
                                <option value="seller">seller</option>
                                <option disabled value="admin">admin</option>
                            </select>
            
                        </div>

                        <div class="text-center">
                            <button type="submit" name="signup"
                                class="btn btn-outline-secondary w-100 py-2">submit</button>
                        </div>
                    </form>
                    <p class="text-center mt-3">Already have an account? <a href="userLogin.php">Login</a></p>
                </section>
            </div>
        </div>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>