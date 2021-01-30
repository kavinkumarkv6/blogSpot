<?php 
include( "DBconfig/common_functions.php" );
$crud = new crud();
$crud->is_login();
?>
<!DOCTYPE html>
<html lang="en">
<!-- index.html  21 Nov 2019 03:44:50 GMT -->
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Blog Spot</title>
    <!-- General CSS Files -->
    <link rel="stylesheet" href="assets/css/app.min.css">
    <!-- Template CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/components.css">
    <!-- Custom style CSS -->
    <link rel="stylesheet" href="assets/css/custom.css">
    <link rel="stylesheet" href="assets/css/common.css">
    <link rel='shortcut icon' type='image/x-icon' href='assets/img/logo.png' />
    <style type="text/css">
       .reqi
       {
          color: red;
       }
       .post_img 
       {
          height:250px;
          width: 350px;
       }
    </style>
</head>

<body>
  <div class="loader"></div>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar sticky">
        <div class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg
									collapse-btn"> <i data-feather="align-justify"></i></a></li>
            <li><a href="#" class="nav-link nav-link-lg fullscreen-btn">
                <i data-feather="maximize"></i>
              </a></li>
          </ul>
        </div>
        <ul class="navbar-nav navbar-right">
            <li class="dropdown">
                <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user"> 
                  <img alt="image" src="assets/img/user.png" class="user-img-radious-style"> 
                  <span class="d-sm-none d-lg-inline-block"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right pullDown">
                  <div class="dropdown-title">Hello <?php echo $_SESSION['user_details']['bur_user_name']; ?></div>
                  <!-- <a href="profile.html" class="dropdown-item has-icon"> 
                    <i class="far fa-user"></i> Profile
                  </a>  
                  <a href="#" class="dropdown-item has-icon"> <i class="fas fa-cog"></i>
                    Settings
                  </a> -->
                  <div class="dropdown-divider"></div>
                  <a href="logout" class="dropdown-item has-icon text-danger"> 
                    <i class="fas fa-sign-out-alt"></i>
                    Logout
                  </a>
                </div>
            </li>
        </ul>
      </nav>
      <?php include("sidebar.php"); ?>
      <!-- Main Content -->
      <div class="main-content">