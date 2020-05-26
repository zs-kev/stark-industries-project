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
              <h1>All Items</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">All Items</li>
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
          // Only admins can add items

          if (isset($_SESSION['userAdmin'])) {
            echo
              '<div class="card-header">
                <a href="product-add.php" class="btn btn-primary btn-sm">
                  <i class="fas fa-plus"></i>
                  Add Item
                </a>
              </div>';
          }

          ?>
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
                  <th style="width: 20%">
                  </th>
                </tr>
              </thead>
              <tbody>
                <?php
                  // Pull in products and categories from Database

                  include('dbh.inc.php');

                  $category = htmlspecialchars($_GET['category']);

                  $sql = "SELECT * FROM products LEFT JOIN categories ON products.categoryid = categories.idCategory ORDER BY idProduct DESC";
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
                          <td class="project-actions text-right">
                        <!--  <a class="btn btn-primary btn-sm" href="#">
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
                                  <a class="btn btn-danger btn-sm delete" href="includes/itemchange.inc.php?removeItem='.$row['idProduct'].'" data-confirm="Are you sure you want to delete the item '.$row['nameProduct'].'?">
                                      <i class="fas fa-trash">
                                      </i>
                                      Delete
                                  </a>' : '').'
                            </td>
                          </tr>';
                    }
                  }
                ?>
              </tbody>
            </table>
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