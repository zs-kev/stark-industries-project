<?php

    include('header.php');

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Profile</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">User Profile</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <!-- Profile Image -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-primary card-outline">
                                <div class="card-body box-profile">
                                    <div class="text-center">
                                        <?php
                                
                                            include('includes/dbh.inc.php');

                                            $sql = "SELECT * FROM users";
                                            $result = mysqli_query($conn, $sql);
                      
                                            if (mysqli_num_rows($result) > 0) {
                                                if ($row = mysqli_fetch_assoc($result)) {
                                                    $userId = $_SESSION['userId'];
                                                    $picId = $_SESSION['userPic'];

                                                    $fileName = "uploads/".$picId."*";
                                                    $filePath = glob($fileName);
                                                    $fileExt = explode(".", $filePath['0']);
                                                    $fileActualExt = $fileExt[1];

                                                    if ($userId == $picId) {
                                                        $profilePic = "uploads/".$picId."."."$fileActualExt";
                                                    } else {
                                                        $profilePic = "uploads/profile_default_image_stkindustries2020.jpg";
                                                    }
                                        
                                                    if ($row['picUsers'] == $userId) {
                                                        echo '<img class="profile-user-img img-fluid img-circle" src="'.$profilePic.'?'.mt_rand().'"
                                                alt="User profile picture">';
                                                    } else {
                                                        echo '<img class="profile-user-img img-fluid img-circle" src="'.$profilePic.'?'.mt_rand().'"
                                                alt="Default User profile picture">';
                                                    }
                                                }
                                            }

                                        ?>
                                    </div>

                                    <h3 class="profile-username text-center"><?= $_SESSION['userName']; ?></h3>

                                    <p class="text-muted text-center">
                                        <?php

                                            if ($_SESSION['userAdmin']) {
                                                echo "Admin";
                                            } else {
                                                echo "User";
                                            }
                    
                                        ?>
                                    </p>
                                </div>
                                <div class="row">
                                    <div class="col-6">

                                        <?php

                                            if (isset($_GET['success'])) {
                                                if ($_GET['success'] == "contactaboutupdated") {
                                                
                                                    echo '<div class="card-body">
                                                            <div class="alert alert-success alert-dismissible">
                                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                                                <h5><i class="icon fas fa-check"></i> Success!</h5>
                                                                Your contact details and about profile have been updated
                                                            </div>
                                                        </div>';

                                                    } else if ($_GET['success'] == "contactupdated") {
                                                        echo '<div class="card-body">
                                                            <div class="alert alert-success alert-dismissible">
                                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                                                <h5><i class="icon fas fa-check"></i> Success!</h5>
                                                                Your contact details have been updated
                                                            </div>
                                                        </div>';
                                                    } else if ($_GET['success'] == "aboutupdated") {
                                                        echo '<div class="card-body">
                                                            <div class="alert alert-success alert-dismissible">
                                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                                                <h5><i class="icon fas fa-check"></i> Success!</h5>
                                                                Your About profile has been updated
                                                            </div>
                                                        </div>';
                                                    }
                                            } else if (isset($_GET['error'])) {
                                                if ($_GET['error'] == "sqlerror") {
                                                
                                                    echo '<div class="alert alert-danger alert-dismissible">
                                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                                                <h5><i class="icon fas fa-ban"></i> Error!</h5>
                                                                There was a problem connecting to the database, please try again later.
                                                        </div>';

                                                    }
                                            }

                                        ?>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="card-body">
                                            <form action="includes/profile.inc.php" method="post">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Email address</label>
                                                        <input type="email" name="email"
                                                            value="<?= $_SESSION['userEmail']; ?>" class="form-control"
                                                            id="exampleInputEmail1" required
                                                            pattern="^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="exampleInputPassword1">Change Password</label>
                                                        <input type="password" name="pwd" class="form-control"
                                                            id="exampleInputPassword1" placeholder="Password">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="exampleInputPassword1">Change Password
                                                            Repeat</label>
                                                        <input type="password" name="pwd-repeat" class="form-control"
                                                            id="exampleInputPassword1" placeholder="Password">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div>
                                                        <button type="submit" class="btn btn-primary"
                                                            name="profile-submit">Submit</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->


                                    <!-- </div> -->
                                    <!-- /.card -->

                                    <div class="col-6">
                                        <div class="card-body">
                                            <form action="includes/about.inc.php" method="post" role="form">
                                                <!-- text input -->
                                                <div class="col-12">
                                                    <!-- textarea -->
                                                    <div class="form-group">
                                                        <label>About</label>
                                                        <textarea class="form-control" name="about" rows="3"
                                                            placeholder="What do you do at Stark Industries?"><?= $_SESSION['userAbout']; ?></textarea>
                                                    </div>
                                                </div>
                                                <!-- phone mask -->
                                                <div class="form-group">
                                                    <div class="col-12">
                                                        <label>Phone Number:</label>

                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i
                                                                        class="fas fa-phone"></i></span>
                                                            </div>
                                                            <input type="text" class="form-control" name="phone"
                                                                value="<?= $_SESSION['userContact']; ?>"
                                                                data-inputmask="'mask': ['999-999-9999 [x99999]', '+099 99 99 9999[9]-9999']"
                                                                data-mask>
                                                        </div>
                                                        <!-- /.input group -->
                                                    </div>
                                                </div>
                                                <!-- /.form group -->
                                                <div class="col-12">
                                                    <div>
                                                        <button type="submit" class="btn btn-primary"
                                                            name="about-submit">Submit</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="card-body">
                                            <form action="includes/upload.inc.php" method="post"
                                                enctype="multipart/form-data">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="exampleInputFile">Change profile picture</label>
                                                        <div class="input-group">
                                                            <div class="custom-file">
                                                                <input type="file" name="pic" class="custom-file-input"
                                                                    id="exampleInputFile">
                                                                <label class="custom-file-label"
                                                                    for="exampleInputFile">Choose
                                                                    file</label>
                                                            </div>
                                                            <div class="input-group-append">
                                                                <button type="submit" name="upload-submit"
                                                                    class="input-group-text" id="">Upload</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.card -->
</div>

<?php

    include('footer.php');

?>