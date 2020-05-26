<?php

    include('header.php');

    if (!isset($_SESSION['userAdmin'])) {
        header("Location:index.php");
        exit();
    }

    $category = htmlspecialchars($_GET['changeCat']);

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
              <h1>Edit Category</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Edit Category</li>
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
                <h3 class="card-title">Edit Category</h3>
              </div>
              <div class="card-body">
                <div class="form-group">
                  <form action="includes/itemchange.inc.php" method="post">
                    <label for="inputName">Category Name</label>
                    <input type="text" name="cat-name" id="inputName" class="form-control" value="<?= $category; ?>">
                    <input type="text" name="category" id="inputName" style="display: none;" class="form-control" value="<?= $category; ?>">
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-6">
            <button type="submit" class="btn btn-success" name="category-edit">Save Changes</button>
            <a href="category.php?category=<?= $category; ?>" class="btn btn-secondary">Cancel</a>
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
