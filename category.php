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
              <?php
              // Pull in category name from side menu

                $category = htmlspecialchars($_GET['category']);
              
                echo '<h1 style="display: inline-block; padding-right: 10px;">'.$category.'</h1>
                      <a href="editcategory.php?changeCat='.$category.'">
                      <i class="fas fa-pencil-alt"></i>
                      </a>
                  </div>
                    <div class="col-sm-6">
                      <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">'.$category.'</li>
                      </ol>
                    </div>';

              ?>
            </div>
          </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">

        <!-- Default box -->
        <div class="card">
          <div class="card-header">
            <a href="product-add.php?forcategory=<?= $category; ?>" class="btn btn-primary btn-sm">
              <i class="fas fa-plus"></i>
              Add Item
            </a>
            <?php
            //Checks to see if there are NO products in the products database that match with the category.

              if (isset($_SESSION['userAdmin'])) {
                  
                include('includes/dbh.inc.php');
                  
                $category = htmlspecialchars($_GET['category']);

                $sql = "SELECT * FROM categories WHERE NOT EXISTS (SELECT 1 FROM products WHERE products.categoryid = categories.idCategory)";  
                $result = mysqli_query($conn, $sql);

                while($row = mysqli_fetch_array($result)) {
                  if ($category == $row['nameCategory']) {
                      
                    echo '<a href="includes/itemchange.inc.php?removeCat='.$row['idCategory'].'" class="btn btn-danger btn-sm float-right" >
                            <i class="fas fa-trash"></i>
                              Delete Category
                          </a>'; 
                  }
                }
              }
            ?>
          </div>
          <div class="card-body p-0">
            <table class="table table-striped projects">
              <thead>
                <tr>
                  <th style="width: 1%">
                    #
                  </th>
                  <th style="width: 20%">
                    Name
                  </th>
                  <th style="width: 30%">
                    Description
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
                // Pulls in items from database and joins them to their respective catagories

                  include('includes/dbh.inc.php');

                  $category = htmlspecialchars($_GET['category']);

                  $sql = "SELECT * FROM products LEFT JOIN categories ON products.categoryid = categories.idCategory ORDER BY idProduct DESC";
                  $result = mysqli_query($conn, $sql);

                  if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_array($result)) {
                      if ($category === $row['nameCategory']) {

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
                                '.$row['amountProduct'].'
                            </td>
                            <td class="project-actions text-right">
                        <!--    <a class="btn btn-primary btn-sm" href="#">
                                    <i class="fas fa-folder">
                                    </i>
                                    View
                                </a>-->

                                <!-- Only admins can edit and remove items -->
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
