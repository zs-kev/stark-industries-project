<?php

  include('header.php');

  $forCategory = htmlspecialchars($_GET['forcategory']);

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
              <h1>New Product</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item"><a
                    href="category.php?category=<?= $forCategory; ?>"><?= $forCategory; ?></a></li>
                <li class="breadcrumb-item active">New Product</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="row justify-content-center">
          <div class="col-md-6">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Add Product</h3>
              </div>

              <div class="card-body">
                <div class="form-group">
                  <form action="includes/productadd.inc.php" method="post">
                    <label for="inputName">Product Name</label>
                    <input type="text" id="inputName" class="form-control" required name="p-name">
                </div>
                <div class="form-group">
                  <label for="inputDescription">Product Description</label>
                  <textarea id="inputDescription" class="form-control" rows="4" required
                    name="p-description"></textarea>
                </div>
                <div class="form-group">
                  <label for="p-category">Category</label>
                  <select class="form-control custom-select" required name="p-category">
                    <?php
                    // Fetches the categories from the database to display in dropdown list

                      include('includes/dbh.inc.php');

                      // Will default to the categorie that user was on when they clicked add item
                      echo '<option selected>'.$forCategory.'</option>';

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
                  <input type="number" name="p-quantity" id="quantity" class="form-control" value="0" step="1">
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
            <button type="submit" class="btn btn-success float-right" name="product-submit">Add Product</button>
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
