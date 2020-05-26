<?php

  include('header.php');
  
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Users</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active">Users</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
  <div class="row">
        <div class="col-6">

          <?php

            if (isset($_GET['success'])) {
              if ($_GET['success'] == "userregistered") {
                echo '<div class="card-body">
                        <div class="alert alert-success alert-dismissible">
                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                          <h5><i class="icon fas fa-check"></i> Success!</h5>
                          User has successfully been added.
                        </div>
                      </div>';
              } else if ($_GET['success'] == "userremoved") {
                echo '<div class="card-body">
                        <div class="alert alert-success alert-dismissible">
                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                          <h5><i class="icon fas fa-check"></i> Success!</h5>
                          User has successfully been deleted.
                        </div>
                      </div>';
              }

            } else if (isset($_GET['error'])) {
              if ($_GET['error'] == "sqlerror") {
              
                  echo '<div class="alert alert-danger alert-dismissible">
                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                              <h5><i class="icon fas fa-ban"></i> Error!</h5>
                              There was a problem connecting to the database, please try again later.
                      </div>';

              }
            }

          ?>

        </div>
      </div>

    <!-- Default box -->
    <div class="card card-solid">
      <div class="card-body pb-0">
        <div class="row d-flex align-items-stretch">

          <!-- Add New User Box -->
          <?php
          // Only admins can add new members

            if (isset($_SESSION['userAdmin'])) {
              echo
                '<div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
                  <div class="card bg-light" style="width: 100%;">
                    <div class="card-header text-muted border-bottom-0">
                      <h3>Add New User</h3>
                    </div>
                    <div class="card-body pt-0" style="display: flex; justify-content: center; align-items: center;">
                      <div class="row">
                        <div class="col-6 text-center">
                          <a href="register.php"><i class="fas fa-plus-circle" style=" font-size: 6em; color: teal;"></i></a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>';
            }
          ?>

          <!-- Users Box -->
          <?php 
          // Imports user data from the database

            include('includes/dbh.inc.php');

            $sql = "SELECT * FROM users ORDER BY idUsers DESC";
            
            if($result = mysqli_query($conn, $sql)) {
              if(mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_array($result)) {
                  
                  $name = $row['nameUsers'];
                  $email = $row['emailUsers'];
                  $admin = $row['adminUsers'];
                  $role = $row['roleUsers'];
                  $contact = $row['contactUsers'];
                  $id = $row['idUsers'];
                  $picId = $row['picUsers'];

                  if ($admin) {
                    $userAdmin = "Admin";
                    $addRemoveAdmin = "Make User";
                  } else {
                      $userAdmin = "User";
                      $addRemoveAdmin = "Make Admin";
                  }

                  $fileName = "uploads/".$picId."*";
                  $filePath = glob($fileName);
                  $fileExt = explode(".", $filePath['0']);
                  $fileActualExt = $fileExt[1];

                  if ($id == $picId) {
                    $profilePic = "uploads/".$picId."."."$fileActualExt";
                  } else {
                    $profilePic = "uploads/profile_default_image_stkindustries2020.jpg";
                  }

                  echo
                    '<div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
                      <div class="card bg-light" style="width: 100%;">
                        <div class="card-header text-muted border-bottom-0">'
                        .$userAdmin.
                        '</div>
                        <div class="card-body pt-0">
                          <div class="row">
                            <div class="col-7">
                              <h2 class="lead"><b>' .$name. '</b></h2>
                              <p class="text-muted text-sm"><b>About: </b> '.$role.'</p>
                              <ul class="ml-4 mb-0 fa-ul text-muted">
                                <li class="small" style="padding-bottom: 10px;"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span>Contact: '.$contact.'</li>
                                <li class="small"><span class="fa-li"><i class="fas fa-lg fa-envelope"></i></span>Email:<a href="mailto:'.$email.'"> '.$email.'</a></li>
                              </ul>
                            </div>
                            <div class="col-5 text-center">
                              <img src="'.$profilePic.'" alt="" class="img-circle img-fluid">
                            </div>
                          </div>
                        </div>
                        <div class="card-footer">
                          <div class="text-right">';

                          // Check to make sure current logged in admin user cant delete themselves or make themselves a user
                          if (($_SESSION['userId'] != $id) && (isset($_SESSION['userAdmin']))) {
                            echo
                              '<a href="includes/users.inc.php?removeUser='.$row['idUsers'].'" data-confirm="Are you sure you want to delete the user '.$name.'?" class="btn btn-sm bg-red delete">
                                  <i class="fas fa-times"></i>
                              </a>
                              <a href="includes/users.inc.php?changeAdmin='.$row['idUsers'].'" class="btn btn-sm btn-primary">
                                  <i class="fas fa-user"></i> '.$addRemoveAdmin.'
                              </a>';
                          }

                  // Closing div's for the ones above the if statement
                  echo '</div>
                    </div>
                  </div>
                </div>';
                }
                // END WHILE

              } else {
                // If no users exits

                  echo 
                    '<div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
                      <div class="card bg-light" style="width: 100%;">
                        <div class="card-header text-muted border-bottom-0">
                          No users exist
                        </div>
                      </div>
                    </div>';
                }
            } else {
              // If there is a database error

                echo 
                  '<div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
                    <div class="card bg-light" style="width: 100%;">
                      <div class="card-header text-muted border-bottom-0">
                      mySQL Error, please try again later
                      </div>
                    </div>
                  </div>';
            }

          ?>
          <!-- End of User Box -->
        </div>
      </div>
      <!-- /.card-body -->

      <div class="card-footer">
        <nav aria-label="Contacts Page Navigation">
          <ul class="pagination justify-content-center m-0">
            <li class="page-item active"><a class="page-link" href="#">1</a></li>
          </ul>
        </nav>
      </div>
      <!-- /.card-footer -->
    </div>
    <!-- /.card -->

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php

  include('footer.php');
  
?>
