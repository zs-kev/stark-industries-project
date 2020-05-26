<?php

    include('header.php');

    if (!isset($_SESSION['userAdmin'])) {
        header("Location:index.php");
        exit();
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
              <h1>Add Category</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Add Category</li>
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
                <h3 class="card-title">New Category</h3>
              </div>
              <div class="card-body">
                <div class="form-group">
                  <form action="includes/addcategory.inc.php" method="post">
                    <label for="inputName">Category Name</label>
                    <input type="text" name="cat-name" id="inputName" class="form-control">
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-6">
            <button type="submit" class="btn btn-success" name="category-add">Add Category</button>
            </form>
          </div>
        </div>
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

<?php

include('footer.php');

?>
