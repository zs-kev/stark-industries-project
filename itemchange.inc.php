<?php

session_start();

// Delete Category
if (isset($_GET['removeCat']) && isset($_SESSION['userAdmin'])) {
    
    require 'dbh.inc.php';

    $delete = htmlspecialchars($_GET['removeCat']);

    $sql = "SELECT * FROM categories WHERE idCategory=?";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {

        header("Location: ../index.php?error=sqlerror");
        exit();

    } else {

        mysqli_stmt_bind_param($stmt, "s", $delete);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        $sql = "DELETE FROM categories WHERE idCategory=?";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {

            header("Location: ../index.php?error=sqlerror");
            exit();

        } else {

            mysqli_stmt_bind_param($stmt, "s", $delete);
            mysqli_stmt_execute($stmt);

            header("Location: ../index.php?success=categorydeleted");
            exit();

        }
    }

// Change Category Name
} else if (isset($_POST['category-edit']) && isset($_SESSION['userAdmin'])) { 

    require 'dbh.inc.php';

    $changeCategory = htmlspecialchars($_POST['cat-name']);
    $origCategory = htmlspecialchars($_POST['category']);
    
    if ( $origCategory == $changeCategory) {
        header("Location: ../index.php?error=categoryalreadyexists");
    } else {
    
        $sql = "SELECT * FROM categories WHERE nameCategory=?";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {

            header("Location: ../index.php?error=sqlerror");
            exit();

        } else {

            mysqli_stmt_bind_param($stmt, "s", $origCategory);
            mysqli_stmt_execute($stmt);
            
            $result = mysqli_stmt_get_result($stmt);

            if ($row = mysqli_fetch_assoc($result)) {

                if ($origCategory == $row['nameCategory']) {
                    $catId = $row['idCategory'];
                }

                $sql = "UPDATE categories SET nameCategory=? WHERE idCategory=?";
                $stmt = mysqli_stmt_init($conn);

                if (!mysqli_stmt_prepare($stmt, $sql)) {

                    header("Location: ../index.php?error=sqlerror");
                    exit();

                } else {

                    mysqli_stmt_bind_param($stmt, "ss", $changeCategory, $catId);
                    mysqli_stmt_execute($stmt);

                    header("Location: ../index.php?success=categorychanged");
                    exit();

                }
            }
        }
    }

// Delete Items
} else if (isset($_GET['removeItem']) && isset($_SESSION['userAdmin'])) {

    require 'dbh.inc.php';

    $deleteItem = htmlspecialchars($_GET['removeItem']);

    $sql = "SELECT * FROM products WHERE idProduct=?";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {

        header("Location: ../index.php?error=sqlerror");
        exit();

    } else {

        mysqli_stmt_bind_param($stmt, "i", $deleteItem);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        $sql = "DELETE FROM products WHERE idProduct=?";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {

            header("Location: ../index.php?error=sqlerror");
            exit();

        } else {

            mysqli_stmt_bind_param($stmt, "i", $deleteItem);
            mysqli_stmt_execute($stmt);

            header("Location: ../index.php?succsess=itemdeleted");
            exit();

        }
    }

// Edit Items
} else if (isset($_POST['editItem']) && isset($_SESSION['userAdmin'])) {

    require 'dbh.inc.php';

    $productName = htmlspecialchars($_POST['p-name']);
    $productDesc = htmlspecialchars($_POST['p-description']);
    $productQuantity = htmlspecialchars($_POST['p-quantity']);
    $productCategory = htmlspecialchars($_POST['p-category']);
    $productId = htmlspecialchars($_POST['p-id']);
    $categoryId = htmlspecialchars($_POST['categoryid']);

    if (empty($productName) || empty($productDesc) || empty($productCategory)) {

        header("location:javascript://history.go(-1)");
        exit();

    } else if ($productQuantity < 0) {

        header("location: ../product-edit.php?productedit=$productId&forcategory=$categoryName&error=quantitycannotbenegative");

    } else {

        $sql = "SELECT * FROM products LEFT JOIN categories ON products.categoryid = categories.idCategory";
        $result = mysqli_query($conn, $sql);

        if (!$result) {

            header("Location: ../product-edit.php?productedit=$productId&forcategory=$categoryName&error=sqlerror");
            exit();

        } else {

            mysqli_num_rows($result);
            
            while ($row = mysqli_fetch_array($result)) {
                if ($productCategory === $row['nameCategory']) {
                    
                    $categoryName = $row['nameCategory'];
                    $categoryId = $row['idCategory'];

                    $sql = "UPDATE products SET nameProduct=?, descProduct=?, amountProduct=?, categoryid=? WHERE idProduct=?";
                    $stmt = mysqli_stmt_init($conn);

                    if (!mysqli_stmt_prepare($stmt, $sql)) {

                        header("Location: ../product-edit.php?productedit=$productId&forcategory=$categoryName&error=sqlerror");
                        exit();

                    } else {

                        mysqli_stmt_bind_param($stmt, "ssiii", $productName, $productDesc, $productQuantity, $categoryId, $productId);
                        mysqli_stmt_execute($stmt);

                        header("Location: ../product-edit.php?productedit=$productId&forcategory=$categoryName&success=itemupdated");
                        exit();

                    }
                } else {

                    header("Location: ../product-edit.php?productedit=$productId&forcategory=$categoryName&error=categorydoesnotexist");

                }
            }
        }
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);

} else {

    header("Location: ../index.php");
    exit();

}