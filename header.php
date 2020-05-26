<?php

  session_start();
  if(!isset($_SESSION['userEmail'])){
    header("Location:login.php");
    exit();
 }

?>

<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Iron Man Inventory</title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="index.php" class="nav-link">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="contacts.php" class="nav-link">Users</a>
        </li>
      </ul>

      <!-- SEARCH FORM -->
      <form class="form-inline ml-3" action="search.php" method="post">
        <div class="input-group input-group-sm">
          <input name="search" class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-navbar" type="submit" name="search-submit">
              <i class="fas fa-search"></i>
            </button>
          </div>
        </div>
      </form>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item">
          <form action="includes/logout.inc.php" method="post">
            <button type="submit" class="btn btn-primary btn-block" name="logout-submit">Sign Out</button>
          </form>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="index.php" class="brand-link">
        <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
          style="opacity: .8">
        <span class="brand-text font-weight-light">Stark Industires</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <?php

              include('includes/dbh.inc.php');

              // Select user profile image name from database
              $sql = "SELECT * FROM users";
              $result = mysqli_query($conn, $sql);
                                
              if (mysqli_num_rows($result) > 0) {
                if ($row = mysqli_fetch_assoc($result)) {
                  
                  $userId = $_SESSION['userId'];
                  $picId = $_SESSION['userPic'];

                  $fileName = "uploads/".$picId."*";
                  $filePath = glob($fileName);
                  $fileExt = explode(".", $filePath['0']);
                  $fileActualExt = $fileExt[1];

                  // Assign user profile image name from database to a variabel to insert into the html
                  if ($userId == $picId) {
                    $profilePic = "uploads/".$picId."."."$fileActualExt";
                  } else {
                    $profilePic = "uploads/profile_default_image_stkindustries2020.jpg";
                  }

                  if ($row['picUsers'] == $userId) {
                    echo '<img src="'.$profilePic.'?'.mt_rand().'" class="img-circle elevation-2" alt="User Image">';
                  } else {
                    echo '<img src="'.$profilePic.'" class="img-circle elevation-2" alt="Default User Image">';
                  }
                }
              }
              
            ?>
          </div>
          <div class="info">
            <a href="profile.php" class="d-block"><?= $_SESSION["userName"]; ?></a>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <li class="nav-item has-treeview menu-open">
              <a href="#" class="nav-link active">
                <i class="nav-icon fas fa-folder"></i>
                <p>
                  Categories
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="category-add.php" class="nav-link">
                    <i class="fas fa-plus nav-icon"></i>
                    <p>Add New Category</p>
                  </a>
                </li>
                <?php
                //Fetches all the categories from the database

                  include('dbh.inc.php');

                  $sql = "SELECT * FROM categories";
                  
                  if($result = mysqli_query($conn, $sql)) {
                    if(mysqli_num_rows($result) > 0) {
                      while($row = mysqli_fetch_array($result)) {

                        $category = $row['nameCategory'];

                        echo
                          '<li class="nav-item">
                            <a href="category.php?category='.$category.'" class="nav-link">
                              <i class="far fa-circle nav-icon"></i>
                            <p>'.$category.'</p>
                            </a>
                          </li>';

                      }
                    }
                  }
                  
                ?>

              </ul>
            </li>
            <li class="nav-item">
              <a href="allproducts.php" class="nav-link">
                <i class="nav-icon fas fa-th"></i>
                <p>
                  All Items
                </p>
              </a>
            </li>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>