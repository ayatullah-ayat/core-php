<!-- **********************************
  ************MAIN PHP CODE START*******
  ************************************** -->
<?php

// variables of $visitor_couponSection template 
$offer = '80%';
$offer_code = 'OFF30CODE';

// variables of $footer template 
$copyright_year = 2021;
$copyright_owner_name = 'Ayat';


// TEMPLATES
$head = <<<HEAD
 <head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta name="Description" content="Enter your description here"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.0-beta1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">


<!-- google fonts -->
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100;0,300;0,400;0,500;0,800;0,900;1,600&display=swap" rel="stylesheet">


<link rel="stylesheet" href="style.css">
<title>Email Template Design - Pondit Home Work</title>
<style>
    .nav li a {
        color: black;
        font-weight: 600;
    }
</style>
</head>
HEAD;

$header = <<<HEADER
  <div class="header container">
        <hr style="border: 2px solid yellow; margin: 0;">
        <ul class="nav justify-content-center">
            <li class="nav-item">
              <a class="nav-link active" href="#">HOME</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">|</a>
              </li>
            <li class="nav-item">
              <a class="nav-link" href="#">NEW PRODUCTS</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">|</a>
              </li>
            <li class="nav-item">
              <a class="nav-link" href="#">CATALOGUE</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">|</a>
              </li>
            <li class="nav-item">
              <a class="nav-link" href="#">CONTACT US</a>
            </li>
          </ul>
        <hr style="border: 2px solid yellow; margin: 0;">
    </div>
HEADER;

$visitor_couponSection = <<<COUPON
<div class="container text-center">
        <h5>Welcome Visitors</h5>
        <h5 class="text-warning py-3">Free ${offer} OFF coupon code for sign up</h5>
        <p class="text-warning">Use Coupon Code</p>
        <button class="btn btn-warning btn-lg">${offer_code}</button>
        <p class="py-4 w-50 m-auto text-dark">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Similique quidem in omnis adipisci, ullam illum! Itaque ab earum voluptates nesciunt doloribus placeat deserunt nisi. Laboriosam!</p>
    </div>
COUPON;

$footer = <<<FOOTER
<div class="footer bg-dark p-5">
        <div class="container text-center">
            <div class="font-items">
                <span class="bg-warning text-dark mx-2" style="border-radius: 50%; padding: 8px;"><i class="fab fa-facebook-f"></i></span>
                <span class="bg-warning text-dark mx-2" style="border-radius: 50%; padding: 8px;"><i class="fab fa-twitter"></i></span>
                <span class="bg-warning text-dark mx-2" style="border-radius: 50%; padding: 8px;"><i class="fab fa-linkedin"></i></span>
                <span class="bg-warning text-dark mx-2" style="border-radius: 50%; padding: 8px;"><i class="fab fa-youtube"></i></span>
                <span class="bg-warning text-dark mx-2" style="border-radius: 50%; padding: 8px;"><i class="fab fa-google"></i></span>
            </div>
            <ul class="nav justify-content-center pt-3">
                <li class="nav-item">
                  <a class="nav-link active" href="#">PRIVACY STATEMENT</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">|</a>
                  </li>
                <li class="nav-item">
                  <a class="nav-link" href="#">TERMS OF SERVICES</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">|</a>
                  </li>
                <li class="nav-item">
                  <a class="nav-link" href="#">RETURNS</a>
                </li>
              </ul>
              <div class="copyright text-secondary">
                  &copy;${copyright_year} ${copyright_owner_name} all rights reserved
              </div>
              <div class="text-secondary pt-3">
                Lorem ipsum dolor, sit amet consectetur adipisicing elit.
            </div>
        </div>
    </div>
FOOTER;

?>
<!-- ***************************************
  **********MAIN PHP CODE END HERE**********
  ****************************************** -->



<!-- *****************************************
****************HTML START********************
**********************************************-->
<!DOCTYPE html>
<html lang="en">


<!-- head template will be injected here -->
<?php if(isset($head)) {
    if(empty($head)) {
      echo 'head has nothing';
    }
    else {
      echo $head;
    }
  }
?>


<body>
<div class="template-outer">
    <div class="header-dummy-text bg-dark text-white" style="height: 35px;">
        <div class="container d-flex justify-content-between align-items-center h-100">
            <span>Lorem ipsum dolor sit amet consectetur adipisicing elit.</span>
            <a href="#">View online</a>
        </div>
    </div>
    <div class="logo text-center py-4">
        <a href="#">
            <img src="img/logo.jpg" alt="logo" width="150px">
        </a>
    </div>


    <!-- main header will be injected here -->
    <?php if(isset($header)) {
        if(empty($header)) {
          echo 'header has nothing';
        }
        else {
          echo $header;
        }
      }
    ?>


    <div class="py-3 text-center container">
        <img src="img/Screenshot_1.png" alt="">
        <hr style="border: 1px solid transparent;">
    </div>


    <!-- visitors coupon html inject here -->
    <?php if(isset($visitor_couponSection)) {
        if(empty($visitor_couponSection)) {
          echo 'coupon section has nothing';
        }
        else {
          echo $visitor_couponSection;
        }
      }
    ?>

    <!-- Footer will be inject here -->

    <?php if(isset($footer)) {
        if(empty($footer)) {
          echo 'footer has nothing';
        }
        else {
          echo $footer;
        }
      }
    ?>


</div>


    
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.5.4/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.0-beta1/js/bootstrap.min.js"></script>
</body>
</html>
