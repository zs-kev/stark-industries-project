<?php

  session_start();
  if (!isset($_SESSION['userAdmin'])) {
    header("Location:index.php");
    exit();
  }
  
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Iron Man | Registration Page</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition register-page">

<div class="row">
  <div class="col-6">
      
  </div>
</div>

  <div class="register-box">
    <div class="register-logo">
      <img src="dist/img/stark-industries-login.png" alt="Stark Industries Logo" style="width: 80%;">
    </div>

    <div class="card">
      <div class="card-body register-card-body">
        <p class="login-box-msg">Register a new User</p>
        <?php
        // Error messages

          if (isset($_GET['error'])) {
              if ($_GET['error'] == 'emptyfields') {
                  echo '<p class="text-danger text-center">Fill in all required fields</p>';
              } elseif ($_GET['error'] == 'invalidemailname') {
                  echo '<p class="text-danger text-center">Invalid Name and Email</p>';
              } elseif ($_GET['error'] == 'invalidemail') {
                echo '<p class="text-danger text-center">Invalid Email</p>';
              } elseif ($_GET['error'] == 'invalidname') {
                echo '<p class="text-danger text-center">Invalid Name</p>';
              } elseif ($_GET['error'] == 'passwordcheck') {
                echo '<p class="text-danger text-center">Passwords do not match</p>';
              } elseif ($_GET['error'] == 'sqlerror') {
                echo '<p class="text-danger text-center">There was a database error, please try again later</p>';
              } elseif ($_GET['error'] == 'emailtaken') {
                echo '<p class="text-danger text-center">User already exists</p>';
              }
          }

      ?>
        <form action="includes/register.inc.php" method="post">
          <div class="input-group mb-3">
            <!-- Users Full Name -->
            <input type="text" class="form-control" placeholder="Full name" name="user" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <!-- Users Email Address -->
            <input type="email" class="form-control" placeholder="Email" name="email" required
              pattern="^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <!-- Users Password -->
            <input type="password" class="form-control" placeholder="Password" name="pwd" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <!-- Users Password Repeat -->
            <input type="password" class="form-control" placeholder="Retype password" name="pwd-repeat" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-8">
              <div class="icheck-primary" style="margin-bottom: 1rem !important;">
                <!-- Check if user will be an Admin, Unchecked will make user a normal user -->
                <input type="checkbox" id="makeAdmin" name="user-admin" value="1">
                <label for="makeAdmin">
                  Make User an Admin?
                </label>
              </div>
            </div>
          </div>
          <!-- /.col -->
          <div class="row">
            <!-- /.col -->
            <div class="col-6">
              <!-- Submit Button -->
              <button type="submit" class="btn btn-primary btn-block" name="register-submit">Register User</button>
            </div>
            <div class="col-4">
              <!-- Go back to Users page -->
              <a href="contacts.php" class="btn btn-block bg-red">Go Back</a>
            </div>
            <!-- /.col -->
          </div>
        </form>

      </div>
      <!-- /.form-box -->
    </div><!-- /.card -->
  </div>
  <!-- /.register-box -->

  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>
</body>

</html>
