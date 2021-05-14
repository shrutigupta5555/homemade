<?php
//This script will handle login
session_start();

// check if the user is already logged in
if(isset($_SESSION['usernamelog']))
{
    header("location: welcome.php");
    exit;
}
require_once "config.php";

$username = $password = "";
$err = "";

// if request method is post
if ($_SERVER['REQUEST_METHOD'] == "POST"){
    if(empty(trim($_POST['usernamelog'])) || empty(trim($_POST['passwordlog'])))
    {
        $err = "Please enter username + password";
    }
    else{
        $username = trim($_POST['usernamelog']);
        $password = trim($_POST['passwordlog']);
    }


if(empty($err))
{
    $sql = "SELECT id, username, password FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $param_username);
    $param_username = $username;
    
    
    // Try to execute this statement
    if(mysqli_stmt_execute($stmt)){
        mysqli_stmt_store_result($stmt);
        if(mysqli_stmt_num_rows($stmt) == 1)
                {
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt))
                    {
                        if(password_verify($password, $hashed_password))
                        {
                            // this means the password is corrct. Allow user to login
                            session_start();
                            $_SESSION["username"] = $username;
                            $_SESSION["id"] = $id;
                            $_SESSION["loggedin"] = true;

                            //Redirect user to welcome page
                            header("location: products.php");
                            
                        }
                    }

                }

    }
}    
}
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8" />
    <title>All products - Homemade</title>
     <link rel="stylesheet" type="text/css" href="style.css?<?php echo time();?>" />
    
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,700;1,500;1,600&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet"
    href=https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css>
  </head>
  <body>
    <div class="container">
      <div class="navbar">
        <div class="logo">
          <img src="images/logo.png" width="125px" />
        </div>
        <nav>
          <ul id="MenuItems">
            <li><a href="index.html">Home</a></li>
            <li><a href="products.php">Products</a></li>
            <li><a href="aboutus.html">About</a></li>
            <li><a href="https://forms.gle/ae9NGHWYQKHcCcwm9" target="_blank">Contact</a></li>
          </ul>
        </nav>
        <a href="cart.html"><img src="images/cart.png" width="30px" height="30px" /></a>
        <img src="images/menu.png" class="menu-icon" onclick="menutoggle()" />
      </div>
    </div>
    <!-----------------account page----------------------------------------------------------->
    <div class="account-page">
      <div class="container">
        <div class="row">
          <div class="col-2">
            <img src="images/image1.png" width="100%">
          </div>
          <div class="col-2">
            <div class="form-container">
              <div class="form-btn">
                <span> Login </span>
                <!-- <span onclick="register()"> Register </span> -->
            <hr id='Indicator'> 
              </div>
              <form id='loginform'  method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <!-- username -->
                   <label for="usernamelog">Your Username</label>
                    <input type="text" name="usernamelog" id="usernamelog" placeholder="johndoe" >
                    <!-- <span class="error">* <?php echo $username_err;?></span> -->

                <!-- password -->
                   <label for="passwordlog">Password</label>
                   <input type="password" id="passwordlog" name="passwordlog">
                   <!-- <span class="error">* <?php echo $password_err;?></span> -->

                <!-- submit -->
                  <button type='submit' class='btn'>Login</button>
                 
                 <p class="bottom">Don't have an account? <a href="account.php" class="bottom-a">  Register Now  </a></p> 
              </form>
              
            </div>
          </div>
        </div>
      </div>
    </div>
    <!----------------------footer-------------------------->
    <div class="footer">
      <div class="container">
        <div class="row">
          <div class="footer-col-1">
            <h3>Download Our App</h3>
            <p>Download App for Android and ios mobile phone</p>
            <div class="app-logo">
              <img src="images/play-store.png" />
              <img src="images/app-store.png" />
            </div>
          </div>
          <div class="footer-col-2">
            <img src="images/logo-white.png" alt="" />
            <p>
              Our Purpose Is To Sustainably Make The Pleasure and Benefits of
              Sports Accessible to the Many
            </p>
          </div>
          <div class="footer-col-3">
            <h3>Useful Links</h3>
            <ul>
              <li>Coupons</li>
              <li>Blog Post</li>
              <li>Return Policy</li>
              <li>Coupons</li>
              <li>Join Affiliate</li>
            </ul>
          </div>
          <div class="footer-col-4">
            <h3>Follow us</h3>
            <ul>
              <li>Facebook</li>
              <li>Twitter</li>
              <li>Instagram</li>
              <li>Youtube</li>
            </ul>
          </div>
        </div>
        <hr />
        <p class="Copyright">Copyright 2020 - BatchB : Purva Shruti RIA</p>
      </div>
    </div>
    <!--------------------js for toggle menu---------------------------->
    <script>
      var MenuItems = document.getElementById("MenuItems");
      MenuItems.style.maxHeight = "0px";
      function menutoggle() {
        if (MenuItems.style.maxHeight == "0px") {
          MenuItems.style.maxHeight = "200px";
        } else {
          MenuItems.style.maxHeight = "0px";
        }
      }
    </script>
     <!--------------------js for toggle form---------------------------->
    <!-- <script>
      var loginform = document.getElementById('loginform');
      var RegForm = document.getElementById('RegForm');
      var Indicator = document.getElementById("Indicator");
      function register(){
        RegForm.style.transform = "translateX(0px)";
        loginform.style.transform = "translateX(0px)";
        Indicator.style.transform = "translateX(100px)";
      }
      function login(){
        RegForm.style.transform = "translateX(300px)";
        loginform.style.transform = "translateX(300px)";  
        Indicator.style.transform = "translateX(0px)";
      }
    </script> -->
  </body>
</html>