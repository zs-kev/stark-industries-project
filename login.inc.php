<?php

if(isset($_POST['login-submit'])) {

    require 'dbh.inc.php';

    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['pwd']);

    // If email or password fields are left empty
    if (empty($email) || empty($password)) {

        header("Location: ../login.php?error=emptyfields");
        exit();
        
    } else {

        $sql = "SELECT * FROM users WHERE emailUsers=?";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {

            header("Location: ../login.php?error=sqlerror");
            exit();

        } else {

            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);

            if ($row = mysqli_fetch_assoc($result)) {

                $pwdCheck = password_verify($password, $row['pwdUsers']);

                if ($pwdCheck == false) {

                    header("Location: ../login.php?error=wrongpassword");
                    exit();

                } else if ($pwdCheck == true) {

                    session_start();

                    $_SESSION['userId'] = $row['idUsers'];
                    $_SESSION['userEmail'] = $row['emailUsers'];
                    $_SESSION['userName'] = $row['nameUsers'];
                    $_SESSION['userAdmin'] = $row['adminUsers'];
                    $_SESSION['userAbout'] = $row['roleUsers'];
                    $_SESSION['userContact'] = $row['contactUsers'];
                    $_SESSION['userPic'] = $row['picUsers'];

                    header("Location: ../index.php");
                    exit();

                }
            
            } else {

                header("Location: ../login.php?error=nouser");
                exit();

            }
        }
    }

} else {

    header("Location: ../login.php");
    exit();

}