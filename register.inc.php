<?php

session_start();

if (isset($_POST['register-submit']) && isset($_SESSION['userAdmin'])) {
    
    require 'dbh.inc.php';

    $userName = htmlspecialchars($_POST['user']);
    $userEmail = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $userPwd = htmlspecialchars($_POST['pwd']);
    $userPwdRepeat = htmlspecialchars($_POST['pwd-repeat']);
    $userAdmin = htmlspecialchars($_POST['user-admin']);

    // If fields are empty
    if (empty($userName) || empty($userEmail) || empty($userPwd) || empty($userPwdRepeat)) {
        header("Location: ../register.php?error=emptyfields&user=".$userName."&email=".$userEmail);
        exit();

    // If Email and Name are not valid
    } else if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL) && !preg_match("/^([a-zA-Z' ]+)$/", $userName)) {
        header("Location: ../register.php?error=invalidemailname");
        exit(); 

    // If Email is not valid
    } else if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../register.php?error=invalidemail&user=".$userName);
        exit(); 

    // If Name is not valid
    } else if (!preg_match("/^([a-zA-Z' ]+)$/", $userName)) {
        header("Location: ../register.php?error=invalidname&user-email=".$userEmail);
        exit();

    // If Passwords do not match
    } else if ($userPwd !== $userPwdRepeat) {
        header("Location: ../register.php?error=passwordcheck&user=".$userName."&email=".$userEmail);
        exit();

    } else {

        $sql = "SELECT emailUsers FROM users WHERE emailUsers=?";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../register.php?error=sqlerror");
            exit();
        } else {

            mysqli_stmt_bind_param($stmt, "s", $userEmail);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $resultCheck = mysqli_stmt_num_rows($stmt);

            // If email is already taken
            if ($resultCheck > 0) {
                header("Location: ../register.php?error=emailtaken&user=".$userName);
                exit();

            } else {

                $sql = "INSERT INTO users (nameUsers, emailUsers, pwdUsers, adminUsers) VALUES (?, ?, ?, ?)";
                $stmt = mysqli_stmt_init($conn);

                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header("Location: ../register.php?error=sqlerror");
                    exit();
                } else {

                    $hashedPwd = password_hash($userPwd, PASSWORD_DEFAULT);

                    mysqli_stmt_bind_param($stmt, "sssi", $userName, $userEmail, $hashedPwd, $userAdmin);
                    mysqli_stmt_execute($stmt);

                    header("Location: ../contacts.php?success=userregistered");
                    exit();

                }
            }
        }

    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);

} else {
    header("Location: ../register.php");
    exit();
}