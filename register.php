<?php
    session_start();

    require 'config/config.php';
    require 'config/common.php';

    if ($_POST){
        if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['phone']) || empty($_POST['address']) || empty($_POST['password']) || strlen($_POST['password']) < 8){
            if (empty($_POST['name'])){
                $nameError = "Name is required";
            }
            if (empty($_POST['email'])){
                $emailError = "Email is required";
            }
            if (empty($_POST['phone'])){
                $phoneError = "Phone is required";
            }
            if (empty($_POST['address'])){
                $addressError = "Address is required";
            }
            if (empty($_POST['password'])){
                $pswError = "Password is required";
            }
            if (strlen($_POST['password']) < 8){
                $pswError = "Password must be at least 8 characters";
            }
        }else{
            $name = $_POST['name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            $password = password_hash($_POST['password'],PASSWORD_DEFAULT);
            $role = 0;

            $stmt = $pdo->prepare("SELECT * FROM users WHERE email= :email");
            $stmt -> execute([':email' =>$email]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result){
                echo "<script>alert('User already registered!!!')</script>";
            }else{
                $stmt = $pdo->prepare("INSERT INTO users (name,email,phone,address,password,role ) VALUES (:name,:email,:phone,:address,:password,:role )");
                $result = $stmt->execute(
                        array(':name'=>$name,':email'=>$email,':phone'=>$phone,':address'=>$address,':password'=>$password,':role'=>$role)
                );

                if ($result){
                    echo "<script>alert('Successfully registered');window.location.href='login.php';</script>";
                }

            }
        }
    }
?>

<!DOCTYPE html>
<html lang="zxx" class="no-js">

<head>
    <!-- Mobile Specific Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon-->
    <link rel="shortcut icon" href="img/fav.png">
    <!-- Author Meta -->
    <meta name="author" content="CodePixar">
    <!-- Meta Description -->
    <meta name="description" content="">
    <!-- Meta Keyword -->
    <meta name="keywords" content="">
    <!-- meta character set -->
    <meta charset="UTF-8">
    <!-- Site Title -->
    <title>Karma Shop</title>

    <!--
        CSS
        ============================================= -->
    <link rel="stylesheet" href="css/linearicons.css">
    <link rel="stylesheet" href="css/owl.carousel.css">
    <link rel="stylesheet" href="css/themify-icons.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/nice-select.css">
    <link rel="stylesheet" href="css/nouislider.min.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/main.css">
</head>

<body>

<!-- Start Header Area -->
<header class="header_area sticky-header">
    <div class="main_menu">
        <nav class="navbar navbar-expand-lg navbar-light main_box">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <a class="navbar-brand logo_h" href="index.html"><h4>SHOP<h4></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!-- Collect the nav links, forms, and other content for toggling -->
            </div>
        </nav>
    </div>
    <div class="search_input" id="search_input_box">
        <div class="container">
            <form class="d-flex justify-content-between">
                <input type="text" class="form-control" id="search_input" placeholder="Search Here">
                <button type="submit" class="btn"></button>
                <span class="lnr lnr-cross" id="close_search" title="Close Search"></span>
            </form>
        </div>
    </div>
</header>
<!-- End Header Area -->

<!-- Start Banner Area -->
<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>Login/Register</h1>
                <nav class="d-flex align-items-center">
                    <a href="index.html">Home<span class="lnr lnr-arrow-right"></span></a>
                    <a href="register.php">Register</a>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- End Banner Area -->

<!--================Login Box Area =================-->
<section class="login_box_area section_gap">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="login_box_img">
                    <img class="img-fluid" src="img/login.jpg" alt="">
                    <div class="hover">
                        <h4>Already registered to our SHOP?</h4>
                        <p>There are advances being made in science and technology everyday</p>
                        <a class="primary-btn" href="login.php">Login to your Account</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="login_form_inner">
                    <h3>Register to create account</h3>
                    <form class="row login_form" action="register.php" method="post" id="contactForm" novalidate="novalidate">
                        <input name="_token" type="hidden" value="<?php echo $_SESSION['_token']; ?>">
                        <div class="col-md-12 form-group">
                            <input type="text" class="form-control" name="name" placeholder="User Name" onfocus="this.placeholder = ''" onblur="this.placeholder = 'NAME'" style="<?php echo empty($nameError) ? '' : 'border:1px solid red'; ?>">
                        </div>
                        <div class="col-md-12 form-group">
                            <input type="email" class="form-control" name="email" placeholder="Email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'EMAIL'" style="<?php echo empty($emailError) ? '' : 'border:1px solid red'; ?>">
                        </div>
                        <div class="col-md-12 form-group">
                            <input type="text" class="form-control" name="phone" placeholder="Phone Number" onfocus="this.placeholder = ''" onblur="this.placeholder = 'PHONE'" style="<?php echo empty($phoneError) ? '' : 'border:1px solid red'; ?>">
                        </div>
                        <div class="col-md-12 form-group">
                            <input type="text" class="form-control" name="address" placeholder="address" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Address'" style="<?php echo empty($addressError) ? '' : 'border:1px solid red'; ?>">
                        </div>
                        <div class="col-md-12 form-group">
                            <input type="password" class="form-control" name="password" placeholder="Password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Password'">
                            <small class="text-danger font-weight-bold"><?php echo empty($pswError) ? '' : $pswError ?></small>
                        </div>
                        <div class="col-md-12 form-group">
                            <button type="submit" value="submit" class="primary-btn">Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!--================End Login Box Area =================-->

<!-- start footer Area -->
<?php include "footer.php" ?>