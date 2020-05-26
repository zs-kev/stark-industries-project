<?php

  include('header.php');
  include('includes/dbh.inc.php');
  
  $forCategory = htmlspecialchars($_GET['forcategory']);
  $productId = htmlspecialchars($_GET['productedit']);

  // Fetches the product from the database
  $sql = "SELECT * FROM products WHERE idProduct='$productId'";

  if($result = mysqli_query($conn, $sql)) {
    if(mysqli_num_rows($result) > 0) {
      while($row = mysqli_fetch_array($result)) {
        $productName = $row['nameProduct'];
        $productDesc = $row['descProduct'];
        $productQuantity = $row['amountProduct'];
        $categoryId = $row['categoryid'];
      }
    }
  }

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
              <h1><?= $productName; ?></h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item"><a
                    href="category.php?category=<?= $forCategory; ?>"><?= $forCategory; ?></a></li>
                <li class="breadcrumb-item active"><?= $productName; ?></li>
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
                  if ($_GET['success'] == "itemupdated") {
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

                        } else if ($_GET['error'] == "quantitycannotbenegative") {
                  
                          echo '<div class="alert alert-danger alert-dismissible">
                                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                      <h5><i class="icon fas fa-ban"></i> Error!</h5>
                                      Quantity cannot be less than 0
                              </div>';

                          }
              }

              ?>
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-md-6">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Edit Product</h3>
              </div>

              <div class="card-body">
                <div class="form-group">
                  <form action="includes/itemchange.inc.php" method="post">
                    <label for="inputName">Product Name</label>
                    <input type="text" id="inputName" class="form-control" required name="p-name"
                      value="<?= $productName; ?>">
                    <input type="text" style="display: none;" id="productid" class="form-control" name="p-id"
                      value="<?= $productId; ?>">
                    <input type="text" style="display: none;" id="categoryid" class="form-control" name="categoryid"
                      value="<?= $categoryId; ?>">
                </div>
                <div class="form-group">
                  <label for="inputDescription">Product Description</label>
                  <textarea id="inputDescription" class="form-control" rows="4" required
                    name="p-description"><?= $productDesc; ?></textarea>
                </div>
                <div class="form-group">
                  <label for="p-category">Category</label>
                  <select class="form-control custom-select" required name="p-category">
                    <?php
                  
                      include('includes/dbh.inc.php');
                  
                      echo '<option selected>'.$forCategory.'</option>';

                      // Fetches categories from database
                      $sql = "SELECT * FROM categories";

                      if($result = mysqli_query($conn, $sql)) {
                        if(mysqli_num_rows($result) > 0) {
                          while($row = mysqli_fetch_array($result)) {
                            if ($row['nameCategory'] != $forCategory) {
                            
                              $category = $row['nameCategory'];
                    
                              echo '<option value="'.$category.'">'.$category.'</option>';
                    
                            }
                          }
                        }
                      }

                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="p-quantity">Quantity</label>
                  <input type="number" name="p-quantity" id="quantity" class="form-control"
                    value="<?= $productQuantity; ?>" step="1">
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-6">
            <a href="category.php?category=<?= $forCategory; ?>" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-success float-right" name="editItem">Save Changes</button>
          </div>
        </div>
        </form>
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <?php

  include('footer.php');

?>
