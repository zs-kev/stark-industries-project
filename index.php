<?php

  include('header.php');

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Home</h1>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-6">

          <?php

            if (isset($_GET['success'])) {
                if ($_GET['success'] == "categorydeleted") {
                
                    echo '<div class="card-body">
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h5><i class="icon fas fa-check"></i> Success!</h5>
                                Category successfully deleted
                            </div>
                        </div>';
  
                    } else if ($_GET['success'] == "categorychanged") {

                        echo '<div class="card-body">
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h5><i class="icon fas fa-check"></i> Success!</h5>
                                Category has been updated
                            </div>
                        </div>';

                    } else if ($_GET['success'] == "itemdeleted") {

                        echo '<div class="card-body">
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h5><i class="icon fas fa-check"></i> Success!</h5>
                                Item has been deleted
                            </div>
                        </div>';

                    } else if ($_GET['success'] == "itemupdated") {

                      echo '<div class="card-body">
                          <div class="alert alert-success alert-dismissible">
                              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                              <h5><i class="icon fas fa-check"></i> Success!</h5>
                              Item has been updated
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
  
                } else if ($_GET['error'] == "categoryalreadyexists") {
                
                    echo '<div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h5><i class="icon fas fa-ban"></i> Error!</h5>
                                Category already exists, please try a different name.
                        </div>';
    
                } else if ($_GET['error'] == "categorydoesnotexist") {
                
                    echo '<div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h5><i class="icon fas fa-ban"></i> Error!</h5>
                                Category does not exist
                        </div>';
        
                }
              }

          ?>

        </div>
      </div>

      <div class="row">

        <div class="col-3">

          <!-- Category Card -->
          <div class="small-box bg-success">
            <div class="inner">
              <?php 

                include('includes/dbh.inc.php');

                $sql = "SELECT COUNT(*) FROM categories";
                $result = mysqli_query($conn, $sql);
                $count = mysqli_fetch_assoc($result)['COUNT(*)'];  

                echo '<h3>'.$count.'</h3>'

              ?>

              <p>Total Categories</p>
            </div>
            <div class="icon">
              <i class="fas fa-chart-pie"></i>
            </div>
          </div>

          <!-- Item Card -->
          <div class="small-box bg-info">
            <div class="inner">
              <?php 

              include('includes/dbh.inc.php');

              $sql = "SELECT COUNT(*) FROM products";
              $result = mysqli_query($conn, $sql);
              $count = mysqli_fetch_assoc($result)['COUNT(*)'];  

              echo '<h3>'.$count.'</h3>'

            ?>

              <p>Total Items</p>
            </div>
            <div class="icon">
              <i class="fas fa-shopping-cart"></i>
            </div>
            <a href="allproducts.php" class="small-box-footer">
              View All <i class="fas fa-arrow-circle-right"></i>
            </a>
          </div>

          <!-- Number of Users Card -->
          <div class="small-box bg-warning">
            <div class="inner">
              <?php 

              include('includes/dbh.inc.php');

              $sql = "SELECT COUNT(*) FROM users";
              $result = mysqli_query($conn, $sql);
              $count = mysqli_fetch_assoc($result)['COUNT(*)'];  

              echo '<h3>'.$count.'</h3>'

            ?>


              <p>Total Users</p>
            </div>
            <div class="icon">
              <i class="fas fa-user-plus"></i>
            </div>
            <a href="contacts.php" class="small-box-footer">
              View All <i class="fas fa-arrow-circle-right"></i>
            </a>
          </div>

        </div>
        <!-- /.col-3 -->

        <!-- Recently added items -->
        <div class="col-lg-6">
          <div class="card card-primary card-outline">
            <div class="card-header">
              <h5 class="m-0">Recently Added Items</h5>
            </div>
            <div class="card-body">
              <div class="card-body p-0">
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
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                  
                      include('dbh.inc.php');
                  
                      $category = htmlspecialchars($_GET['category']);
                  
                      $sql = "SELECT * FROM products LEFT JOIN categories ON products.categoryid = categories.idCategory ORDER BY idProduct DESC LIMIT 5";
                  
                      $result = mysqli_query($conn, $sql);
                  
                      if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result)) {                        
                          echo
                          '<tr>
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
                            </tr>';
                        }
                      }
                    ?>
                  </tbody>
                </table>
              </div>

              <a href="allproducts.php" class="btn btn-primary" style="margin-top: 10px;">View All Items</a>
              <?php 
                if (isset($_SESSION['userAdmin'])) {
                  echo 
                  '<a href="product-add.php?forcategory=<?php echo $category; ?>" class="btn btn-primary"
              style="margin-top: 10px;">
              <i class="fas fa-plus"></i>
              Add Item
              </a>';
              }
              ?>
            </div>
          </div><!-- /.card -->
        </div>
        <!-- /.col-lg-6 -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php

  include('footer.php');

?>