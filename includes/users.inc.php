<?php

session_start();

// Change Admin rights
if (isset($_GET['changeAdmin']) && isset($_SESSION['userAdmin'])) {
    
    require 'dbh.inc.php';

    $editAdmin = htmlspecialchars($_GET['changeAdmin']);

    $sql = "SELECT adminUsers FROM users WHERE idUsers='$editAdmin'";
    $result = mysqli_query($conn, $sql);

    $row = mysqli_fetch_array($result);

    if (!$row['adminUsers']) {

        $newResult = 1;

    } else {

        $newResult = "NULL";

    }

    mysqli_query($conn, "UPDATE users SET adminUsers=$newResult WHERE idUsers='$editAdmin'");

    header("Location: ../contacts.php");

// Remove user
} else if (isset($_GET['removeUser']) && isset($_SESSION['userAdmin'])) {

    require 'dbh.inc.php';

    $userRemove = htmlspecialchars($_GET['removeUser']);

    $sql = "DELETE FROM users WHERE idUsers='$userRemove'";
    mysqli_query($conn, $sql);

    header("Location: ../contacts.php?success=userremoved");

} else {

    header("Location: ../index.php");
    exit();

}