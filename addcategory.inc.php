<?php

session_start();

if (isset($_POST['category-add']) && isset($_SESSION['userAdmin'])) {

    require 'dbh.inc.php';

    $name = htmlspecialchars($_POST['cat-name']);

    // If name field is empty
    if (empty($name)) {

        header("Location: ../category-add?error=categoryfieldempty");
        exit();

    } else {

        $sql = "SELECT * FROM categories WHERE nameCategory=?";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {

            header("Location: ../category-add.php?error=sqlerror");
            exit();

            } else {

                mysqli_stmt_bind_param($stmt, "s", $name);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);

                $result = mysqli_stmt_num_rows($stmt);

                if ($result > 0) {

                    header("Location: ../category-add.php?error=categoryalreadyexists");
                    exit();

                } else {

                    $sql = "INSERT INTO categories (nameCategory) VALUES (?)";
                    $stmt = mysqli_stmt_init($conn);

                    if (!mysqli_stmt_prepare($stmt, $sql)) {

                        header("Location: ../category-add.php?error=sqlerror");
                        exit();

                } else {

                    mysqli_stmt_bind_param($stmt, "s", $name);
                    mysqli_stmt_execute($stmt);

                    header("Location: ../category-add.php?success");
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