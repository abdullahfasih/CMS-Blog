<?php
require_once './models/Category.php';
require_once './models/User.php';
require_once 'views/header.php';
?>

<body>
    <?php
    $objUser->getProfileData();

    if (isset($_SESSION['objUser']->userID)) {
        header('Location:index.php');
    }
    ?>

    <!-- Navigation -->
    <?php
    require_once 'views/nav.php';
    ?>

    <!-- Page Content -->
    <div class="container">

        <section id="login ">
            <div class="container">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <h2 class="text-center"><?php echo $objUser->username ?> - Profile Page</h2>
                        <table class="table table-bordered table-striped table-hover table-responsive">
                            <tr>
                                <th>
                                    <?php
                                    if (isset($_SESSION['msg'])) {
                                        echo $_SESSION['msg'];
                                        unset($_SESSION['msg']);
                                    }
                                    if (isset($_SESSION['errors'])) {
                                        $errors = $_SESSION['errors'];
                                        unset($_SESSION['errors']);
                                    }
                                    ?>
                                    <img src="images/users/<?php echo $objUser->userName . "/" . $objUser->profileImage ?>" class="img-thumbnail" alt="avator" style="display: block; height: 220px; width: auto;">

                                    <form action="process/processProfileImage.php" method="post" enctype="multipart/form-data">
                                        <input type="file" name="profileImage">
                                        <span style="display:block;">
                                            <?php
                                            if (isset($errors['profileImage'])) {
                                                echo $errors['profileImage'];
                                            }
                                            ?>
                                        </span>
                                        <button class="btn btn-primary btn-sm">Change</button>
                                    </form>
                                </th>
                                <td></td>
                            </tr>
                            <tr>
                                <th>Username:</th>
                                <td><?php echo $objUser->username ?></td>
                            </tr>
                            <tr>
                                <th>Email:</th>
                                <td><?php echo $objUser->email ?></td>
                            </tr>
                            <tr>
                                <th>First Name:</th>
                                <td><?php echo $objUser->firstName ?></td>
                            </tr>
                            <tr>
                                <th>Last Name:</th>
                                <td><?php echo $objUser->lastName ?></td>
                            </tr>
                            <tr>
                                <th>User Role:</th>
                                <td><?php echo $objUser->userRole ?></td>
                            </tr>
                        </table>
                        <div style="display: inline-block"><a href="changePassword.php" class="btn btn-danger">Change Password</a></div>
                        <div style="display: inline-block; float: right;"><a href="editProfile.php" class="btn btn-warning">Edit Profile</a></div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </section>

        <hr>
        <!-- Footer -->
        <?php
        require_once 'views/footer.php';
        ?>
