<?php
require_once './models/Category.php';
require_once './models/User.php';
require_once 'views/header.php';
?>

<body>
    <?php
    if (isset($_SESSION['objUser']->userID)) {
        header('Location:index.php');
    }
//    echo "<pre>";
//    print_r($objUser);
//    echo "</pre>";
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
                    <div class="col-sm-6 col-sm-offset-3">
                        <div class="form-wrap">
                            <h1>Edit Profile - <?php echo $objUser->username ?></h1>
                            <form role="form" action="process/processProfile.php" method="post" id="login-form " class="form-group register-form" autocomplete="off">
                                <h5 class="text-center">
                                    <?php
                                    if (isset($_SESSION['msg'])) {
                                        echo ($_SESSION['msg']);
                                        unset($_SESSION['msg']);
                                    }
                                    if (isset($_SESSION['msgErr'])) {
                                        echo ($_SESSION['msgErr']);
                                        unset($_SESSION['msgErr']);
                                    }
                                    if (isset($_SESSION['errors'])) {
                                        $errors = $_SESSION['errors'];
                                        unset($_SESSION['errors']);
                                    }
                                    ?>
                                </h5>
                                <div class="form-group">
                                    <label for="username" class="sr-only">Username</label>
                                    <input type="text" name="userName" id="username" value="<?php echo $objUser->username ?>" placeholder="Enter desired username" class="form-control" readonly>
                                    <span>
                                        <?php
                                        if (isset($errors['userName']))
                                            echo $errors['userName'];
                                        ?>
                                    </span>
                                </div>
                                <div class="form-group">
                                    <label for="email" class="sr-only">Email</label>
                                    <input type="email" name="email" id="email" value="<?php echo $objUser->email ?>" placeholder="somebody@example.com" class="form-control" readonly>
                                    <span>
                                        <?php
                                        if (isset($errors['email']))
                                            echo $errors['email'];
                                        ?>
                                    </span>
                                </div>
                                <div class="form-group">
                                    <label for="firstName" class="sr-only">First Name</label>
                                    <input type="text" name="firstName" id="firstName" value="<?php echo $objUser->firstName ?>" placeholder="Enter desired firstName" class="form-control">
                                    <span>
                                        <?php
                                        if (isset($errors['userName']))
                                            echo $errors['userName'];
                                        ?>
                                    </span>
                                </div>
                                <div class="form-group">
                                    <label for="lastName" class="sr-only">Last Name</label>
                                    <input type="text" name="lastName" id="lastName" value="<?php echo $objUser->lastName ?>" placeholder="Enter desired lastName" class="form-control" >
                                    <span>
                                        <?php
                                        if (isset($errors['userName']))
                                            echo $errors['userName'];
                                        ?>
                                    </span>
                                </div>
                                <input type="submit" name="updateProfile" id="btn-login" value="Update Profile" class="btn btn-custom btn-lg btn-block">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <hr>

        <!-- Footer -->
        <?php
        require_once 'views/footer.php';
        ?>
