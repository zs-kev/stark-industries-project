<?php

if (isset($_POST['profile-submit'])) {

    session_start();
    
    require 'dbh.inc.php';

    $email = htmlspeicalchars($_POST['email']);
    $userPwd = htmlspeicalchars($_POST['pwd']);
    $userPwdRepeat = htmlspeicalchars($_POST['pwd-repeat']);
    $userPic = htmlspeicalchars($_POST['pic']);
    $idSession = htmlspeicalchars($_SESSION['userId']);
    $emailSession = htmlspeicalchars($_SESSION['userEmail']);

    // if passwords do not match
    if ($userPwd !== $userPwdRepeat) {
        header("Location: ../profile.php?error=passwordcheck");
        exit();

    // If Passwords are empty and the session Email = the email in the field
    } else if ((empty($userPwd) || empty($userPwdRepeat)) && ($email == $emailSession)) {
        header("Location: ../profile.php");
        exit();

    // Change password and email
    } else if (($userPwd == $userPwdRepeat) && ($email != $emailSession)) {

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
        
            $sql = "UPDATE users SET emailUsers=?, pwdUsers=? WHERE idUsers=?";
            $stmt = mysqli_stmt_init($conn);
            
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: ../profile.php?error=sqlerror");
                exit();
            } else {

                $hashedPwd = password_hash($userPwd, PASSWORD_DEFAULT);

                mysqli_stmt_bind_param($stmt, "ssi", $email, $hashedPwd, $idSession);
                mysqli_stmt_execute($stmt);

                // Refresh the session to display updated email
                $_SESSION['userEmail'] = $_POST['email'];
                $email = $_SESSION['userEmail'];
                header("Location: ../profile.php?success");
                exit();

            }
        }

    // Change email but not password
    } else if ((empty($userPwd) || empty($userPwdRepeat)) && ($email != $emailSession)) {

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
            
            if ($resultCheck > 0) {
                header("Location: ../profile.php?error=emailtaken");
                exit();
            } else {

                $sql = "UPDATE users SET emailUsers=? WHERE idUsers=?";
                $stmt = mysqli_stmt_init($conn);
                
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header("Location: ../profile.php?error=sqlerror");
                    exit();
                } else {

                    mysqli_stmt_bind_param($stmt, "si", $email, $idSession);
                    mysqli_stmt_execute($stmt);

                    // Refresh the session to display updated email
                    $_SESSION['userEmail'] = $_POST['email'];
                    $email = $_SESSION['userEmail'];
                    header("Location: ../profile.php?success");
                    exit();

                }
            }
        }

    // Change password but not email
    } else if (($userPwd == $userPwdRepeat) && ($email == $emailSession)) {
            
        $sql = "SELECT * FROM users WHERE emailUsers=?";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../profile.php?error=sqlerror");
            exit();
        } else {

            mysqli_stmt_bind_param($stmt, "s", $userPwd);
            mysqli_stmt_execute($stmt);
            // mysqli_stmt_store_result($stmt);
            // $resultCheck = mysqli_stmt_num_rows($stmt);
            
            $sql = "UPDATE users SET pwdUsers=? WHERE idUsers=?";
            $stmt = mysqli_stmt_init($conn);
                
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: ../profile.php?error=sqlerror");
                exit();
            } else {

                $hashedPwd = password_hash($userPwd, PASSWORD_DEFAULT);

                mysqli_stmt_bind_param($stmt, "si", $hashedPwd, $idSession);
                mysqli_stmt_execute($stmt);

                header("Location: ../profile.php?success");
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