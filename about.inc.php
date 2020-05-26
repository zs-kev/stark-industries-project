<?php

if (isset($_POST['about-submit'])) {

    session_start();
    
    require 'dbh.inc.php';

    $aboutUser = htmlspecialchars($_POST['about']);
    $contactUser = htmlspecialchars($_POST['phone']);
    $aboutSession = htmlspecialchars($_SESSION['userAbout']);
    $contactSession = htmlspecialchars($_SESSION['userContact']);
    $idSession = htmlspecialchars($_SESSION['userId']);
    $emailSession = htmlspecialchars($_SESSION['userEmail']);

    // Checking if both fields have been changed
    if (($aboutUser != $aboutSession) && ($contactUser != $contactSession)) {

        $sql = "SELECT * FROM users WHERE emailUsers=?";
        $stmt = mysqli_stmt_init($conn);
        
        if (!mysqli_stmt_prepare($stmt, $sql)) {

            header("Location: ../profile.php?error=sqlerror");
            exit();

        } else {

            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);

            $resultCheck = mysqli_stmt_num_rows($stmt);

            $sql = "UPDATE users SET roleUsers=?, contactUsers=? WHERE idUsers=?";
            $stmt = mysqli_stmt_init($conn);
                
            if (!mysqli_stmt_prepare($stmt, $sql)) {

                    header("Location: ../profile.php?error=sqlerror");
                    exit();

                } else {

                    mysqli_stmt_bind_param($stmt, "ssi", $aboutUser, $contactUser, $idSession);
                    mysqli_stmt_execute($stmt);

                    // Refresh the session to display updated details
                    $_SESSION['userRole'] = $_POST['about'];
                    $aboutUser = $_SESSION['userRole'];
                    $_SESSION['userContact'] = $_POST['phone'];
                    $phone = $_SESSION['userContact'];

                    header("Location: ../profile.php?success=contactaboutupdated");
                    exit();

                }
            }

      // Checking if contact field has been changed
    } else if (($aboutUser == $aboutSession) && ($contactUser != $contactSession)) {

        $sql = "SELECT * FROM users WHERE emailUsers=?";
        $stmt = mysqli_stmt_init($conn);
        
        if (!mysqli_stmt_prepare($stmt, $sql)) {

            header("Location: ../profile.php?error=sqlerror");
            exit();

        } else {

            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            // mysqli_stmt_store_result($stmt);
            // $resultCheck = mysqli_stmt_num_rows($stmt);

            $sql = "UPDATE users SET contactUsers=? WHERE idUsers=?";
            $stmt = mysqli_stmt_init($conn);
                
            if (!mysqli_stmt_prepare($stmt, $sql)) {

                    header("Location: ../profile.php?error=sqlerror");
                    exit();

                } else {

                    mysqli_stmt_bind_param($stmt, "si", $contactUser, $idSession);
                    mysqli_stmt_execute($stmt);

                    // Refresh the session to display updated details
                    $_SESSION['userContact'] = $_POST['phone'];
                    $phone = $_SESSION['userContact'];

                    header("Location: ../profile.php?success=contactupdated");
                    exit();

                }
            }

      // Checking if about field has been changed
    } else if (($aboutUser != $aboutSession) && ($contactUser == $contactSession)) {

        $sql = "SELECT * FROM users WHERE emailUsers=?";
        $stmt = mysqli_stmt_init($conn);
        
        if (!mysqli_stmt_prepare($stmt, $sql)) {

            header("Location: ../profile.php?error=sqlerror");
            exit();

        } else {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            // mysqli_stmt_store_result($stmt);
            // $resultCheck = mysqli_stmt_num_rows($stmt);

            $sql = "UPDATE users SET roleUsers=? WHERE idUsers=?";
            $stmt = mysqli_stmt_init($conn);
                
            if (!mysqli_stmt_prepare($stmt, $sql)) {

                    header("Location: ../profile.php?error=sqlerror");
                    exit();

                } else {

                    mysqli_stmt_bind_param($stmt, "si", $aboutUser, $idSession);
                    mysqli_stmt_execute($stmt);

                    // Refresh the session to display updated details
                    $_SESSION['userAbout'] = $_POST['about'];
                    $aboutUser = $_SESSION['userAbout'];

                    header("Location: ../profile.php?success=aboutupdated");
                    exit();

                }
            }
        }

        mysqli_stmt_close($stmt);
        mysqli_close($conn);

} else {

    header("Location: ../index.php");
    exit();

}
