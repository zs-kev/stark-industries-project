<?php

  include('header.php');

?>

<body class="hold-transition sidebar-mini">
  <!-- Site wrapper -->
  <div class="wrapper">

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Search Results</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Search Results</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">

        <!-- Default box -->
        <div class="card">
          <?php

            // Pull in products and categories from Database

            include('includes/dbh.inc.php');

            if (isset($_POST['search-submit'])) {

              $search = mysqli_real_escape_string($conn, $_POST['search']);

              $sql = "SELECT * FROM products LEFT JOIN categories ON products.categoryid = categories.idCategory WHERE products.nameProduct LIKE '%$search%' OR categories.nameCategory LIKE '%$search%' ORDER BY dateAdded DESC";
              $result = mysqli_query($conn, $sql);

              $sqlUser = "SELECT * FROM USERS WHERE nameUsers LIKE '%$search%' OR emailUsers LIKE '%$search%' OR contactUsers LIKE '%$search%' OR roleUsers LIKE '%$search%'";
              $resultUser = mysqli_query($conn, $sqlUser);

              $queryResult = mysqli_num_rows($result);
              $queryUser = mysqli_num_rows($resultUser);

              if ($queryResult > 0) {

                // Only admins can add items
                if (isset($_SESSION['userAdmin'])) {

                  echo
                    '<div class="card-header">
                      <h3>Items</h3>
                    </div>';

                }

                echo      
                  '<div class="card-body p-0">
                      <table class="table table-striped projects">
                        <thead>
                          <tr>
                            <th style="width: 1%">
                              #
                            </th>
                            <th style="width: 15%">
                              Name
                            </th>
                            <th style="width: 40%">
                              Description
                            </th>
                            <th style="width: 15%">
                              Category
                            </th>
                            <th style="width: 9%">
                              Quantity
                            </th>
                            <th style="width: 20%">
                            </th>
                          </tr>
                        </thead>';
              
                        while ($row = mysqli_fetch_assoc($result)) {
                          
                          echo '<tbody>
                                  <tr>
                                    <td>
                                      #
                                    </td>
                                    <td>
                                      <a>
                                        '.$row['nameProduct'].'
                                      </a>
                                      <br/>
                                      <small>
                                        Added '.$row['dateAdded'].'
                                      </small>
                                    </td>
                                    <td>
                                      <p>'.$row['descProduct'].'</p>
                                    </td>
                                    <td>
                                      <p>'.$row['nameCategory'].'</p>
                                    </td>
                                    <td>
                                      '.$row['amountProduct'].'
                                    </td>
                                    <td class="project-actions text-right">
                                 <!-- <a class="btn btn-primary btn-sm" href="#">
                                        <i class="fas fa-folder">
                                        </i>
                                          View
                                      </a>-->
                                      <!-- Only admins are allowed to edit and delete -->
                                          '.(isset($_SESSION['userAdmin']) ?
                                
                                          '<a class="btn btn-info btn-sm" href="product-edit.php?productedit='.$row['idProduct'].'&forcategory='.$row['nameCategory'].'">
                                              <i class="fas fa-pencil-alt">
                                              </i>
                                              Edit
                                          </a>
                                          <a class="btn btn-danger btn-sm" href="includes/itemchange.inc.php?removeItem='.$row['idProduct'].'">
                                              <i class="fas fa-trash">
                                              </i>
                                              Delete
                                          </a>' : '').'
                                      </td>
                                    </tr>
                                  </tbody>';
                        }
                        // Close table  
                        echo '</table>';

                    } 
                      if ($queryUser > 0) {
                        while ($row = mysqli_fetch_assoc($resultUser)) {

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
                            '<div class="card-header">
                              <h3>Users</h3>
                            </div>
                            <div class="card-body pb-0">
                              <div class="row d-flex align-items-stretch">
                                <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
                                  <div class="card bg-light" style="width: 100%;">
                                    <div class="card-header text-muted border-bottom-0">
                                      '.$userAdmin.'
                                    </div>
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
                                          '<a href="includes/users.inc.php?removeUser='.$row['idUsers'].'" class="btn btn-sm bg-red">
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
                                </div>
                              </div>
                            </div>';

                        }

                    } 
                    if ($queryResult == 0 && $queryUser == 0) {
                        // If no results found

                        echo '<div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h5><i class="icon fas fa-ban"></i> No Results!</h5>
                                No results Found for '.$search.'
                        </div>';

                    }

            }
                    
          ?>

        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php

  include('footer.php');

?>