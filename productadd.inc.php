<?php

session_start();

if (isset($_POST['product-submit']) && isset($_SESSION['userAdmin'])) {

    require 'dbh.inc.php';

    $productName = htmlspecialchars($_POST['p-name']);
    $productDesc = htmlspecialchars($_POST['p-description']);
    $productQuantity = htmlspecialchars($_POST['p-quantity']);
    $productCategory = htmlspecialchars($_POST['p-category']);
    $currentDate = date("Y.m.d");

    // If any of the fields are empty
    if (empty($productName) || empty($productDesc) || empty($productCategory)) {
        header("location:javascript://history.go(-1)");
        exit();

    // Product quantity cannot be less than 0
    } else if ($productQuantity < 0) {
        header("location: ../index.php?error=quantitycannotbenegative");
    } else {

        $sqlCat = "SELECT * FROM categories WHERE nameCategory=?";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sqlCat)) {
            header("Location: ../index.php?error=sqlerror");
            exit();
        } else {

            mysqli_stmt_bind_param($stmt, "s", $productCategory);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);

            if ($row = mysqli_fetch_assoc($result)) {

                $categoryId = $row['idCategory'];

                $sqlProduct = "INSERT INTO products (nameProduct, descProduct, amountProduct, categoryid, dateAdded) VALUES (?, ?, ?, ?, ?)";
                $stmt = mysqli_stmt_init($conn);

                if (!mysqli_stmt_prepare($stmt, $sqlProduct)) {
                    header("Location: ../index.php?error=sqlerror");
                    exit();
                } else {

                    mysqli_stmt_bind_param($stmt, "ssiis", $productName, $productDesc, $productQuantity, $categoryId ,$currentDate);
                    mysqli_stmt_execute($stmt);

                    header("Location: ../index.php?success");
                    exit();
                    
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