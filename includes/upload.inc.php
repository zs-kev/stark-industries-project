<?php 

if (isset($_POST['upload-submit'])) {
    session_start();

    require 'dbh.inc.php';
    
    $file = $_FILES['pic'];

    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];
    $idSession = $_SESSION['userId'];
    $picId = $idSession;

    $oldFileName = "../uploads/".$picId."*";
    $oldFilePath = glob($oldFileName);
    $oldFileExt = explode(".", $oldFilePath['0']);
    $oldFileActualExt = $oldFileExt[3];

    $profilePicture = "../uploads/".$picId."."."$oldFileActualExt";

    if (file_exists($profilePicture)) {
        unlink($profilePicture);
    }

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('jpg', 'jpeg', 'png');

    if (in_array($fileActualExt, $allowed)) {
        if ($fileError === 0) {
            if ($fileSize < 2500000) {
                $sql = "SELECT * FROM users WHERE idUsers=?";
                $stmt = mysqli_stmt_init($conn);
                
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header("Location: ../profile.php?error=sqlerror");
                    exit();
                } else {
                    mysqli_stmt_bind_param($stmt, "s", $idSession);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_store_result($stmt);
                    $resultCheck = mysqli_stmt_num_rows($stmt);

                    $fileNameNew = $picId.".".$fileActualExt;
                    $fileDest = '../uploads/'.$fileNameNew;

                    move_uploaded_file($fileTmpName, $fileDest);


                    $sql = "UPDATE users SET picUsers=? WHERE idUsers=?";
                    $stmt = mysqli_stmt_init($conn);

                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        header("Location: ../profile.php?error=sqlerror");
                        exit();
                    } else {
                        mysqli_stmt_bind_param($stmt, "ii", $picId, $idSession);
                        mysqli_stmt_execute($stmt);
    
                        // Refresh the session to display updated details
                        $_SESSION['userPic'] = $picId;
                        $picId = $_SESSION['userPic'];

                        header("Location: ../profile.php?uploadsuccess");
                        exit();
                    }
                }
            } else {
                header("Location: ../profile.php?uploaderror=filesizetolarge");
                exit();
            }
        } else {
            header("Location: ../profile.php?uploaderror=therewasanuploaderror");
            exit();
        }
    } else {
        header("Location: ../profile.php?uploaderror=filetypenotallowed");
        exit();
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);

} else {
    header("Location: ../index.php");
    exit();
}